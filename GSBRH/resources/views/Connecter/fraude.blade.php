<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stop à la fraude</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 20px;
        }
        .message {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: left;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #e74c3c;
        }
        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: #3498db;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background .15s ease;
        }
        .btn:hover { background: #2b86c6; }
        ul { margin-top: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">⚠️</div>
        <h1>La fraude n'est pas la solution</h1>
        <div class="message">
            <p>Ce n'est pas bien de frauder en modifiant l'URL. Connecte-toi comme tout le monde en utilisant le formulaire de connexion.</p>
            <p>La fraude est un acte malhonnête qui :</p>
            <ul>
                <li>Nuit à la société dans son ensemble</li>
                <li>Peut avoir des conséquences légales graves</li>
                <li>Détruit la confiance entre les personnes</li>
                <li>N'est jamais une solution durable</li>
            </ul>
            <p>Fais le bon choix : reste honnête et respecte les règles.</p>
        </div>

        <!-- Bouton qui renvoie vers la route racine -->
        <a href="{{ url('/') }}" class="btn">Se connecter</a>
    </div>
</body>
</html>