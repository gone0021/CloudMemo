<?php
// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/CloudMemo/html";
$url = 'http://' . $rootUrl;
?>

<header id="header" class="site_header">
   <div class="header_logo">
      <a href="<?= $url ?>"><img src="<?= $url ?>/images/logo.png" alt="CloudMemo"></a>
   </div>
   <div class="header_title">
      <a href="<?= $url ?>">Cloud Memo</a>
   </div>
   
   <nav class="nav_auth">
      <ul class="nav_menu">
         <li class="nav_item"><a href="<?= $url ?>/auth/login/">ログイン</a>
         </li>
         <li class="nav_item"><a href="<?= $url ?>/auth/register/">新規登録</a>
         </li>
      </ul>
   </nav>

</header>