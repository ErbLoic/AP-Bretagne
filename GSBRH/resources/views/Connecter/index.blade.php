<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <title>Se connecter</title>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">
    <form action="{{ route('login.post') }}" method="POST" class="p-4 bg-white rounded shadow-sm" style="width:300px;">
    @csrf
    <h2 class="text-center mb-4">Connexion</h2>

    <div class="mb-3">
        <label for="identifiant" class="form-label">Identifiant :</label>
        <input type="text" id="identifiant" name="identifiant" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="mdp" class="form-label">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" class="form-control" required>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
</form>


</body>
</html>