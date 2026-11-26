<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?site=login');
    exit;
}

$errormsg = null;
$editing = $site === 'editcustomer';
$messageKey = $site === 'newcustomer' ? 'customer_message' : 'customer_list_message';
$successmsg = $_SESSION[$messageKey] ?? null;
unset($_SESSION[$messageKey]);

if (!isset($_SESSION['customer_token'])) {
    $_SESSION['customer_token'] = bin2hex(random_bytes(32));
}
$customerToken = $_SESSION['customer_token'];

if ($site === 'customers') {
    $customers = [];

    if (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } else {
        try {
            if (isset($_POST['delete'])) {
                $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
                if (!$id || ($_POST['token'] ?? '') !== $customerToken) {
                    $errormsg = 'Die Löschanfrage ist ungültig.';
                } else {
                    try {
                        $statement = $conn->prepare('DELETE FROM customer WHERE id = ? AND deleted_at IS NULL');
                        $statement->execute([$id]);
                        $_SESSION['customer_list_message'] = $statement->rowCount() > 0
                            ? 'Kunde wurde gelöscht.' : 'Der Kunde wurde nicht gefunden.';
                    } catch (PDOException $e) {
                        if (($e->errorInfo[1] ?? null) !== 1451) {
                            throw $e;
                        }

                        $statement = $conn->prepare('UPDATE customer SET deleted_at = CURRENT_TIMESTAMP WHERE id = ? AND deleted_at IS NULL');
                        $statement->execute([$id]);
                        $_SESSION['customer_list_message'] = 'Kunde wurde ausgeblendet. Die Ausleihhistorie bleibt erhalten.';
                    }
                    header('Location: index.php?site=customers');
                    exit;
                }
            }

            $statement = $conn->query('SELECT id, firstname, lastname, email, phone FROM customer WHERE deleted_at IS NULL ORDER BY lastname, firstname');
            $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errormsg = 'Die Kunden konnten nicht geladen werden.';
        }
    }

    return;
}

$customer = null;
if ($editing) {
    $id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    if (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } elseif (!$id) {
        $errormsg = 'Der Kunde wurde nicht gefunden.';
    } else {
        try {
            $statement = $conn->prepare('SELECT firstname, lastname, email, phone FROM customer WHERE id = ? AND deleted_at IS NULL');
            $statement->execute([$id]);
            $customer = $statement->fetch(PDO::FETCH_ASSOC);
            if (!$customer) {
                $errormsg = 'Der Kunde wurde nicht gefunden.';
            }
        } catch (PDOException $e) {
            $errormsg = 'Der Kunde konnte nicht geladen werden.';
        }
    }

    if (isset($errormsg)) {
        return;
    }
}

$firstname = is_string($_POST['firstname'] ?? null) ? trim($_POST['firstname']) : '';
$lastname = is_string($_POST['lastname'] ?? null) ? trim($_POST['lastname']) : '';
$email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
$phone = is_string($_POST['phone'] ?? null) ? trim($_POST['phone']) : '';

if (isset($_POST['add'])) {
    if ($editing && ($_POST['token'] ?? '') !== $customerToken) {
        $errormsg = 'Die Anfrage ist ungültig.';
    } elseif ($firstname === '' || $lastname === '' || $email === '' || $phone === '') {
        $errormsg = 'Bitte alle Felder ausfüllen.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormsg = 'Bitte eine gültige E-Mail-Adresse eingeben.';
    } elseif (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } else {
        try {
            if ($editing) {
                $statement = $conn->prepare('UPDATE customer SET firstname = ?, lastname = ?, email = ?, phone = ? WHERE id = ? AND deleted_at IS NULL');
                $statement->execute([$firstname, $lastname, $email, $phone, $id]);

                $_SESSION['customer_list_message'] = $statement->rowCount() > 0
                    ? 'Kunde wurde gespeichert.' : 'Es wurden keine Änderungen gespeichert.';
                header('Location: index.php?site=customers');
            } else {
                $statement = $conn->prepare('INSERT INTO customer (firstname, lastname, email, phone) VALUES (?, ?, ?, ?)');
                $statement->execute([$firstname, $lastname, $email, $phone]);

                $_SESSION['customer_message'] = 'Kunde wurde angelegt.';
                header('Location: index.php?site=newcustomer');
            }
            exit;
        } catch (PDOException $e) {
            $errormsg = 'Der Kunde konnte nicht gespeichert werden.';
        }
    }
} elseif ($editing) {
    $firstname = $customer['firstname'];
    $lastname = $customer['lastname'];
    $email = $customer['email'];
    $phone = $customer['phone'];
}
