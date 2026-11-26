<?php
session_start();

include '../db.php';

$site = isset($_GET['site']) ? htmlspecialchars($_GET['site']) : '';

if ($site == "login") {
    include '../login.php';
}

if(isset($_SESSION['user'])) {
    var_dump($_SESSION['user']);
}