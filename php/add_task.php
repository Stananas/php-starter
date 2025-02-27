<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task']) && !empty($_POST['task'])) {
        include 'db.php';
        $userId = $_SESSION['user']['id']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session
        addTask($_POST['task'], $userId);
    }
}

header('Location: index.php');
exit();
?>