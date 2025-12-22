<?php
session_start();
require_once "../config/database.php";
include("../includes/header.php");

$user_id = $_SESSION['user_id'];

$query = "
    SELECT q.id, q.titre AS title, q.description, c.nom AS category_name,
           (SELECT COUNT(*) FROM Question WHERE quiz_id = q.id) AS nb_questions,
           (SELECT COUNT(DISTINCT r.etudiant_id) FROM Result r WHERE r.quiz_id = q.id) AS nb_participants
    FROM Quiz q
    LEFT JOIN Category c ON q.category_id = c.id
    WHERE q.created_by = $user_id
    ORDER BY q.created_at DESC
";

$result = mysqli_query($con, $query);
?>

<div id="teacherSpace" class="pt-20">
    <div id="quiz" class="section-content">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[80vh] ">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Mes Quiz</h2>
                    <p class="text-gray-600 mt-2">Créez et gérez vos quiz</p>
                </div>
                <a href="add_quiz.php" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Créer un Quiz
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($quiz = mysqli_fetch_assoc($result)): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                        <?= htmlspecialchars($quiz['category_name'] ?? '-') ?>
                                    </span>
                                    <div class="flex gap-2">
                                        <a href="edit_quiz.php?id=<?= $quiz['id'] ?>" class="text-blue-600 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                        <a href="delete_quiz.php?id=<?= $quiz['id'] ?>" class="text-red-600 hover:text-red-700"
                                            onclick="return confirm('Supprimer ce quiz ?')"><i class="fas fa-trash"></i></a>
                                        <a href="add_question.php?quiz_id=<?= $quiz['id'] ?>" class="text-green-600 hover:text-green-700"><i class="fas fa-plus-circle"></i></a>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($quiz['title']) ?></h3>
                                <p class="text-gray-600 mb-4 text-sm"><?= htmlspecialchars($quiz['description']) ?></p>
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span><i class="fas fa-question-circle mr-1"></i><?= $quiz['nb_questions'] ?> questions</span>
                                    <span><i class="fas fa-user-friends mr-1"></i><?= $quiz['nb_participants'] ?> participants</span>
                                </div>
                                <a href="view_results.php?quiz_id=<?= $quiz['id'] ?>" class="w-full block text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                                    <i class="fas fa-eye mr-2"></i>Voir les résultats
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-500 col-span-3">Vous n'avez créé aucun quiz pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>

<?php include("../includes/footer.php"); ?>