import 'dart:convert';
import 'package:http/http.dart' as http;

class AuthService {
  static final AuthService _instance = AuthService._internal();
  factory AuthService() => _instance;
  AuthService._internal();

  static const String _loginUrl = "http://172.23.48.1/api/auth/login";

  String? _token;
  String? _userEmail;
  int? _userId;
  int? _privileges;

  bool get isLoggedIn => _token != null;
  String? get token => _token;
  String? get userEmail => _userEmail;
  int? get userId => _userId;
  int? get privileges => _privileges;

  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse(_loginUrl),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: json.encode({'identifiant': email, 'mdp': password}),
      );

      final data = json.decode(response.body);

      if (response.statusCode == 200 && data['status'] == 'success') {
        _token = data['authorization']['token'];
        _userEmail = data['user']['identifiant'];
        _userId = data['user']['id_praticiens'];
        _privileges = data['user']['privilèges'];

        return {
          'success': true,
          'message': 'Connexion réussie',
          'user': data['user'],
        };
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Identifiants incorrects',
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Erreur de connexion: ${e.toString()}',
      };
    }
  }

  void logout() {
    _token = null;
    _userEmail = null;
    _userId = null;
    _privileges = null;
  }

  Map<String, String> getAuthHeaders() {
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (_token != null) 'Authorization': 'Bearer $_token',
    };
  }
}
