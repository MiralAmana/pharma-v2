<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Commande Confirmée</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-lg text-center max-w-lg">
        <div class="text-6xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-green-600 mb-2">Merci pour votre commande !</h1>
        <p class="text-gray-600 mb-6">
            Votre commande <strong>#{{ $commande->reference }}</strong> a bien été enregistrée.
            Elle est en attente de validation par le pharmacien.
        </p>
        <a href="/" class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900">
            Retour à l'accueil
        </a>
    </div>
</body>
</html>