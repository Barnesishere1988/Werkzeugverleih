<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?site=login');
    exit;
}

$errormsg = null;
$successmsg = $_SESSION['customer_message'] ?? null;
unset($_SESSION['customer_message']);

$firstname = is_string($_POST['firstname'] ?? null) ? trim($_POST['firstname']) : '';
$lastname = is_string($_POST['lastname'] ?? null) ? trim($_POST['lastname']) : '';
$email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
$phone = is_string($_POST['phone'] ?? null) ? trim($_POST['phone']) : '';

if (isset($_POST['add'])) {
    if ($firstname === '' || $lastname === '' || $email === '' || $phone === '') {
        $errormsg = 'Bitte alle Felder ausfüllen.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormsg = 'Bitte eine gültige E-Mail-Adresse eingeben.';
    } elseif (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } else {
        try {
            $statement = $conn->prepare('INSERT INTO customer (firstname, lastname, email, phone) VALUES (?, ?, ?, ?)');
            $statement->execute([$firstname, $lastname, $email, $phone]);

            $_SESSION['customer_message'] = 'Kunde wurde angelegt.';
            header('Location: index.php?site=newcustomer');
            exit;
        } catch (PDOException $e) {
            $errormsg = 'Der Kunde konnte nicht gespeichert werden.';
        }
    }
}
