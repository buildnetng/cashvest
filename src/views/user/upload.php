<?php require_once 'includes/users/head.php'; ?>

<body class="application application-offset">

    <div class="container-fluid container-application">

        <?php include "includes/users/header.php" ?>

        <div class="main-content position-relative">

            <?php include "includes/users/nav.php" ?>
            <div class="page-content">

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card" style="border-radius: 30px;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mb-3">
                                        <div class="main">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h1 style="font-size: 16px;" class="mb-3">Upload Image</h1>

                                                    <input type="file" class="filepond" name="file" accept="image/*" />
                                                    

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mb-3">
                                        <div class="main">
                                            <div class="card">
                                                <div class="card-body">
                                                    
                                                <p>Wallet Address</p>

                                                <p>Crypto Asset</p>

                                                <p>Amount</p>
                                                    

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div> 
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <!-- FilePond Image Preview Plugin JavaScript -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script>
        // Register the FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Turn all file input elements into ponds
        FilePond.create(document.querySelector('.filepond'), {
            allowImagePreview: true,
            imagePreviewHeight: 200,
            allowMultiple: false,
            maxFiles: 1,
            stylePanelAspectRatio: 1,
            server: {
                // Configure upload to server here, if needed
                process: '/upload',  // Placeholder URL
            }
        });
    </script>


        <?php require_once 'includes/users/footer.php'; ?>