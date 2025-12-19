<?php
include("../config/database.php");
$error = "";
if(isset($_POST['submit'])) {
    $name = strtolower(trim($_POST['name']));
    $email = strtolower(trim($_POST['email']));
    $password =$_POST['password'];
    $cfrmPassword =$_POST['confirm_password'];
    $role = strtolower(trim($_POST['role']));

    $check = mysqli_query($con , "SELECT * FROM Users where email ='$email'");
    if(mysqli_num_rows($check) > 0) {
        $error = "Cette adresse e-mail est déjà utilisée.";
    }
    elseif($password !== $cfrmPassword){
        $error ="Le mot de passe et la confirmation ne correspondent pas.";
    }elseif($password < 8){
        $error="Le mot de passe doit contenir au moins 8 caractères.";
    }
    if(empty($error)){
    $query = "INSERT INTO Users(nom,email,password,role) value ('$name','$email','$password','$role')";
    if(mysqli_query($con , $query)){
        if($role === "enseignant"){
        header('Location: ../enseignant/dashboard.php');}
        else{
        header('Location: ../etudiant/dashboard.php');}
    }}

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form id="registerForm" method="POST" class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
            Inscription
        </h2>
        <?php if (!empty($error)): ?>
    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
        <?= $error ?>
    </div>
<?php endif; ?>
        <label class="block mb-2 text-gray-600" for="name">Nom</label>

        <input
            id="name"
            type="text"
            name="name"
            placeholder="Entrer votre nom"
            required
            class="w-full mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <label class="block mb-2 text-gray-600" for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            placeholder="Entrer votre email"
            required
            class="w-full mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <label class="block mb-2 text-gray-600" for="password">Mot de passe</label>
        <input
            id="password"
            type="password"
            name="password"
            placeholder="Entrer votre mot de passe"
            required
            class="w-full mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <label class="block mb-2 text-gray-600" for="confirm_password">Confirmer le mot de passe</label>
        <input
            id="confirm_password"
            type="password"
            name="confirm_password"
            placeholder="Confirmer votre mot de passe"
            required
            class="w-full mb-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <div class="mb-4">
            <p class="text-gray-600 mb-2">Rôle :</p>
            <label class="mr-4">
                <input type="radio" name="role" value="etudiant" required class="mr-1">
                Etudiant
            </label>
            <label>
                <input type="radio" name="role" value="enseignant" class="mr-1">
                Enseignant
            </label>
        </div>

        <button
            type="submit"
            name="submit"
            class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300"
        >
            Valider
        </button>
        <!-- Login link -->
<p class="text-center text-sm text-gray-500 mt-4">
    Déjà un compte ?
    <a href="login.php" class="text-blue-500 hover:underline">
        Se connecter
    </a>
</p>

    </form>



</body>
</html>
