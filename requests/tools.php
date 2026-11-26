<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?site=login');
    exit;
}

$errormsg = null;
$editing = $site === 'edittool';
$toolToken = $_SESSION['tool_token'] ??= bin2hex(random_bytes(32));

if ($site === 'tools') {
    $tools = [];
    $successmsg = $_SESSION['tool_message'] ?? null;
    unset($_SESSION['tool_message']);

    if (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } else {
        if (isset($_POST['delete'])) {
            $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if (!$id || ($_POST['token'] ?? '') !== $toolToken) {
                $errormsg = 'Die Löschanfrage ist ungültig.';
            } else {
                try {
                    $statement = $conn->prepare('DELETE FROM tool WHERE id = ?');
                    $statement->execute([$id]);
                    $_SESSION['tool_message'] = $statement->rowCount() > 0
                        ? 'Werkzeug wurde gelöscht.' : 'Das Werkzeug wurde nicht gefunden.';
                    header('Location: index.php?site=tools');
                    exit;
                } catch (PDOException $e) {
                    $errormsg = ($e->errorInfo[1] ?? null) === 1451
                        ? 'Für dieses Werkzeug wurden bereits Ausleihen erfasst. Es kann nicht gelöscht werden.'
                        : 'Das Werkzeug konnte nicht gelöscht werden.';
                }
            }
        }

        try {
            $statement = $conn->query('SELECT id, inventoryid, name, category, description, price FROM tool ORDER BY inventoryid');
            $tools = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errormsg = 'Die Werkzeuge konnten nicht geladen werden.';
        }
    }

    return;
}

$tool = null;
if ($editing) {
    $id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$id) {
        $errormsg = 'Das Werkzeug wurde nicht gefunden.';
        return;
    }
    if (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
        return;
    }

    try {
        $statement = $conn->prepare('SELECT inventoryid, name, category, description, price FROM tool WHERE id = ?');
        $statement->execute([$id]);
        $tool = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$tool) {
            $errormsg = 'Das Werkzeug wurde nicht gefunden.';
            return;
        }
    } catch (PDOException $e) {
        $errormsg = 'Das Werkzeug konnte nicht geladen werden.';
        return;
    }
}

$inventoryid = is_string($_POST['inventoryid'] ?? null) ? trim($_POST['inventoryid']) : '';
$name = is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '';
$category = is_string($_POST['category'] ?? null) ? trim($_POST['category']) : '';
$description = is_string($_POST['description'] ?? null) ? trim($_POST['description']) : '';
$price = is_string($_POST['price'] ?? null) ? trim($_POST['price']) : '';

if (isset($_POST['add'])) {
    $dailyPrice = str_replace(',', '.', $price);

    if ($editing && ($_POST['token'] ?? '') !== $toolToken) {
        $errormsg = 'Die Anfrage ist ungültig.';
    } elseif ($inventoryid === '' || $name === '' || $category === '') {
        $errormsg = 'Bitte Inventarnummer, Bezeichnung und Kategorie eingeben.';
    } elseif (!preg_match('/^\d{1,8}(\.\d{1,2})?$/D', $dailyPrice)) {
        $errormsg = 'Bitte einen gültigen Tagespreis eingeben, zum Beispiel 12,50.';
    } elseif (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } else {
        try {
            if ($editing) {
                $statement = $conn->prepare('UPDATE tool SET inventoryid = ?, name = ?, category = ?, description = ?, price = ? WHERE id = ?');
                $statement->execute([$inventoryid, $name, $category, $description, $dailyPrice, $id]);
                $_SESSION['tool_message'] = $statement->rowCount() > 0
                    ? 'Werkzeug wurde gespeichert.' : 'Es wurden keine Änderungen gespeichert.';
            } else {
                $statement = $conn->prepare('INSERT INTO tool (inventoryid, name, category, description, price) VALUES (?, ?, ?, ?, ?)');
                $statement->execute([$inventoryid, $name, $category, $description, $dailyPrice]);
            }

            header('Location: index.php?site=tools');
            exit;
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                $errormsg = 'Diese Inventarnummer ist bereits vergeben.';
            } else {
                $errormsg = 'Das Werkzeug konnte nicht gespeichert werden.';
            }
        }
    }
} elseif ($editing) {
    $inventoryid = $tool['inventoryid'];
    $name = $tool['name'];
    $category = $tool['category'];
    $description = $tool['description'];
    $price = str_replace('.', ',', $tool['price']);
}
