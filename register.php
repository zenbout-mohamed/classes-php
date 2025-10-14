<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/User-pdo.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');

    if ($login && $password && $firstname) {
        $user = new UserPDO();
        $result = $user->register($login, $password, $email, $firstname, $lastname);
        if ($result) {
            $_SESSION['user'] = $result;
            header("Location: index.php");
            exit;
        } else {
            $error = 'Erreur lors de l’inscription, login peut-être déjà utilisé.';
        }
    } else {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    }
}
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-xl mt-10">
    <h1 class="text-2xl font-bold text-center text-indigo-600 mb-6">Créer un compte</h1>

    <?php if ($error): ?>
        <p class="text-red-600 mb-4"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" class="space-y-4">
        <input type="text" name="login" placeholder="Login" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
        <input type="email" name="email" placeholder="Email"
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
        <input type="text" name="firstname" placeholder="Prénom" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
        <input type="text" name="lastname" placeholder="Nom"
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
        <input type="password" name="password" placeholder="Mot de passe" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
        <button type="submit"
                class="w-full py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Inscription
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
        <a href="login.php" class="text-blue-600 hover:underline">Vous avez déjà un compte ? Connectez-vous</a>
    </p>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
