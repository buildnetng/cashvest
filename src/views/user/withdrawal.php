<?php include "includes/users/head.php" ?>
<?php
$cryptocurrencies = [
    'usdtt' => 'USDT',
    'btcusd' => 'BTC',
    'ethusd' => 'ETH',
    'ltcusd' => 'LTC',
];

// Define withdrawal fees for each cryptocurrency as percentages
$withdrawalFees = [
    'usdtt' => 0.1, // 0.1% fee for USDT
    'btcusd' => 0.2, // 0.2% fee for BTC
    'ethusd' => 0.15, // 0.15% fee for ETH
    'ltcusd' => 0.1, // 0.1% fee for LTC
];
?>

<body class="application application-offset">

    <div class="container-fluid container-application">

        <?php include "includes/users/header.php" ?>

        <div class="main-content position-relative">

            <?php include "includes/users/nav.php" ?>
            <div class="page-content">

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <div class="row mb-5 justify-content-between align-items-center">
                    <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                        <!-- Page title + Go Back button -->
                        <div class="d-inline-block">
                            <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">Withdrawal </h5>
                        </div>
                        <!-- Additional info -->
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="actions actions-dark d-inline-block">
                            <a href="#" class="action-item ml-md-4">
                                <i class="far fa-file-export mr-2"></i>Deposit
                            </a>
                            <a href="#modal-project-create" class="btn btn-sm btn-white btn-icon-only rounded-circle ml-4" data-toggle="modal">
                                <span class="btn-inner--icon"><i class="far fa-plus"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card" style="border-radius: 30px;">
                            <div class="card-body">

                                <form id="withdrawalForm" method="POST" action="">
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

                                    <div class="mb-4">
                                        <label class="">Enter Withdrawal Address</label>
                                        <input type="text" id="withdrawalAddress" name="withdrawalAddress" class="form-control" placeholder="Enter withdrawal address" required>
                                    </div>

                                    <div id="withdrawalInfo" class="row">
                                        <div class="col-md-12 mb-4">
                                            <div class="withdrawal-info-card d-none">
                                                <h5 class="">Withdrawal Details:</h5>
                                                <p class="">Amount: <span id="withdrawalAmount"></span> USD (<span id="cryptoAmount"></span> <span id="cryptoSymbol"></span>)</p>
                                                <p class="">Withdrawal Fee: <span id="withdrawalFee"></span> <span id="feeSymbol"></span> (<span id="withdrawalFeeUSD"></span> USD)</p>
                                                <p class="">Total Amount (including fee): <span id="totalAmount"></span> <span id="totalSymbol"></span> (<span id="totalAmountUSD"></span> USD)</p>
                                                <p class="">Address: <span id="displayWithdrawalAddress"></span></p>
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    <p>Please double-check all details before confirming your withdrawal.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="withdrawalSummary" class="d-none">
                                        <h4 class="">Withdrawal Summary:</h4>
                                        <ul id="summaryList">
                                            <!-- Summary details will be inserted here by JavaScript -->
                                        </ul>
                                    </div>

                                    <button id="confirmWithdrawal" type="submit" class="btn button_default d-none">Confirm Withdrawal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>

            </div>

        </div>

        <?php include "includes/users/footer.php" ?>
        <script>
            $(document).ready(function() {
                var withdrawalFees = <?= json_encode($withdrawalFees); ?>;
                var conversionRates = {};

                // Fetch real-time conversion rates from CoinGecko API
                function fetchConversionRates() {
                    $.getJSON('https://api.coingecko.com/api/v3/simple/price?ids=tether,bitcoin,ethereum,litecoin&vs_currencies=usd', function(data) {
                        conversionRates = {
                            'usdtt': data.tether.usd,
                            'btcusd': data.bitcoin.usd,
                            'ethusd': data.ethereum.usd,
                            'ltcusd': data.litecoin.usd
                        };
                        updateWithdrawalInfo(); // Update the info after fetching rates
                    }).fail(function() {
                        console.error('Error fetching conversion rates');
                    });
                }

                fetchConversionRates(); // Call the function to fetch conversion rates

                $('#cryptoDropdown, #amountInput, #withdrawalAddress').on('change input', function() {
                    updateWithdrawalInfo();
                });

                function updateWithdrawalInfo() {
                    var crypto = $('#cryptoDropdown').val();
                    var amountUSD = parseFloat($('#amountInput').val());
                    var address = $('#withdrawalAddress').val();

                    if (crypto && amountUSD && address && conversionRates[crypto]) {
                        var rate = conversionRates[crypto];
                        var amountCrypto = amountUSD / rate;
                        var feePercentage = withdrawalFees[crypto];
                        var feeCrypto = amountCrypto * (feePercentage / 100);
                        var feeUSD = feeCrypto * rate;
                        var totalAmountCrypto = amountCrypto - feeCrypto; // Subtracting fee from the amount
                        var totalAmountUSD = amountUSD - feeUSD;

                        $('#withdrawalInfo').removeClass('d-none');
                        $('#withdrawalAmount').text(amountUSD.toFixed(2));
                        $('#cryptoAmount').text(amountCrypto.toFixed(8));
                        $('#cryptoSymbol').text($('#cryptoDropdown option:selected').text());
                        $('#withdrawalFee').text(feeCrypto.toFixed(8));
                        $('#feeSymbol').text($('#cryptoDropdown option:selected').text());
                        $('#withdrawalFeeUSD').text(feeUSD.toFixed(2));
                        $('#feePercentage').text(feePercentage.toFixed(2));
                        $('#totalAmount').text(totalAmountCrypto.toFixed(8));
                        $('#totalSymbol').text($('#cryptoDropdown option:selected').text());
                        $('#totalAmountUSD').text(totalAmountUSD.toFixed(2));
                        $('#displayWithdrawalAddress').text(address);
                        $('#confirmWithdrawal').removeClass('d-none');

                        // Update summary
                        var summaryHtml = `
                        <li>Crypto: ${$('#cryptoDropdown option:selected').text()}</li>
                        <li>Amount: ${amountUSD.toFixed(2)} USD (${amountCrypto.toFixed(8)} ${$('#cryptoDropdown option:selected').text()})</li>
                        <li>Fee (${feePercentage}%): ${feeCrypto.toFixed(8)} ${$('#cryptoDropdown option:selected').text()} (${feeUSD.toFixed(2)} USD)</li>
                        <li>Total (after fee): ${totalAmountCrypto.toFixed(8)} ${$('#cryptoDropdown option:selected').text()} (${totalAmountUSD.toFixed(2)} USD)</li>
                        <li>Address: ${address}</li>`;
                        $('#summaryList').html(summaryHtml);
                        $('#withdrawalSummary').removeClass('d-none');
                    } else {
                        $('#withdrawalInfo').addClass('d-none');
                        $('#confirmWithdrawal').addClass('d-none');
                        $('#withdrawalSummary').addClass('d-none');
                    }
                }

                $('#withdrawalForm').on('submit', function(e) {
                    e.preventDefault();
                    // Here you would typically send the withdrawal request to the server
                    alert('Withdrawal request submitted. Please wait for confirmation.');
                });
            });
        </script>

    </div>
</body>