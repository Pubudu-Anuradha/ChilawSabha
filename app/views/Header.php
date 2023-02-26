<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= URLROOT . '/public/css/main.css' ?>">
    <?php foreach ($styles as $style) { ?>
        <link rel="stylesheet" href="<?= URLROOT . '/public/css/' . $style ?>.css">
    <?php } ?>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
</head>

<body>
    <div class="header">
        <div class="logo-area">
            <div class="logo-items" onclick="window.location.href= '<?=URLROOT . '/Home'?>'">
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