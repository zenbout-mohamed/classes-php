<?php
require_once __DIR__ . '/includes/header.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<div class="bg-white shadow-md rounded p-6 text-center max-w-md mx-auto mt-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Bienvenue, <?= htmlspecialchars($user['firstname']) ?> !</h2>
    <p class="text-gray-600 mb-6">
        Vous êtes connecté avec le login <strong><?= htmlspecialchars($user['login']) ?></strong>.
    </p>
    <a href="logout.php" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Déconnexion</a>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
