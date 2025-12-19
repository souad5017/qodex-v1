<?php
include("../config/database.php");
include("../includes/header.php");
?>

<div id="teacherSpace" class="pt-20">
<div id="categories" class="section-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[70vh]">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h2>
                <p class="text-gray-600 mt-2">Organisez vos quiz par catégories</p>
            </div>
            <button onclick="openModal('createCategoryModal')" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Catégorie
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <?php 
        $query = "SELECT * FROM Category ORDER BY created_at DESC";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0):
            while($cat = mysqli_fetch_assoc($result)):
        ?>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            <?= htmlspecialchars($cat['description']) ?>
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="edit_category.php?id=<?= $cat['id'] ?>" 
                           class="text-blue-600 hover:text-blue-700"
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="delete_category.php?id=<?= $cat['id'] ?>"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                           class="text-red-600 hover:text-red-700"
                           title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>
                        <i class="fas fa-clipboard-list mr-2"></i>
                        0 quiz
                    </span>
                    <span>
                        <i class="fas fa-user-friends mr-2"></i>
                        —
                    </span>
                </div>
            </div>

        <?php 
            endwhile; 
        else: 
        ?>
            <p class="text-gray-500">Aucune catégorie disponible pour le moment.</p>
        <?php endif; ?>

        </div>
    </div>
</div>

<!-- ===== Modale Tailwind ===== -->
<div id="createCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl w-11/12 max-w-md overflow-hidden shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Nouvelle Catégorie</h2>
            <button class="text-gray-500 hover:text-gray-700 text-2xl" id="closeCreateCategoryModal">&times;</button>
        </div>

        <!-- Body -->
        <form action="" method="POST" class="px-6 py-4">
            <div class="mb-4">
                <label for="cat_name" class="block mb-1 font-medium text-gray-700">Nom de la catégorie</label>
                <input type="text" id="cat_name" name="name" placeholder="Ex: PHP & MySQL" required
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label for="cat_desc" class="block mb-1 font-medium text-gray-700">Description</label>
                <textarea id="cat_desc" name="description" rows="3" placeholder="Brève description..."
                          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3">
                <button type="button" id="cancelCreateCategory" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    Annuler
                </button>
                <button type="submit" name="add_category" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Script pour ouvrir/fermer la modale ===== -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    const modal = document.getElementById('createCategoryModal');
    const closeBtn = document.getElementById('closeCreateCategoryModal');
    const cancelBtn = document.getElementById('cancelCreateCategory');

    function closeModal() {
        modal.classList.add('hidden');
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    window.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
</script>

<?php include("../includes/footer.php"); ?>
