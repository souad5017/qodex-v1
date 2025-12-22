<?php
session_start();
require_once "../config/database.php";

if (isset($_POST['add_category'])) {

    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $description = mysqli_real_escape_string($con, trim($_POST['description']));
    $created_by = $_SESSION['user_id'];


    $query = "
        INSERT INTO Category (nom, description, created_by)
        VALUES ('$name', '$description', $created_by)
    ";

    if (!mysqli_query($con, $query)) {
        die("Erreur SQL: " . mysqli_error($con));
    }

    header("Location: categorie.php");
    exit;
}

include("../includes/header.php");
?>

<div id="teacherSpace" class="pt-20">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h2>
            <p class="text-gray-600 mt-2">Organisez vos quiz par catégories</p>
        </div>
        <button onclick="openModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">
            + Nouvelle Catégorie
        </button>
    </div>

    <!-- ERRORS -->
    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
            <?php foreach ($errors as $e): ?>
                <p><?= $e ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <?php
    $result = mysqli_query($con, "SELECT * FROM Category ORDER BY created_at DESC");

    if (mysqli_num_rows($result) > 0):
        while ($cat = mysqli_fetch_assoc($result)):
    ?>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
            <h3 class="text-xl font-bold text-gray-900">
                <?= htmlspecialchars($cat['nom']) ?>
            </h3>
            <p class="text-gray-600 text-sm mt-2">
                <?= htmlspecialchars($cat['description']) ?>
            </p>

            <div class="flex justify-end gap-3 mt-4">
                <a href="edit_category.php?id=<?= $cat['id'] ?>" class="text-blue-600">✏️</a>
                <a href="delete_category.php?id=<?= $cat['id'] ?>"
                   onclick="return confirm('Supprimer cette catégorie ?')"
                   class="text-red-600">🗑️</a>
            </div>
        </div>

    <?php endwhile; else: ?>
        <p class="text-gray-500">Aucune catégorie.</p>
    <?php endif; ?>

    </div>
</div>
</div>

<!-- ===== MODAL ===== -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl w-96 p-6">
        <h2 class="text-lg font-semibold mb-4">Nouvelle Catégorie</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Nom"
                   class="w-full border px-3 py-2 rounded mb-3" required>

            <textarea name="description" placeholder="Description"
                      class="w-full border px-3 py-2 rounded mb-4"></textarea>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded">
                    Annuler
                </button>
                <button type="submit" name="add_category"
                        class="bg-indigo-600 text-white px-4 py-2 rounded">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>

<?php include("../includes/footer.php"); ?>
