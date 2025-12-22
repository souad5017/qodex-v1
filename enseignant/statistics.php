<?php
require_once "../config/database.php";



$q1 = mysqli_query($con, "SELECT COUNT(*) AS total FROM Quiz");
$row1 = mysqli_fetch_assoc($q1);
$totalQuiz = $row1['total'] ?? 0;


$q2 = mysqli_query($con, "SELECT COUNT(*) AS total FROM Category");
$row2 = mysqli_fetch_assoc($q2);
$totalCategories = $row2['total'] ?? 0;

$q3 = mysqli_query($con, "SELECT COUNT(*) AS total FROM Users WHERE role='etudiant'");
$row3 = mysqli_fetch_assoc($q3);
$totalStudents = $row3['total'] ?? 0;


$q4 = mysqli_query($con, "
    SELECT AVG(score / total_questions * 100) AS rate
    FROM Result
");
$row4 = mysqli_fetch_assoc($q4);
$successRate = round($row4['rate'] ?? 0);

?>


            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8  h-[45vh]">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Quiz</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo $totalQuiz; ?></p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Catégories</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo $totalCategories; ?></p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <i class="fas fa-folder text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Étudiants Actifs</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo $totalStudents; ?></p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <i class="fas fa-user-graduate text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Taux Réussite</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo $successRate; ?>%</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <i class="fas fa-chart-line text-yellow-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
