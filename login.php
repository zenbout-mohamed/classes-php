<?php
session_start();
require_once __DIR__ . '/../config.php'; // Connexion PDO

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($login) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'login' => $user['login'],
                'email' => $user['email'],
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname']
            ];

            header("Location: index.php");
            exit;
        } else {
            $error = "Identifiants incorrects.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Connexion</h2>

        <?php if (!empty($error)): ?>
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700">Login</label>
                <input type="text" name="login" class="w-full px-4 py-2 border rounded focus:outline-none">
            </div>

            <div>
                <label class="block text-gray-700">Mot de passe</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none">
            </div>

            <button class="w-full py-2 mt-4 bg-blue-600 text-white rounded hover:bg-blue-700">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Pas encore inscrit ? <a href="register.php" class="text-blue-600 hover:underline">Créer un compte</a>
        </p>
    </div>

</body>
</html>
