<?php
session_start();
require_once "../config/database.php";

$errors = [];

$categories_result = mysqli_query($con, "SELECT id, nom FROM Category ORDER BY nom ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, trim($_POST['title']));
    $category = (int) $_POST['category'];
    $description = mysqli_real_escape_string($con, trim($_POST['description']));
    $created_by = $_SESSION['user_id'];

    if (empty($title)) {
        $errors[] = "Le titre est obligatoire.";
    }
    if ($category <= 0) {
        $errors[] = "Veuillez sélectionner une catégorie valide.";
    }

    if (empty($errors)) {
        $query = "INSERT INTO Quiz (titre, category_id, description, created_by, created_at)
                  VALUES ('$title', $category, '$description', $created_by, NOW())";

        if (mysqli_query($con, $query)) {
            $quiz_id = mysqli_insert_id($con);
            header("Location: add_question.php?quiz_id=$quiz_id");
            exit;
        } else {
            $errors[] = "Erreur SQL: " . mysqli_error($con);
        }
    }
}
include("../includes/header.php");
?>

<div id="teacherSpace" class="pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Créer un Nouveau Quiz</h2>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
                <?php foreach ($errors as $e): ?>
                    <p><?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="" method="POST">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre du Quiz</label>
                        <input type="text" name="title" id="title" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"
                               value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category" id="category" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionnez une catégorie</option>
                            <?php while($cat = mysqli_fetch_assoc($categories_result)): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= (isset($_POST['category']) && $_POST['category']==$cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nom']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                            class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Enregistrer le Quiz et Ajouter des Questions
                    </button>
                    <a href="manage_quizzes.php" class="mt-3 block text-center text-sm text-gray-600 hover:text-indigo-600">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
