<?php
// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/CloudMemo/html";
$url = 'http://' . $rootUrl;
?>

<head>
   <meta charset="UTF-8">
   <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
   <meta http-equiv="content-type">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="同期のできるメモ帳">
   <meta name="keywords" content="メモ帳,同期,アプリ">
   <title>CloudMemo</title>

   <!-- bootstrap -->
   <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->

   <!-- icon -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

   <!-- css -->
   <!-- <link rel="stylesheet" href="./css/normalize.css"> -->
   <link rel="stylesheet" href="<?= $url ?>/css/style.css">
   <link rel="stylesheet" href="<?= $url ?>/css/parts.css">
   <link rel="stylesheet" href="<?= $url ?>/css/icon.css">

   <!-- javascript -->
   <script type="text/javascript" src="<?= $url ?>/js/app.js" defer></script>
   <script type="text/javascript" src="<?= $url ?>/js/style.js" defer></script>

   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

   <!-- vue.js -->
   <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>

   <!-- sxios -->
   <script src="https://cdn.jsdelivr.net/npm/axios@0.17.1/dist/axios.min.js"></script>

   <!-- animated -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" /> -->

</head>