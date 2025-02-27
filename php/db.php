<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'todolist';

try {
    $db = new mysqli($host, $username, $password, $dbname);
    if ($db->connect_error) {
        throw new Exception('Connection failed: ' . $db->connect_error);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

function getTasks() {
    global $db;
    $result = $db->query('SELECT * FROM tasks');
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addTask($task, $userId) {
    global $db;
    $stmt = $db->prepare('INSERT INTO tasks (task, user_id) VALUES (?, ?)');
    $stmt->bind_param('si', $task, $userId);
    $stmt->execute();
    $stmt->close();
}

function deleteTask($taskId) {
    global $db;
    $stmt = $db->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->bind_param('i', $taskId);
    $stmt->execute();
    $stmt->close();
}
?>