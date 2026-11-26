<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?site=login');
    exit;
}

$errormsg = null;
$inventoryid = is_string($_POST['inventoryid'] ?? null) ? trim($_POST['inventoryid']) : '';
$name = is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '';
$category = is_string($_POST['category'] ?? null) ? trim($_POST['category']) : '';
$description = is_string($_POST['description'] ?? null) ? trim($_POST['description']) : '';
$price = is_string($_POST['price'] ?? null) ? trim($_POST['price']) : '';

if (isset($_POST['add'])) {
    $dailyPrice = str_replace(',', '.', $price);

    if ($inventoryid === '' || $name === '' || $category === '') {
        $errormsg = 'Bitte Inventarnummer, Bezeichnung und Kategorie eingeben.';
    } elseif (!preg_match('/^\d{1,8}(\.\d{1,2})?$/D', $dailyPrice)) {
        $errormsg = 'Bitte einen gültigen Tagespreis eingeben, zum Beispiel 12,50.';
    } elseif (!isset($conn)) {
        $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    } else {
        try {
            $statement = $conn->prepare('INSERT INTO tool (inventoryid, name, category, description, price) VALUES (?, ?, ?, ?, ?)');
            $statement->execute([$inventoryid, $name, $category, $description, $dailyPrice]);

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
}
