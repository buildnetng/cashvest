<?php
require_once "../../config/config.php";
require_once "../../vendor/mailer.php";



if (isset($_POST['deposit_request']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    $cryptoAsset = htmlspecialchars(trim($_POST['cryptoAsset'] ?? ''));
    $amount = htmlspecialchars(trim($_POST['amount'] ?? ''));
    $walletAddress = htmlspecialchars(trim($_POST['walletAddress'] ?? ''));


    if (empty($cryptoAsset)) {
        echo json_encode(['status' => 'error', 'messages' => ['Crypto asset is required']]);
        exit;
    }

    if (empty($amount)) {
        echo json_encode(['status' => 'error', 'messages' => ['Amount is required']]);
        exit;
    }

    if (empty($walletAddress)) {
        echo json_encode(['status' => 'error', 'messages' => ['Wallet Address is required']]);
        exit;
    }

    $query = "INSERT INTO transactions (user_id, amount, crypto_asset_type, wallet_address, transaction_type, transaction_token, status) VALUES(?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    $user_id = $_SESSION['user_id'];
    $loan_amount = $amount;
    $crypto_asset_type = $cryptoAsset;
    $wallet_address = $walletAddress;
    $transaction_type = 'deposit';
    $transaction_token = bin2hex(random_bytes(16));
    $status = 'pending';

    $stmt->bind_param("idsssss", $user_id, $loan_amount, $crypto_asset_type, $wallet_address, $transaction_type, $transaction_token, $status);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'messages' => ['Deposit successful']]);
        // write your email response to user email
    } else {
        echo json_encode(['status' => 'success', 'messages' => "Error: " . $stmt->error]);
    }

    $stmt->close();

}


