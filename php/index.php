<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>To-Do List</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="logout-button">
        <form action="logout.php" method="post">
            <button type="submit" class="red">Déconnexion</button>
        </form>
    </div>

    <div class="container">

    <?php 
    $user = $_SESSION['user'];
    $username = $user['username'];
    echo     "<center><h1>Bienvenue sur votre To-Do List, " . $username . "</h1></center>" ?>
    <form action="add_task.php" method="post" class="form-inline">
        <input type="text" name="task" placeholder="Nouvelle tâche">
        <button type="submit" class="useraction">➕</button>
    </form>
    <ul>
        <?php
        include 'db.php';
        $tasks = getTasks();
        foreach ($tasks as $task) {
            echo "<li>{$task['task']}
                    <form action='delete_task.php' method='post' style='display:inline;'>
                        <input type='hidden' name='task_id' value='{$task['id']}'>
                        <button type='submit' class='useraction red'>🗑️</button>
                    </form>
                  </li>";
        }
        ?>
    </ul>
    </div>

    <style>
        .form-inline {
            display: flex;
            align-items: center;
        }
        .form-inline input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }

        .form-inline button {
            font-size: 1.5em;
            width: 40px;
            height: 40px;
        }
    </style>
</body>

</html>