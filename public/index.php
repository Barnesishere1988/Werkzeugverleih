<?php
session_start();

include '../db.php';

$site = isset($_GET['site']) ? htmlspecialchars($_GET['site']) : '';

switch ($site) {
    case 'login':
        include '../requests/login.php';
        break;
    case 'logout':
        include '../requests/logout.php';
        break;
    case 'newtool':
        include '../requests/tools.php';
        break;
    case 'newcustomer':
        include '../requests/customers.php';
        break;
    default: break;
}

    if (isset($_SESSION['user'])): ?>
    <a href="?site=tools">Werkzeuge</a>
    <a href="?site=newcustomer">Kunde anlegen</a>
    <a href="?site=logout">Logout</a><br><br>
    <?php else: ?>
    <a href="?site=login">Login</a><br><br>
    <?php endif;

switch ($site) {
    case 'login':
        include '../sites/login.php';
        break;
    case 'tools':
        include '../sites/tools.php';
        break;
    case 'newtool':
        include '../sites/newtool.php';
        break;
    case 'newcustomer':
        include '../sites/newcustomer.php';
        break;
    default:
        break;
}
