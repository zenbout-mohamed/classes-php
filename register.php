<?php
session_start();
require_once __DIR__ . '/../config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($login) || empty($email) || empty($firstname) || empty($password)) {
        $errors[] = "Tous les champs obligatoires doivent être remplis.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, email, firstname, lastname, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$login, $email, $firstname, $lastname, password_hash($password, PASSWORD_DEFAULT)]);

            $_SESSION['success'] = "Inscription réussie ! Vous pouvez vous connecter.";
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Créer un compte</h2>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700">Login *</label>
                <input type="text" name="login" class="w-full px-4 py-2 border rounded focus:outline-none">
            </div>

            <div>
                <label class="block text-gray-700">Email *</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Prénom *</label>
                    <input type="text" name="firstname" class="w-full px-4 py-2 border rounded focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700">Nom</label>
                    <input type="text" name="lastname" class="w-full px-4 py-2 border rounded focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-gray-700">Mot de passe *</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none">
            </div>

            <button class="w-full py-2 mt-4 bg-blue-600 text-white rounded hover:bg-blue-700">
                S'inscrire
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Déjà un compte ? <a href="login.php" class="text-blue-600 hover:underline">Connexion</a>
        </p>
    </div>

</body>
</html>
