<?php
session_start();
header("Content-Type: application/json");

$base_url = 'http://localhost/cashvest/';

if (!isset($_SESSION['online'])) {
    echo json_encode(['redirect' => $base_url . 'sign-in']);
    exit;
} 
