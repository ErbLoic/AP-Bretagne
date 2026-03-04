<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Page de Connexion</h1>

        <div class="card shadow p-4 mx-auto" style="max-width: 400px;">
            <form method="POST" action="/authenticate">
                @csrf

                <div class="mb-3">
                    <label for="identifiant" class="form-label">Identifiant :</label>
                    <input type="text" class="form-control" id="identifiant" name="identifiant" required>
                </div>

                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe :</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" required>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>

</body>
</html>
