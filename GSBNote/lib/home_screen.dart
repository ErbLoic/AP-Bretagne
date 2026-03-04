import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'details.dart';
import 'auth_service.dart';
import 'login_page.dart';

class Accueil extends StatefulWidget {
  const Accueil({super.key});

  @override
  State<Accueil> createState() => _AccueilState();
}

class _AccueilState extends State<Accueil> {
  List praticiens = [];
  List filteredPraticiens = [];
  bool isLoading = true;
  var api = "http://172.23.48.1/api/praticiens";
  final TextEditingController _searchController = TextEditingController();
  bool isSearching = false;

  @override
  void initState() {
    super.initState();
    fetchpraticiens();
    _searchController.addListener(_filterPraticiens);
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  void fetchpraticiens() {
    var url = Uri.parse(api);
    http
        .get(url)
        .then((value) {
          if (value.statusCode == 200) {
            var data = json.decode(value.body);
            setState(() {
              if (data is Map) {
                praticiens =
                    data['data'] ?? data['praticiens'] ?? data['results'] ?? [];
              } else if (data is List) {
                praticiens = data;
              }
              filteredPraticiens = praticiens;
              isLoading = false;
            });
          }
        })
        .catchError((e) {
          setState(() {
            isLoading = false;
          });
        });
  }

  void _filterPraticiens() {
    final query = _searchController.text;
    if (query.isEmpty) {
      setState(() {
        filteredPraticiens = praticiens;
        isSearching = false;
      });
    } else {
      setState(() {
        isSearching = true;
        _searchPraticiens(query);
      });
    }
  }

  void _searchPraticiens(String query) {
    var searchUrl = Uri.parse(
      'http://172.23.48.1/api/praticiens/search?search=$query',
    );
    http
        .get(searchUrl)
        .then((value) {
          if (value.statusCode == 200) {
            var data = json.decode(value.body);
            setState(() {
              if (data is Map) {
                filteredPraticiens =
                    data['data'] ?? data['praticiens'] ?? data['results'] ?? [];
              } else if (data is List) {
                filteredPraticiens = data;
              }
            });
          }
        })
        .catchError((e) {
          setState(() {
            filteredPraticiens = [];
          });
        });
  }

  @override
  Widget build(BuildContext context) {
    final colorScheme = Theme.of(context).colorScheme;

    return Scaffold(
      backgroundColor: colorScheme.surface,
      body: CustomScrollView(
        slivers: [
          // AppBar moderne avec gradient
          SliverAppBar(
            expandedHeight: 200,
            floating: false,
            pinned: true,
            actions: [_buildAuthButton(context, colorScheme)],
            flexibleSpace: FlexibleSpaceBar(
              title: const Text(
                'Praticiens',
                style: TextStyle(
                  fontWeight: FontWeight.w700,
                  letterSpacing: -0.5,
                ),
              ),
              background: Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [
                      colorScheme.primary,
                      colorScheme.primary.withOpacity(0.8),
                    ],
                  ),
                ),
                child: Stack(
                  children: [
                    Positioned(
                      right: -50,
                      top: -50,
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
                      left: -30,
                      bottom: -30,
                      child: Container(
                        width: 120,
                        height: 120,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          color: Colors.white.withOpacity(0.08),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),

          // Barre de recherche
          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.fromLTRB(16, 12, 16, 12),
              child: TextField(
                controller: _searchController,
                decoration: InputDecoration(
                  hintText: 'Rechercher un praticien...',
                  prefixIcon: Icon(
                    Icons.search_rounded,
                    color: colorScheme.outline.withOpacity(0.6),
                  ),
                  suffixIcon: _searchController.text.isNotEmpty
                      ? GestureDetector(
                          onTap: () {
                            _searchController.clear();
                          },
                          child: Icon(
                            Icons.clear_rounded,
                            color: colorScheme.outline.withOpacity(0.6),
                          ),
                        )
                      : null,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide(
                      color: colorScheme.outline.withOpacity(0.2),
                    ),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide(
                      color: colorScheme.primary,
                      width: 2,
                    ),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide(
                      color: colorScheme.outline.withOpacity(0.2),
                    ),
                  ),
                  filled: true,
                  fillColor: colorScheme.surface,
                  contentPadding: const EdgeInsets.symmetric(
                    horizontal: 16,
                    vertical: 12,
                  ),
                  hintStyle: TextStyle(
                    color: colorScheme.outline.withOpacity(0.5),
                  ),
                ),
              ),
            ),
          ),

          // Contenu
          if (isLoading)
            const SliverFillRemaining(
              child: Center(child: CircularProgressIndicator()),
            )
          else if (filteredPraticiens.isEmpty)
            SliverFillRemaining(
              child: Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(
                      Icons.person_search_rounded,
                      size: 80,
                      color: colorScheme.outline.withOpacity(0.5),
                    ),
                    const SizedBox(height: 16),
                    Text(
                      'Aucun praticien trouvé',
                      style: TextStyle(
                        fontSize: 18,
                        color: colorScheme.outline,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
            )
          else
            SliverPadding(
              padding: const EdgeInsets.all(16),
              sliver: SliverList(
                delegate: SliverChildBuilderDelegate((context, index) {
                  final praticien = filteredPraticiens[index];
                  return _buildPraticienCard(context, praticien, index);
                }, childCount: filteredPraticiens.length),
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildAuthButton(BuildContext context, ColorScheme colorScheme) {
    final auth = AuthService();

    return Container(
      margin: const EdgeInsets.only(right: 8, top: 8),
      child: auth.isLoggedIn
          ? PopupMenuButton<String>(
              offset: const Offset(0, 50),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(16),
              ),
              child: Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 12,
                  vertical: 8,
                ),
                decoration: BoxDecoration(
                  color: Colors.white.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const Icon(
                      Icons.person_rounded,
                      color: Colors.white,
                      size: 20,
                    ),
                    const SizedBox(width: 6),
                    Text(
                      auth.userEmail?.split('@').first ?? 'Utilisateur',
                      style: const TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.w500,
                        fontSize: 13,
                      ),
                    ),
                  ],
                ),
              ),
              itemBuilder: (context) => [
                PopupMenuItem(
                  value: 'profile',
                  child: Row(
                    children: [
                      Icon(Icons.person_outline, color: colorScheme.primary),
                      const SizedBox(width: 12),
                      Text(auth.userEmail?.split('@').first ?? 'Utilisateur'),
                    ],
                  ),
                ),
                const PopupMenuDivider(),
                PopupMenuItem(
                  value: 'logout',
                  child: Row(
                    children: [
                      const Icon(Icons.logout_rounded, color: Colors.red),
                      const SizedBox(width: 12),
                      const Text(
                        'Déconnexion',
                        style: TextStyle(color: Colors.red),
                      ),
                    ],
                  ),
                ),
              ],
              onSelected: (value) {
                if (value == 'logout') {
                  auth.logout();
                  setState(() {});
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(
                      content: const Row(
                        children: [
                          Icon(Icons.check_circle, color: Colors.white),
                          SizedBox(width: 12),
                          Text('Déconnexion réussie'),
                        ],
                      ),
                      backgroundColor: colorScheme.primary,
                      behavior: SnackBarBehavior.floating,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                  );
                }
              },
            )
          : GestureDetector(
              onTap: () async {
                final result = await Navigator.push<bool>(
                  context,
                  PageRouteBuilder(
                    pageBuilder: (context, animation, secondaryAnimation) =>
                        const LoginPage(),
                    transitionsBuilder:
                        (context, animation, secondaryAnimation, child) {
                          return FadeTransition(
                            opacity: animation,
                            child: SlideTransition(
                              position:
                                  Tween<Offset>(
                                    begin: const Offset(0, 0.1),
                                    end: Offset.zero,
                                  ).animate(
                                    CurvedAnimation(
                                      parent: animation,
                                      curve: Curves.easeOutCubic,
                                    ),
                                  ),
                              child: child,
                            ),
                          );
                        },
                    transitionDuration: const Duration(milliseconds: 300),
                  ),
                );
                if (result == true) {
                  setState(() {});
                }
              },
              child: Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 16,
                  vertical: 8,
                ),
                decoration: BoxDecoration(
                  color: Colors.white.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(Icons.login_rounded, color: Colors.white, size: 18),
                    SizedBox(width: 8),
                    Text(
                      'Connexion',
                      style: TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.w600,
                        fontSize: 13,
                      ),
                    ),
                  ],
                ),
              ),
            ),
    );
  }

  Widget _buildPraticienCard(BuildContext context, Map praticien, int index) {
    final colorScheme = Theme.of(context).colorScheme;
    final note =
        double.tryParse(praticien['note_global']?.toString() ?? '0') ?? 0;

    return TweenAnimationBuilder<double>(
      tween: Tween(begin: 0, end: 1),
      duration: Duration(milliseconds: 400 + (index * 100)),
      curve: Curves.easeOutCubic,
      builder: (context, value, child) {
        return Transform.translate(
          offset: Offset(0, 30 * (1 - value)),
          child: Opacity(opacity: value, child: child),
        );
      },
      child: Container(
        margin: const EdgeInsets.only(bottom: 16),
        decoration: BoxDecoration(
          color: colorScheme.surface,
          borderRadius: BorderRadius.circular(20),
          border: Border.all(color: colorScheme.outline.withOpacity(0.1)),
          boxShadow: [
            BoxShadow(
              color: colorScheme.shadow.withOpacity(0.08),
              blurRadius: 20,
              offset: const Offset(0, 8),
            ),
          ],
        ),
        child: Material(
          color: Colors.transparent,
          borderRadius: BorderRadius.circular(20),
          child: InkWell(
            onTap: () {
              Navigator.push(
                context,
                PageRouteBuilder(
                  pageBuilder: (context, animation, secondaryAnimation) =>
                      Details(praticienId: praticien["id"]),
                  transitionsBuilder:
                      (context, animation, secondaryAnimation, child) {
                        return FadeTransition(
                          opacity: animation,
                          child: SlideTransition(
                            position:
                                Tween<Offset>(
                                  begin: const Offset(0.05, 0),
                                  end: Offset.zero,
                                ).animate(
                                  CurvedAnimation(
                                    parent: animation,
                                    curve: Curves.easeOutCubic,
                                  ),
                                ),
                            child: child,
                          ),
                        );
                      },
                  transitionDuration: const Duration(milliseconds: 300),
                ),
              );
            },
            borderRadius: BorderRadius.circular(20),
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Row(
                children: [
                  // Avatar
                  Container(
                    width: 60,
                    height: 60,
                    decoration: BoxDecoration(
                      gradient: LinearGradient(
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight,
                        colors: [
                          colorScheme.primaryContainer,
                          colorScheme.primary.withOpacity(0.3),
                        ],
                      ),
                      borderRadius: BorderRadius.circular(16),
                    ),
                    child: Center(
                      child: Text(
                        _getInitials(praticien['prenom'], praticien['nom']),
                        style: TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                          color: colorScheme.primary,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 16),

                  // Info praticien
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          '${praticien['prenom'] ?? ''} ${praticien['nom'] ?? 'Inconnu'}',
                          style: const TextStyle(
                            fontSize: 17,
                            fontWeight: FontWeight.w600,
                            letterSpacing: -0.3,
                          ),
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                        ),
                        const SizedBox(height: 4),
                        Row(
                          children: [
                            Icon(
                              Icons.badge_outlined,
                              size: 14,
                              color: colorScheme.outline,
                            ),
                            const SizedBox(width: 4),
                            Text(
                              'ID: ${praticien['id']}',
                              style: TextStyle(
                                fontSize: 13,
                                color: colorScheme.outline,
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),

                  // Note
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 12,
                      vertical: 8,
                    ),
                    decoration: BoxDecoration(
                      color: _getNoteColor(note).withOpacity(0.15),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(
                          Icons.star_rounded,
                          size: 18,
                          color: _getNoteColor(note),
                        ),
                        const SizedBox(width: 4),
                        Text(
                          praticien['note_global']?.toString() ?? '0',
                          style: TextStyle(
                            fontSize: 15,
                            fontWeight: FontWeight.bold,
                            color: _getNoteColor(note),
                          ),
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(width: 8),
                  Icon(
                    Icons.chevron_right_rounded,
                    color: colorScheme.outline.withOpacity(0.5),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  String _getInitials(String? prenom, String? nom) {
    final p = prenom?.isNotEmpty == true ? prenom![0].toUpperCase() : '';
    final n = nom?.isNotEmpty == true ? nom![0].toUpperCase() : '';
    return '$p$n'.isEmpty ? '?' : '$p$n';
  }
}

Color _getNoteColor(double note) {
  if (note >= 4.0) return const Color(0xFF10B981);
  if (note >= 3.0) return const Color(0xFFF59E0B);
  if (note >= 2.0) return const Color(0xFFF97316);
  return const Color(0xFFEF4444);
}
