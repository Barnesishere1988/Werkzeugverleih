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
    case 'tools':
    case 'edittool':
    case 'newtool':
        include '../requests/tools.php';
        break;
    case 'customers':
    case 'editcustomer':
    case 'newcustomer':
        include '../requests/customers.php';
        break;
    default: break;
}

    if (isset($_SESSION['user'])): ?>
    <a href="?site=tools">Werkzeuge</a>
    <a href="?site=customers">Kunden</a>
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
    case 'edittool':
        include '../sites/newtool.php';
        break;
    case 'newcustomer':
    case 'editcustomer':
        include '../sites/newcustomer.php';
        break;
    case 'customers':
        include '../sites/customers.php';
        break;
    default:
        break;
}
