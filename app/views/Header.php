<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        @font-face {
            font-family: Noto Emoji;
            src: url(<?=URLROOT . '/public/fonts/NotoEmoji.ttf'?>);
            font-display: swap;
        }
        /* latin-ext */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url(<?= URLROOT . '/public/fonts/PoppinsLatExt.woff2' ?>) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            font-display: swap;
        }
        /* latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url(<?= URLROOT . '/public/fonts/PoppinsLat.woff2' ?>) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            font-display: swap;
        }
    </style>
    <link rel="stylesheet" href="<?= URLROOT . '/public/css/main.css' ?>">
    <?php foreach ($styles as $style) { ?>
        <link rel="preload" href="<?= URLROOT . '/public/css/' . $style ?>.css"
            as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="<?= URLROOT . '/public/css/' . $style ?>.css">
        </noscript>
    <?php } ?>
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
</head>

<body>
    <div class="header">
        <div class="logo-area">
            <div class="logo-items" onclick="window.location.href= '<?=URLROOT . '/Home'?>'">
                <div class="logo">
                    <img src="<?= URLROOT . '/public/assets/logo.webp' ?>" height="100" width="90" alt="Sabha Logo">
                </div>
                <div class="sabha-title">
                    <img src="<?= URLROOT . '/public/assets/logo_text.webp' ?>" height="100" alt="Chilaw Pradeshiya Sabha">
                </div>
            </div>
        </div>
        <?php require_once 'navbar.php' ?>
    </div>
    <div class="main">