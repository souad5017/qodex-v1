<?php
require_once "../config/database.php";
session_start();
include("../includes/header.php");

?>


<div id="teacherSpace" class="pt-20">
<div id="dashboard" class="section-content h-[40vh]">


<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold mb-4">Tableau de bord Enseignant</h1>
        <p class="text-xl text-indigo-100 mb-6">Gérez vos quiz</p>

        <div class="flex gap-4">
            <button onclick="openModal('createCategoryModal')"
                class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition">
                <i class="fas fa-folder-plus mr-2"></i>Nouvelle Catégorie
            </button>

            <button onclick="openModal('createQuizModal')"
                class="bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-800 transition">
                <i class="fas fa-plus-circle mr-2"></i>Créer un Quiz
            </button>
        </div>
    </div>
</div>

<!-- ================= MODAL CATEGORIE ================= -->
<div id="createCategoryModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Nouvelle Catégorie</h3>
                <button onclick="closeModal('createCategoryModal')">
                    <i class="fas fa-times text-xl text-gray-500"></i>
                </button>
            </div>


            




            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block font-bold mb-2">Nom *</label>
                    <input type="text" name="name"
                     class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Description</label>
                    <textarea name="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                        onclick="closeModal('createCategoryModal')"
                        class="flex-1 border py-2 rounded-lg">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 bg-indigo-600 text-white py-2 rounded-lg">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL QUIZ ================= -->
<div id="createQuizModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Créer un Quiz</h3>
                <button onclick="closeModal('createQuizModal')">
                    <i class="fas fa-times text-xl text-gray-500"></i>
                </button>
            </div>

            <form>
                <input name="input" type="text"
                    class="w-full px-4 py-2 border rounded-lg mb-4"
                    placeholder="Titre du quiz">

                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg">
                    Créer le Quiz
                </button>
            </form>
        </div>
    </div>
    
   
</div>

</div>
</div>





<!-- ================= JS ================= -->
<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

window.addEventListener('click', function(e) {
    if (e.target.classList.contains('bg-opacity-50')) {
        e.target.classList.add('hidden');
        e.target.classList.remove('flex');
    }
});
</script>
 <?php include("../enseignant/statistics.php"); ?>
<?php include("../includes/footer.php"); ?>
