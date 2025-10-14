<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="text-center">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">Bienvenue sur le site</h1>

        <?php if (!isset($_SESSION['user'])): ?>
            <div class="space-x-4">
                <a href="/views/login.php" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Connexion</a>
                <a href="/views/register.php" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Inscription</a>
            </div>
        <?php else: ?>
            <p class="text-lg mb-4">Bonjour, <span class="font-semibold"><?= htmlspecialchars($_SESSION['user']['login']) ?></span></p>
            <a href="/views/dashboard.php" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Accéder au tableau de bord</a>
        <?php endif; ?>
    </div>

</body>
</html>
