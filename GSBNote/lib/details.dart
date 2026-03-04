import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'auth_service.dart';

class Details extends StatefulWidget {
  final int praticienId;

  const Details({super.key, required this.praticienId});

  @override
  State<Details> createState() => _DetailsState();
}

class _DetailsState extends State<Details> with TickerProviderStateMixin {
  late TabController _tabController;
  Map<String, dynamic>? praticien;
  List notes = [];
  bool isLoading = true;
  String? errorMessage;

  late String api;
  late String note;

  // Contrôleurs pour la création de note
  late TextEditingController _commentaireController;
  double _noteValue = 10;
  bool _isSubmittingNote = false;

  @override
  void initState() {
    super.initState();
    api = "http://172.23.48.1/api/praticiens/${widget.praticienId}";
    note = "http://172.23.48.1/api/notes/${widget.praticienId}";
    _tabController = TabController(length: 2, vsync: this);
    _commentaireController = TextEditingController();
    fetchpraticiens();
  }

  Future<void> fetchpraticiens() async {
    setState(() {
      isLoading = true;
      errorMessage = null;
    });

    try {
      var url = Uri.parse(api);
      var response = await http.get(url);

      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        setState(() {
          praticien = data['data'];
        });
      } else {
        throw Exception("Erreur HTTP ${response.statusCode}");
      }

      url = Uri.parse(note);
      response = await http.get(url);

      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        setState(() {
          notes = data;
        });
      }

      setState(() {
        isLoading = false;
      });
    } catch (error) {
      setState(() {
        isLoading = false;
        errorMessage = error.toString();
      });
    }
  }

  @override
  void dispose() {
    _tabController.dispose();
    _commentaireController.dispose();
    super.dispose();
  }

  List get notesClients => notes.where((n) => n['id_expert'] == null).toList();
  List get notesExperts => notes.where((n) => n['id_expert'] != null).toList();

  @override
  Widget build(BuildContext context) {
    final colorScheme = Theme.of(context).colorScheme;

    return Scaffold(
      backgroundColor: colorScheme.surface,
      body: CustomScrollView(
        slivers: [
          // AppBar avec effet hero
          SliverAppBar(
            expandedHeight: 200,
            pinned: true,
            stretch: true,
            leading: Container(
              margin: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: Colors.black.withOpacity(0.3),
                shape: BoxShape.circle,
              ),
              child: IconButton(
                icon: const Icon(Icons.arrow_back_rounded, color: Colors.white),
                onPressed: () => Navigator.pop(context),
              ),
            ),
            actions: [
              if (AuthService().isLoggedIn)
                Container(
                  margin: const EdgeInsets.only(right: 8, top: 8),
                  child: Material(
                    color: Colors.transparent,
                    child: Tooltip(
                      message: 'Ajouter une note',
                      child: InkWell(
                        onTap: _showAddNoteDialog,
                        borderRadius: BorderRadius.circular(12),
                        child: Container(
                          padding: const EdgeInsets.all(8),
                          decoration: BoxDecoration(
                            color: Colors.white.withOpacity(0.2),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: const Icon(
                            Icons.star_outline_rounded,
                            color: Colors.white,
                            size: 20,
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
            ],
            flexibleSpace: FlexibleSpaceBar(
              background: Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [
                      colorScheme.primary,
                      colorScheme.primary.withOpacity(0.7),
                      colorScheme.secondary,
                    ],
                  ),
                ),
                child: Stack(
                  children: [
                    // Cercles décoratifs
                    Positioned(
                      right: -60,
                      top: -60,
                      child: Container(
                        width: 200,
                        height: 200,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          color: Colors.white.withOpacity(0.1),
                        ),
                      ),
                    ),
                    Positioned(
                      left: -40,
                      bottom: 20,
                      child: Container(
                        width: 150,
                        height: 150,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          color: Colors.white.withOpacity(0.08),
                        ),
                      ),
                    ),
                    // Contenu central
                    if (!isLoading && praticien != null)
                      Center(
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            const SizedBox(height: 40),
                            // Avatar
                            Container(
                              width: 80,
                              height: 80,
                              decoration: BoxDecoration(
                                color: Colors.white,
                                shape: BoxShape.circle,
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.black.withOpacity(0.2),
                                    blurRadius: 20,
                                    offset: const Offset(0, 10),
                                  ),
                                ],
                              ),
                              child: Center(
                                child: Text(
                                  _getInitials(
                                    praticien!['prenom'],
                                    praticien!['nom'],
                                  ),
                                  style: TextStyle(
                                    fontSize: 28,
                                    fontWeight: FontWeight.bold,
                                    color: colorScheme.primary,
                                  ),
                                ),
                              ),
                            ),
                            const SizedBox(height: 12),
                            // Nom
                            Text(
                              '${praticien!['prenom'] ?? ''} ${praticien!['nom'] ?? ''}',
                              style: const TextStyle(
                                fontSize: 22,
                                fontWeight: FontWeight.bold,
                                color: Colors.white,
                                letterSpacing: -0.5,
                              ),
                            ),
                            const SizedBox(height: 4),
                            // ID
                            Container(
                              padding: const EdgeInsets.symmetric(
                                horizontal: 12,
                                vertical: 4,
                              ),
                              decoration: BoxDecoration(
                                color: Colors.white.withOpacity(0.2),
                                borderRadius: BorderRadius.circular(20),
                              ),
                              child: Text(
                                'ID: ${praticien!['id']}',
                                style: const TextStyle(
                                  fontSize: 13,
                                  color: Colors.white,
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                  ],
                ),
              ),
            ),
          ),

          // Contenu principal
          if (isLoading)
            const SliverFillRemaining(
              child: Center(child: CircularProgressIndicator()),
            )
          else if (errorMessage != null)
            SliverFillRemaining(child: _buildErrorWidget(colorScheme))
          else
            SliverToBoxAdapter(
              child: Column(
                children: [
                  // Cartes de notes
                  Padding(
                    padding: const EdgeInsets.all(20),
                    child: Row(
                      children: [
                        Expanded(
                          child: _buildNoteCard(
                            'Globale',
                            praticien!['note_global'] ?? '0',
                            colorScheme.primary,
                            Icons.star_rounded,
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: _buildNoteCard(
                            'Client',
                            praticien!['note_client'] ?? '0',
                            const Color(0xFF3B82F6),
                            Icons.person_rounded,
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: _buildNoteCard(
                            'Expert',
                            praticien!['note_expert'] ?? '0',
                            const Color(0xFF10B981),
                            Icons.verified_rounded,
                          ),
                        ),
                      ],
                    ),
                  ),

                  // Info praticien
                  if (praticien!['adresse'] != null ||
                      praticien!['ville'] != null)
                    Container(
                      margin: const EdgeInsets.symmetric(horizontal: 20),
                      padding: const EdgeInsets.all(20),
                      decoration: BoxDecoration(
                        color: colorScheme.surface,
                        borderRadius: BorderRadius.circular(20),
                        border: Border.all(
                          color: colorScheme.outline.withOpacity(0.1),
                        ),
                        boxShadow: [
                          BoxShadow(
                            color: colorScheme.shadow.withOpacity(0.05),
                            blurRadius: 20,
                            offset: const Offset(0, 4),
                          ),
                        ],
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            children: [
                              Container(
                                padding: const EdgeInsets.all(10),
                                decoration: BoxDecoration(
                                  color: colorScheme.primaryContainer
                                      .withOpacity(0.5),
                                  borderRadius: BorderRadius.circular(12),
                                ),
                                child: Icon(
                                  Icons.location_on_rounded,
                                  color: colorScheme.primary,
                                  size: 22,
                                ),
                              ),
                              const SizedBox(width: 12),
                              Text(
                                'Localisation',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.w600,
                                  color: colorScheme.onSurface,
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 16),
                          if (praticien!['adresse'] != null)
                            _buildInfoRow(
                              Icons.home_rounded,
                              'Adresse',
                              praticien!['adresse'],
                              colorScheme,
                            ),
                          if (praticien!['ville'] != null) ...[
                            const SizedBox(height: 12),
                            _buildInfoRow(
                              Icons.location_city_rounded,
                              'Ville',
                              '${praticien!['ville']['nom_ville']} (${praticien!['ville']['code_postal']})',
                              colorScheme,
                            ),
                          ],
                        ],
                      ),
                    ),

                  const SizedBox(height: 24),

                  // Onglets
                  Container(
                    margin: const EdgeInsets.symmetric(horizontal: 20),
                    decoration: BoxDecoration(
                      color: colorScheme.surfaceContainerHighest.withOpacity(
                        0.5,
                      ),
                      borderRadius: BorderRadius.circular(16),
                    ),
                    child: TabBar(
                      controller: _tabController,
                      labelColor: Colors.white,
                      unselectedLabelColor: colorScheme.outline,
                      indicatorSize: TabBarIndicatorSize.tab,
                      dividerHeight: 0,
                      indicator: BoxDecoration(
                        color: colorScheme.primary,
                        borderRadius: BorderRadius.circular(16),
                      ),
                      labelStyle: const TextStyle(
                        fontWeight: FontWeight.w600,
                        fontSize: 14,
                      ),
                      tabs: [
                        Tab(
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              const Icon(Icons.person_rounded, size: 18),
                              const SizedBox(width: 8),
                              Text('Clients (${notesClients.length})'),
                            ],
                          ),
                        ),
                        Tab(
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              const Icon(Icons.verified_rounded, size: 18),
                              const SizedBox(width: 8),
                              Text('Experts (${notesExperts.length})'),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),

                  // Contenu des onglets
                  SizedBox(
                    height: 400,
                    child: TabBarView(
                      controller: _tabController,
                      children: [
                        _buildCommentsList(notesClients, false, colorScheme),
                        _buildCommentsList(notesExperts, true, colorScheme),
                      ],
                    ),
                  ),

                  const SizedBox(height: 32),
                ],
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildNoteCard(
    String label,
    String value,
    Color color,
    IconData icon,
  ) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: color.withOpacity(0.1),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: color.withOpacity(0.2)),
      ),
      child: Column(
        children: [
          Icon(icon, color: color, size: 24),
          const SizedBox(height: 8),
          Text(
            value,
            style: TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: color,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            label,
            style: TextStyle(
              fontSize: 12,
              color: color.withOpacity(0.8),
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildInfoRow(
    IconData icon,
    String label,
    String value,
    ColorScheme colorScheme,
  ) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Icon(icon, size: 18, color: colorScheme.outline),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                label,
                style: TextStyle(fontSize: 12, color: colorScheme.outline),
              ),
              const SizedBox(height: 2),
              Text(
                value,
                style: const TextStyle(
                  fontSize: 15,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildCommentsList(
    List comments,
    bool isExpert,
    ColorScheme colorScheme,
  ) {
    if (comments.isEmpty) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              isExpert ? Icons.verified_user_rounded : Icons.person_rounded,
              size: 64,
              color: colorScheme.outline.withOpacity(0.3),
            ),
            const SizedBox(height: 16),
            Text(
              isExpert
                  ? 'Aucun commentaire d\'expert'
                  : 'Aucun commentaire de client',
              style: TextStyle(fontSize: 16, color: colorScheme.outline),
            ),
          ],
        ),
      );
    }

    return ListView.builder(
      padding: const EdgeInsets.all(20),
      itemCount: comments.length,
      itemBuilder: (context, index) {
        final comment = comments[index];
        final accentColor = isExpert
            ? const Color(0xFF10B981)
            : const Color(0xFF3B82F6);

        return Container(
          margin: const EdgeInsets.only(bottom: 12),
          padding: const EdgeInsets.all(16),
          decoration: BoxDecoration(
            color: colorScheme.surface,
            borderRadius: BorderRadius.circular(16),
            border: Border.all(color: accentColor.withOpacity(0.2)),
            boxShadow: [
              BoxShadow(
                color: colorScheme.shadow.withOpacity(0.04),
                blurRadius: 10,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: accentColor.withOpacity(0.1),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Icon(
                      isExpert ? Icons.verified_rounded : Icons.person_rounded,
                      size: 18,
                      color: accentColor,
                    ),
                  ),
                  const SizedBox(width: 12),
                  Text(
                    isExpert ? 'Expert' : 'Client',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      color: accentColor,
                      fontSize: 14,
                    ),
                  ),
                  const Spacer(),
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 10,
                      vertical: 6,
                    ),
                    decoration: BoxDecoration(
                      color: accentColor,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      children: [
                        const Icon(
                          Icons.star_rounded,
                          color: Colors.white,
                          size: 14,
                        ),
                        const SizedBox(width: 4),
                        Text(
                          '${comment['note']}',
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 13,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              Text(
                comment['commentaires'] ?? 'Aucun commentaire',
                style: TextStyle(
                  fontSize: 14,
                  color: colorScheme.onSurface.withOpacity(0.8),
                  height: 1.5,
                ),
              ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildErrorWidget(ColorScheme colorScheme) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(32),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Colors.red.withOpacity(0.1),
                shape: BoxShape.circle,
              ),
              child: const Icon(
                Icons.error_outline_rounded,
                color: Colors.red,
                size: 48,
              ),
            ),
            const SizedBox(height: 24),
            const Text(
              'Erreur de chargement',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 8),
            Text(
              errorMessage ?? 'Une erreur est survenue',
              textAlign: TextAlign.center,
              style: TextStyle(color: colorScheme.outline),
            ),
            const SizedBox(height: 24),
            FilledButton.icon(
              onPressed: fetchpraticiens,
              icon: const Icon(Icons.refresh_rounded),
              label: const Text('Réessayer'),
            ),
          ],
        ),
      ),
    );
  }

  String _getInitials(String? prenom, String? nom) {
    final p = prenom?.isNotEmpty == true ? prenom![0].toUpperCase() : '';
    final n = nom?.isNotEmpty == true ? nom![0].toUpperCase() : '';
    return '$p$n'.isEmpty ? '?' : '$p$n';
  }

  void _showAddNoteDialog() {
    _commentaireController.clear();
    _noteValue = 3;
    final colorScheme = Theme.of(context).colorScheme;

    showDialog(
      context: context,
      builder: (context) => StatefulBuilder(
        builder: (context, setState) => AlertDialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          title: const Text('Ajouter une note'),
          content: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                // Affichage de la note
                Container(
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    color: colorScheme.primaryContainer.withOpacity(0.5),
                    borderRadius: BorderRadius.circular(16),
                  ),
                  child: Column(
                    children: [
                      Text(
                        'Note: ${_noteValue.toStringAsFixed(0)}/5',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: colorScheme.primary,
                        ),
                      ),
                      const SizedBox(height: 12),
                      Slider(
                        value: _noteValue,
                        min: 0,
                        max: 5,
                        divisions: 5,
                        onChanged: (value) {
                          setState(() {
                            _noteValue = value;
                          });
                        },
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 16),
                // Champ commentaire
                TextField(
                  controller: _commentaireController,
                  maxLines: 4,
                  decoration: InputDecoration(
                    hintText: 'Ajouter un commentaire',
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: BorderSide(
                        color: colorScheme.primary,
                        width: 2,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Annuler'),
            ),
            FilledButton(
              onPressed: _isSubmittingNote ? null : _submitNote,
              child: _isSubmittingNote
                  ? const SizedBox(
                      width: 20,
                      height: 20,
                      child: CircularProgressIndicator(strokeWidth: 2),
                    )
                  : const Text('Ajouter'),
            ),
          ],
        ),
      ),
    );
  }

  Future<void> _submitNote() async {
    if (_noteValue < 0 || _noteValue > 5) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('La note doit être entre 0 et 5')),
      );
      return;
    }

    final auth = AuthService();
    if (!auth.isLoggedIn) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Vous devez être connecté pour ajouter une note'),
        ),
      );
      return;
    }

    setState(() {
      _isSubmittingNote = true;
    });

    try {
      final response = await http.post(
        Uri.parse('http://172.23.48.1/api/note/create'),
        headers: auth.getAuthHeaders(),
        body: json.encode({
          'commentaire': _commentaireController.text,
          'note': _noteValue,
          'id_praticien': widget.praticienId,
        }),
      );

      if (mounted) {
        setState(() {
          _isSubmittingNote = false;
        });

        if (response.statusCode == 201) {
          Navigator.pop(context);
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: const Row(
                children: [
                  Icon(Icons.check_circle, color: Colors.white),
                  SizedBox(width: 12),
                  Text('Note ajoutée avec succès'),
                ],
              ),
              backgroundColor: Colors.green,
              behavior: SnackBarBehavior.floating,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
            ),
          );
          // Rafraîchir la liste des notes
          await fetchpraticiens();
        } else {
          final data = json.decode(response.body);
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text(
                data['message'] ?? 'Erreur lors de l\'ajout de la note',
              ),
              backgroundColor: Colors.red,
              behavior: SnackBarBehavior.floating,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
            ),
          );
        }
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _isSubmittingNote = false;
        });
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Erreur: ${e.toString()}'),
            backgroundColor: Colors.red,
            behavior: SnackBarBehavior.floating,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
          ),
        );
      }
    }
  }
}
