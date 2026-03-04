<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Praticiens</title>
</head>
<body class="bg-light">
    <nav>
        <div class="container-fluid bg-white shadow-sm">
            <div class="d-flex justify-content-between align-items-center p-3">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <h1 class="mb-4 text-center">Liste des Praticiens</h1>
        <form action="{{ route('praticiens.search') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Rechercher par nom" >
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
            <BR>    </BR>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($praticiens as $praticien)
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $praticien->nom }} {{ $praticien->prenom }}</h5>
                            <a href="{{ route('praticiens.show', $praticien->id) }}" class="btn btn-primary mt-3">Voir le profil</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
