<?php
session_start();
require_once "../config/database.php";
include("../includes/header.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$quiz_id = (int) ($_GET['quiz_id'] ?? 0);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = (int) $_POST['quiz_id'];
    $question_text = mysqli_real_escape_string($con, trim($_POST['question_text']));
    $answers = $_POST['answers'] ?? [];
    $correct_index = (int) ($_POST['correct_answer'] ?? 0);

    if (empty($question_text)) {
        $errors[] = "Veuillez remplir le texte de la question.";
    }
    if (count($answers) < 2) {
        $errors[] = "Vous devez ajouter au moins 2 options.";
    }
    if ($correct_index < 1 || $correct_index > count($answers)) {
        $errors[] = "Veuillez sélectionner la bonne réponse.";
    }

    if (empty($errors)) {

        $option1 = mysqli_real_escape_string($con, $answers[0] ?? '');
        $option2 = mysqli_real_escape_string($con, $answers[1] ?? '');
        $option3 = isset($answers[2]) ? mysqli_real_escape_string($con, $answers[2]) : null;
        $option4 = isset($answers[3]) ? mysqli_real_escape_string($con, $answers[3]) : null;

        $query = "
            INSERT INTO Question (quiz_id, question, option1, option2, option3, option4, correct_option, created_at)
            VALUES ($quiz_id, '$question_text', '$option1', '$option2',
            ".($option3 ? "'$option3'" : "NULL").", ".($option4 ? "'$option4'" : "NULL").",
            $correct_index, NOW())
        ";

        if (mysqli_query($con, $query)) {
            header("Location: add_question.php?quiz_id=$quiz_id");
            exit;
        } else {
            $errors[] = "Erreur SQL: " . mysqli_error($con);
        }
    }
}
?>

<div id="teacherSpace" class="pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Ajouter une Question (Quiz ID: <?= htmlspecialchars($quiz_id) ?>)</h2>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-6">
                <?php foreach ($errors as $e): ?>
                    <p><?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="add_question.php?quiz_id=<?= $quiz_id ?>" method="POST">
                <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">

                <div class="space-y-6">
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700">Texte de la Question</label>
                        <textarea name="question_text" id="question_text" required rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"><?= isset($_POST['question_text']) ? htmlspecialchars($_POST['question_text']) : '' ?></textarea>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 pt-4">Options de Réponse</h3>
                    <div id="answers-container" class="space-y-4">
                        <?php
                        $answers_post = $_POST['answers'] ?? ['', ''];
                        for ($i = 0; $i < max(2, count($answers_post)); $i++):
                        ?>
                            <div class="flex items-center space-x-3">
                                <input type="radio" name="correct_answer" value="<?= $i+1 ?>" <?= (isset($_POST['correct_answer']) && $_POST['correct_answer'] == $i+1) ? 'checked' : '' ?> class="h-5 w-5 text-indigo-600 border-gray-300" required>
                                <input type="text" name="answers[]" required placeholder="Option <?= $i+1 ?>" value="<?= htmlspecialchars($answers_post[$i] ?? '') ?>" class="block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        <?php endfor; ?>
                    </div>

                    <button type="button" onclick="addAnswerOption()" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold mt-2">
                        <i class="fas fa-plus mr-1"></i> Ajouter une option
                    </button>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Enregistrer la Question
                    </button>
                    <a href="manage_quizzes.php" class="mt-3 block text-center text-sm text-gray-600 hover:text-indigo-600">Terminer et retourner aux Quiz</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addAnswerOption() {
    const container = document.getElementById('answers-container');
    const count = container.children.length + 1;
    if(count > 4) return; 
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-3';
    div.innerHTML = `
        <input type="radio" name="correct_answer" value="${count}" class="h-5 w-5 text-indigo-600 border-gray-300" required>
        <input type="text" name="answers[]" required placeholder="Option ${count}" class="block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
    `;
    container.appendChild(div);
}
</script>

<?php include("../includes/footer.php"); ?>
