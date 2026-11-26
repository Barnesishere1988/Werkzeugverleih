<?php
$errormsg = null;

if(isset($_POST['login'])) {
    if(!isset($_POST['username']) || $_POST['username'] == '') {
        $errormsg = 'Username darf nicht leer sein.';
    }
    $username = htmlspecialchars($_POST['username']);
    if(!isset($_POST['password']) || $_POST['password'] == '') {
        $errormsg = 'Passwort darf nicht leer sein.';
    }
    $password = htmlspecialchars($_POST['password']);

    if ($errormsg == '') {
        $statement = $conn->prepare('SELECT id, username, password FROM user WHERE username = ?');

        $statement->execute([$username]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result == false) {
            $errormsg = 'Benutzername oder Passwort stimmen nicht.';
        } else {
            $verify = password_verify($password, $result['password']);

            if(!$verify) {
                $errormsg = 'Benutzername oder Passwort stimmen nicht.';
            } else {
                unset($result['password']);
                $_SESSION['user'] = $result;
                header('Location: index.php');
            }
        }
    }
}
?>
<div>
    <?php if(isset($errormsg)): ?>
    <span><?= $errormsg ?></span>
    <?php endif; ?>
    <form action="?site=login" method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Passwort</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
</div>