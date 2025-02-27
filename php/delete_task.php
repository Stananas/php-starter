<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task_id']) && !empty($_POST['task_id'])) {
        include 'db.php';
        $taskId = $_POST['task_id'];
        deleteTask($taskId);
    }
}

header('Location: index.php');
exit();
?>