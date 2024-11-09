<?php require_once 'config/config.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Purpose Application UI is the following chapter we've finished in order to create a complete and robust solution next to the already known Purpose Website UI.">
    <meta name="author" content="Webpixels"> 
    <title>Purpose &ndash; Application UI Kit</title>
    <link rel="icon" href="assets/img/brand/favicon.png" type="image/png">
    <link rel="stylesheet" href="assets/libs/@fortawesome/fontawesome-pro/css/all.min.css">
    <link rel="stylesheet" href="assets/libs/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/purpose.css" id="stylesheet">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">
    <!-- FilePond Image Preview Plugin CSS -->
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <!-- iziToast Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('controllers/session/session_manager.php')
            .then(response => response.json())
            .then(data => {
                // Check if the user is already on the page specified in data.redirect
                if (data.redirect && window.location.href !== data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error('Error checking session:', error);
            });
    });
    </script>

    <style>
        h4,
        .h2 {
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }



        .nav-application>.btn.active {
            background-color: #6300e6 !important;
            color: white !important;
        }

        .nav-application>.btn-square {
            background-color: #6a03b6;
            color: white !important;
        }

        .button_default {
            background-color: #6300e6 !important;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .button_default:hover {
            background-color: #4a00b3;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .button_default:active {
            background-color: #3b0093;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(1px);
        }

        tr {
            border: none !important;
        }

                /* Custom styling for the FilePond container */
                .filepond--root {
            width: 100%;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: #f8f9fa;
            border: 2px dashed #007bff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .filepond--root:hover {
            border-color: #0056b3;
        }

        /* Customize the label */
        .filepond--label-action {
            color: #007bff;
            font-weight: bold;
            cursor: pointer;
        }

        /* Style image preview */
        .filepond--item-panel {
            border-radius: 10px;
            overflow: hidden;
        }

        .filepond--image-preview-wrapper {
            border-radius: 10px;
        }

        /* Custom loading icon colors */
        .filepond--drop-label {
            color: #6c757d;
            font-size: 16px;
            font-weight: 500;
        }

        .filepond--credits {
            display: none;
        }
    </style>
</head>


 