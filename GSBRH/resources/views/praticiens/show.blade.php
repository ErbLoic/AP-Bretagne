<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Praticien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav>
        <div class="container-fluid bg-white shadow-sm">
            <div class="d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('logout') }}" class="btn btn-outline-danger">Déconnexion</a>
            </div>
        </div>
    </nav>

<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center">{{ $praticien->nom }} {{ $praticien->prenom }}</h2>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Adresse :</strong> {{ $praticien->adresse }}</li>
                
                <li class="list-group-item"><strong>Ville :</strong> 
                    @php
                        // Décoder le JSON de la ville
                        $ville = json_decode($praticien->ville);
                    @endphp
                    {{ $ville->nom_reel }} ({{ $ville->code_postal }})
                </li>

                <li class="list-group-item"><strong>Ancienneté :</strong> {{ $praticien->anciennete }} ans</li>

                <li class="list-group-item"><strong>Salaire :</strong> {{ $praticien->Echelon->salaire_brut }} €</li>
                <li class="list-group-item"><strong>Echelon :</strong> {{ $praticien->Echelon->id_echelon }}</li>

            </ul>


            <div class="text-center mt-4">
                <a href="{{ route('praticiens.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
