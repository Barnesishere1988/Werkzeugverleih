<?php
session_start();

include '../db.php';

$site = isset($_GET['site']) ? htmlspecialchars($_GET['site']) : '';

if ($site == "login") {
    include '../login.php';
} elseif ($site == "logout") {
    include '../logout.php';
} else {
    if (isset($_SESSION['user'])): ?>
    <a href="?site=logout">Logout</a>
    <?php else: ?>
    <a href="?site=login">Login</a>
    <?php endif;
}