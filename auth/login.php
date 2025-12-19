<?php
include("../config/database.php");
$error = "";
if(isset($_POST['login'])) {
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];


    $query = "SELECT * FROM Users WHERE email='$email'";
    $result =  mysqli_query($con , $query);

    if (mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']){
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'enseignant') {
                header("Location: ../enseignant/dashboard.php");
            }
            else {
                header("Location: ../etudiant/dashboard.php");
            }
        }else {
            $error= "mot de passe incorrect";
        }

    }else {
           $error ="email incorrect";
        }

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form method="POST" class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
            Connexion
        </h2>
        <?php if (!empty($error)): ?>
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
        <?= $error ?>
    </div>
        <?php endif; ?>
        <!-- Email -->
        <label class="block mb-2 text-gray-600" for="email">Email</label>


        <input
            id="email"
            type="email"
            name="email"
            placeholder="Entrer votre email"
            required
            class="w-full mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <!-- Password -->
        <label class="block mb-2 text-gray-600" for="password">Mot de passe</label>
        <input
            id="password"
            type="password"
            name="password"
            placeholder="Entrer votre mot de passe"
            required
            class="w-full mb-6 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <!-- Button -->
        <button
            type="submit"
            name="login"
            class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300"
        >
            Se connecter
        </button>

        <!-- Register link -->
        <p class="text-center text-sm text-gray-500 mt-4">
            Pas encore de compte ?
            <a href="register.php" class="text-blue-500 hover:underline">
                S'inscrire
            </a>
        </p>
    </form>

</body>
</html>
