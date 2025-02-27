<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if (!$user) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
                $stmt->bind_param('ss', $username, $hashed_password);
                $stmt->execute();
                $_SESSION['user'] = ['id' => $stmt->insert_id, 'username' => $username];
                header('Location: index.php');
                exit();
            } else {
                $error = 'Nom d\'utilisateur déjà pris';
            }
            $stmt->close();
        } else {
            $error = 'Les mots de passe ne correspondent pas';
        }
    } else {
        $error = 'Veuillez remplir tous les champs';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Inscription</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe">
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="auth.php">Se connecter</a></p>
</body>
</html>