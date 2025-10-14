<main class ="min-h-screen flex items-center justify-center bg-gray-100">
     <section class ="bg-white shadow-lg rounded-lg p-8 w-full max-w-sm">
      <h1 class ="text-2xl font-bold text-center mb-6 text-gray-800">Connexion :</h1>

      <form method = "post"class ="space-y-4" action ="login.php">
          <label for ="login" class ="block text-gray-700 font-medium">Nom d'utilisateur</label>
          <input type ="text" id ="login" name ="login" class ="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder = "Entrez votre nom d'utilisateur" required>

          <label for="password" class="block text-gray-700 font-medium">Mot de passe</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" reuqired>

          <button type ="submit" class ="w-full py-2 mb-4 font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 transition"></button>
      </form>

      <p class ="text-center text-sm text-gray-600 mt-4">
          <a href ="register.php" class ="text-blue-600 hover:underline">Inscrivez-vous</a>
     </p>
     </section>
</main>

     