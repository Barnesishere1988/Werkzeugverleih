<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?site=login');
    exit;
}

$errormsg = null;
$customer = false;
$tools = [];
$customerId = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$toolId = filter_var($_POST['tool_id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$loanToken = $_SESSION['loan_token'] ??= bin2hex(random_bytes(32));
$timezone = new DateTimeZone('Europe/Vienna');
$today = new DateTimeImmutable('today', $timezone);
$startDate = $today->format('Y-m-d');
$plannedReturnDate = $startDate;

if (!$customerId) {
    $errormsg = 'Der Kunde wurde nicht gefunden.';
    return;
}
if (!isset($conn)) {
    $errormsg = 'Die Datenbank ist derzeit nicht erreichbar.';
    return;
}

$customerQuery = 'SELECT firstname, lastname FROM customer WHERE id = ? AND deleted_at IS NULL';
try {
    $statement = $conn->prepare($customerQuery);
    $statement->execute([$customerId]);
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errormsg = 'Der Kunde konnte nicht geladen werden.';
    return;
}
if (!$customer) {
    $errormsg = 'Der Kunde wurde nicht gefunden.';
    return;
}

if (isset($_POST['add'])) {
    $startDate = is_string($_POST['start_date'] ?? null) ? $_POST['start_date'] : '';
    $plannedReturnDate = is_string($_POST['planned_return_date'] ?? null) ? $_POST['planned_return_date'] : '';
    // Erst das Format prüfen, damit auch fehlerhafte POST-Werte keine Datumsausnahme auslösen.
    $start = preg_match('/^[1-9][0-9]{3}-[0-9]{2}-[0-9]{2}$/D', $startDate)
        ? DateTimeImmutable::createFromFormat('!Y-m-d', $startDate, $timezone) : false;
    $plannedReturn = preg_match('/^[1-9][0-9]{3}-[0-9]{2}-[0-9]{2}$/D', $plannedReturnDate)
        ? DateTimeImmutable::createFromFormat('!Y-m-d', $plannedReturnDate, $timezone) : false;

    if (($_POST['token'] ?? '') !== $loanToken) {
        $errormsg = 'Die Anfrage ist ungültig.';
    } elseif (!$toolId) {
        $errormsg = 'Bitte ein Werkzeug auswählen.';
    } elseif (!$start || !$plannedReturn || $start->format('Y-m-d') !== $startDate || $plannedReturn->format('Y-m-d') !== $plannedReturnDate) {
        $errormsg = 'Bitte beide Daten gültig eingeben.';
    } elseif ($start > $today) {
        $errormsg = 'Das Ausleihdatum darf nicht in der Zukunft liegen.';
    } elseif ($plannedReturn < $start) {
        $errormsg = 'Das geplante Rückgabedatum darf nicht vor dem Ausleihdatum liegen.';
    } else {
        try {
            $conn->beginTransaction();

            $statement = $conn->prepare($customerQuery . ' FOR UPDATE');
            $statement->execute([$customerId]);
            $customer = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $conn->prepare('SELECT price FROM tool WHERE id = ? FOR UPDATE');
            $statement->execute([$toolId]);
            $dailyPrice = $statement->fetchColumn();

            if (!$customer || $dailyPrice === false) {
                $conn->rollBack();
                $errormsg = !$customer ? 'Der Kunde wurde nicht gefunden.' : 'Das Werkzeug wurde nicht gefunden.';
            } else {
                $statement = $conn->prepare('INSERT INTO loan (customer_id, tool_id, start_date, planned_return_date, daily_price) VALUES (?, ?, ?, ?, ?)');
                $statement->execute([$customerId, $toolId, $startDate, $plannedReturnDate, $dailyPrice]);
                $conn->commit();

                $days = $start->diff($plannedReturn)->days + 1;
                $total = number_format($days * (float) $dailyPrice, 2, ',', '.');
                $_SESSION['customer_list_message'] = "Ausleihe wurde erfasst. Voraussichtlicher Gesamtpreis: $total €.";
                header('Location: index.php?site=customers');
                exit;
            }
        } catch (PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            $errormsg = ($e->errorInfo[1] ?? null) === 1062
                ? 'Das Werkzeug ist bereits verliehen.'
                : 'Die Ausleihe konnte nicht gespeichert werden.';
        }
    }
}

if ($customer) {
    try {
        $statement = $conn->query('SELECT tool.id, tool.inventoryid, tool.name, tool.price
            FROM tool LEFT JOIN loan ON loan.active_tool_id = tool.id
            WHERE loan.id IS NULL ORDER BY tool.inventoryid');
        $tools = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errormsg = 'Die verfügbaren Werkzeuge konnten nicht geladen werden.';
    }
}
