<main class ="min-h-screen flex items-center justify-center bg-gray-100">
    <section class ="bg-white shadow-xl rounded-xl p-8 w-full max-w-md">
        <h1 class ="text-2xl text-center font-bold mb-6 text-indigo-600">Créer un compte :</h1>


        <form method="post" class ="space-y-4">
            <div>
                <label class ="block text-gray-700 font-medium"> Login
                    <input type="text" class ="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="">
                </label>
            </div>

             <div>
                <label class ="block text-gray-700 font-medium"> Email
                    <input type="email" class ="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="">
                </label>
            </div>

             <div>
                <label class ="block text-gray-700 font-medium"> Mot de Passe :
                    <input type="password" class ="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="">
                </label>
            </div>

             <button type="submit" class ="bg-indigo-600 text-white w-full font-medium py-2 rounded-lg hover:bg-indigo-700 transition">
                Inscription
             </button>
        </form>
    </section>
</main>