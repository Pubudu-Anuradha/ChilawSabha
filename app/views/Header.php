<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?php foreach ($styles as $style) { ?>
        <link rel="stylesheet" href="<?= URLROOT . '/public/css/' . $style ?>.css">
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="header">
        <div class="logo-area">
            <div class="logo-items">
                <div class="logo">
                    <img src="<?= URLROOT . '/public/assets/logo.jpg' ?>" height="100" width="90" alt="Sabha Logo">
                </div>
                <div class="sabha-title">
                    <img src="<?= URLROOT . '/public/assets/logo_text.png' ?>" height="100" alt="Chilaw Pradeshiya Sabha">
                </div>
            </div>
        </div>
        <?php require_once 'navbar.php' ?>
    </div>
    <div class="main">