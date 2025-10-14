<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/User-pdo.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login && $password) {
        $user = new UserPDO();
        if ($user->connect($login, $password)) {
            $_SESSION['user'] = $user->getAllInfos();
            header("Location: index.php");
            exit;
        } else {
            $error = 'Login ou mot de passe incorrect.';
        }
    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion</h1>

    <?php if ($error): ?>
        <p class="text-red-600 mb-4"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" class="space-y-4">
        <input type="text" name="login" placeholder="Login" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
        <input type="password" name="password" placeholder="Mot de passe" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Connexion
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
        <a href="register.php" class="text-blue-600 hover:underline">Pas de compte ? Inscrivez-vous</a>
    </p>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
