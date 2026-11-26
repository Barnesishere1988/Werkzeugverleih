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