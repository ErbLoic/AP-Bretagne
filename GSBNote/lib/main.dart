import 'package:flutter/material.dart';
import 'home_screen.dart';

void main() {
  runApp(Appreciations());
}

class Appreciations extends StatelessWidget {
  const Appreciations({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(debugShowCheckedModeBanner: false, home: Accueil());
  }
}
