<?php
session_start();
$cryptocurrencies = [
    'usdtt' => 'USDT',
    'btcusd' => 'BTC',
    'ethusd' => 'ETH',
    'ltcusd' => 'LTC',
];
$user = $_SESSION['user_id'];

echo "User Session Id: " . $user;

?>

<?php require_once 'includes/users/head.php'; ?>

<body class="application application-offset">
    <style>
        #summaryList ul {
            display: inline;
        }



        .wallet-address {
            /* background-color: #6a03b6; */
            border: none;
            padding: 0.5rem;
            /* color: white; */
        }

        .qr-code-container {
            /* background-color: #6a03b6;? */
            /* padding: 1rem; */
            /* border-radius: 0.5rem; */
            display: inline-block;
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
        }

        #qrCodeImage {
            width: 150px !important;
        }

          /* Modal Styling */
          .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 25px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .modal-content h4{
            text-align: center;
            margin-bottom: 1rem;
        }

        .close {
            color: red !important;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            float: left;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>


    <div class="container-fluid container-application">

        <?php include "includes/users/header.php" ?>

        <div class="main-content position-relative">

            <?php include "includes/users/nav.php" ?>
            <div class="page-content">

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">



                                <form id="depositForm" method="POST">
                                    <div class="mb-4">
                                        <label class="">Choose Crypto Asset</label>
                                        <select id="cryptoDropdown" name="cryptoAsset" class="form-select form-control" required>
                                            <option value="" selected disabled>Select Assets</option>
                                            <?php foreach ($cryptocurrencies as $value => $label): ?>
                                                <option value="<?= $value; ?>"><?= $label; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>

                                    <div class="mb-4">
                                        <label class="">Enter Amount (USD)</label>
                                        <input type="number" id="amountInput" name="amount" class="form-control" placeholder="Enter amount" required>
                                    </div>


                                    <div id="walletInfo" class="row d-none ">
                                        <div class="col-md-8 mb-4">
                                            <div class="deposit-info-card card mb-3 border shadow-none p-3">
                                                <label class="">Pay with Wallet Address:</label>
                                                <div class="d-flex align-items-center mb-3 border shadow-none rounded-pill">
                                                    <span class="wallet-address text-truncate  flex-grow-1 me-2" id="walletAddress" name="walletAddress"></span>
                                                    <input type="hidden" name="walletAddress" id="getWallet">
                                                    <button type="button" class="btn btn-xs btn-primary btn-icon rounded-pill" id="copyAddressBtn">
                                                        Copy
                                                    </button>
                                                </div>
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    <p>Please send your deposit to the following address within the next <span class="timer">15:00</span> minutes:</p>
                                                    Always double-check the address before sending any funds.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="F text-center mb-3 p-3 border shadow-none">
                                                <h5 class="">Scan to Pay:</h5>
                                                <div class="qr-code-container">
                                                    <img src="" alt="QR Code" class="img-fluid" id="qrCodeImage">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div id="depositSummary" class="d-none">
                                        <h4 class="">Deposit Summary:</h4>
                                        <ul id="summaryList">
                                            <!-- Summary details will be inserted here by JavaScript -->
                                        </ul>
                                    </div>

                                    <button id="submitDeposit" type="button" class="btn button_default  d-none">Preview Deposit</button>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>

                  <!-- Deposit Preview Modal -->
                  <div id="depositPreviewModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h4>Deposit Preview</h4>
                        <div id="previewContent">
                            <!-- Preview details will be populated by JavaScript -->
                        </div>
                        <button id="confirmDeposit" type="submit" class="btn btn-success mt-3">Confirm and Submit</button>
                    </div>
                </div>

                <input type="hidden" name="deposit_request" value="1">

                </form>

                <div class="row mt-4" style="display: none;">
                    <div class="col-xl-12 col-md-12">
                        <div class="bg-white card card-fluid">
                            <div class="card-header d-flex justify-content-between align-items-center ">
                                <h6 class="mb-0 ">Transaction History</h6>
                                <div class="d-flex">
                                    <input type="text" class="form-control form-control-sm mr-2" placeholder="Search transactions"
                                        id="transactionSearch">
                                    <button class="btn btn-sm btn-light" onclick="searchTransactions()">Search</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2024-10-14</td>
                                            <td>Deposit</td>
                                            <td>$1000.00</td>
                                            <td><span class="badge bg-success ">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>2024-10-12</td>
                                            <td>Withdrawal</td>
                                            <td>$500.00</td>
                                            <td><span class="badge bg-warning ">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>2024-10-10</td>
                                            <td>Deposit</td>
                                            <td>$2000.00</td>
                                            <td><span class="badge bg-success ">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>2024-10-08</td>
                                            <td>Withdrawal</td>
                                            <td>$300.00</td>
                                            <td><span class="badge bg-success ">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>2024-10-06</td>
                                            <td>Deposit</td>
                                            <td>$1500.00</td>
                                            <td><span class="badge bg-success ">Completed</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Static Pagination (no functionality without JavaScript) -->
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <span class="badge badge-primary badge-circle">
                                            3
                                        </span>

                                        <span class="badge badge-secondary badge-circle">
                                            3
                                        </span>

                                        <span class="badge badge-success badge-circle">
                                            3
                                        </span>

                                        <span class="badge badge-danger badge-circle">
                                            3
                                        </span>

                                        <span class="badge badge-warning badge-circle">
                                            3
                                        </span>

                                        <span class="badge badge-info badge-circle">
                                            3
                                        </span>

                                        <span class="badge badge-dark badge-circle">
                                            3
                                        </span>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            $(document).ready(function() {
                let selectedCrypto = '';
                let conversionRates = {};

                function updateProceedButton() {
                    const amount = $('#amountInput').val();
                    if (selectedCrypto && amount > 0) {
                        $('#submitDeposit').removeClass('d-none');
                    } else {
                        $('#submitDeposit').addClass('d-none');
                    }
                }

                function updateDepositSummary() {
                    const amount = parseFloat($('#amountInput').val());
                    const $address = $('#getWallet').val();
                    const $summary = $('#depositSummary');
                    const $summaryList = $('#summaryList');

                    const cryptoSymbols = {
                        'usdtt': 'USDT',
                        'btcusd': 'BTC',
                        'ethusd': 'ETH',
                        'ltcusd': 'LTC'
                    };

                    if (!isNaN(amount) && amount > 0) {
                        const fee = amount * 0.02;
                        const total = amount + fee;
                        const conversionRate = conversionRates[selectedCrypto];
                        const cryptoSymbol = cryptoSymbols[selectedCrypto];

                        function formatDualCurrency(usdAmount) {
                            const cryptoAmount = (usdAmount / conversionRate).toFixed(6);
                            return `$${usdAmount.toFixed(2)} (${cryptoAmount} ${cryptoSymbol})`;
                        }

                        $summaryList.html(`
                <li>Crypto Asset: ${cryptoSymbol}</li>
                <li>Wallet Address: ${$address}</li>
                <li>Amount: ${formatDualCurrency(amount)}</li>
                <li>Deposit Charges: ${formatDualCurrency(fee)}</li>
                <li>Total Amount (incl. fees): ${formatDualCurrency(total)}</li>
            `);

                        $summary.removeClass('d-none');
                        updateWalletInfo();
                    } else {
                        $summary.addClass('d-none');
                        $('#walletInfo').addClass('d-none');
                    }
                }

                function updateWalletInfo() {
                    if (selectedCrypto) {
                        let walletAddress, qrCode;
                        let getWalletAddress = $('#getWallet');
                        
                        switch (selectedCrypto) {
                            case 'usdtt':
                                walletAddress = 'your_usdt_wallet_address_here';
                                qrCode = 'https://api.qrserver.com/v1/create-qr-code/?data=your_usdt_wallet_address_here';
                                getWalletAddress.val(walletAddress);
                                
                                break;
                            case 'btcusd':
                                walletAddress = 'your_btc_wallet_address_here';
                                qrCode = 'https://api.qrserver.com/v1/create-qr-code/?data=your_btc_wallet_address_here';
                                getWalletAddress.val(walletAddress);
                                break;
                            case 'ethusd':
                                walletAddress = 'your_eth_wallet_address_here';
                                qrCode = 'https://api.qrserver.com/v1/create-qr-code/?data=your_eth_wallet_address_here';
                                getWalletAddress.val(walletAddress);
                                break;
                            case 'ltcusd':
                                walletAddress = 'your_ltc_wallet_address_here';
                                qrCode = 'https://api.qrserver.com/v1/create-qr-code/?data=your_ltc_wallet_address_here';
                                getWalletAddress.val(walletAddress);
                                break;
                            default:
                                walletAddress = '';
                                qrCode = '';
                        }

                        $('#walletAddress').text(walletAddress);
                        $('#qrCodeImage').attr('src', qrCode);
                        $('#walletInfo').removeClass('d-none');
                    } else {
                        $('#walletInfo').addClass('d-none');
                    }
                }

                $('#cryptoDropdown').change(function() {
                    selectedCrypto = $(this).val();
                    updateProceedButton();
                    updateDepositSummary();
                });

                $('#amountInput').on('input', function() {
                    updateDepositSummary();
                    updateProceedButton();
                });

                $('#submitDeposit').click(function() {
                            const previewContent = $('#summaryList').html();
                            $('#previewContent').html(previewContent);
                            $('#depositPreviewModal').show();
                        });

                        $('.close').click(function() {
                            $('#depositPreviewModal').hide();
                        });

                        $('#confirmDeposit').click(function() {
                            $('#depositForm').submit();
                        });

                function fetchConversionRates() {
                    $.getJSON('https://api.coingecko.com/api/v3/simple/price?ids=tether,bitcoin,ethereum,litecoin&vs_currencies=usd', function(data) {
                        conversionRates = {
                            'usdtt': data.tether.usd,
                            'btcusd': data.bitcoin.usd,
                            'ethusd': data.ethereum.usd,
                            'ltcusd': data.litecoin.usd
                        };
                        updateDepositSummary();
                    }).fail(function() {
                        console.error('Error fetching conversion rates');
                    });
                }

                fetchConversionRates();

                $('#copyAddressBtn').click(function() {
                    const walletAddress = $('#walletAddress').text();
                    navigator.clipboard.writeText(walletAddress).then(() => {
                        alert('Wallet address copied to clipboard!');
                    });
                });
            });
        </script>

        <?php require_once 'includes/users/footer.php'; ?>