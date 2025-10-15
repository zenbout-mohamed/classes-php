<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classes-php</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<header class="bg-indigo-600 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">Mon Projet</h1>
        <nav class="space-x-4">
            <?php if (!empty($_SESSION['user'])): ?>
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['firstname']) ?></span>
                <a href="logout.php" class="hover:underline">Déconnexion</a>
            <?php else: ?>
                <a href="login.php" class="hover:underline">Connexion</a>
                <a href="register.php" class="hover:underline">Inscription</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container mx-auto p-6">
