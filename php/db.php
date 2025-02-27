<?php
$dsn = 'mysql:host=localhost;dbname=todolist';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

function getTasks() {
    global $db;
    $stmt = $db->query('SELECT * FROM tasks');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addTask($task) {
    global $db;
    $stmt = $db->prepare('INSERT INTO tasks (task) VALUES (:task)');
    $stmt->execute(['task' => $task]);
}
?>