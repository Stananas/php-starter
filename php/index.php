<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Bienvenue sur votre To-Do List</h1>
    <form action="add_task.php" method="post">
        <input type="text" name="task" placeholder="Nouvelle tâche">
        <button type="submit">Ajouter</button>
    </form>
    <ul>
        <?php
        include 'db.php';
        $tasks = getTasks();
        foreach ($tasks as $task) {
            echo "<li>{$task['task']}</li>";
        }
        ?>
    </ul>
</body>
</html>