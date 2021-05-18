<?php
// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/CloudMemo/html";
$url = 'http://' . $rootUrl;
?>

<!--PC用（801px以上端末）で表示させるブロック-->
<aside class="pc">
   <!--PC用（801px以上端末）-->
   <nav id="menubar">
      <ul>
         <li class="menuimg svg-home current"><a href="../../"><span>Home</span></a></li>
         <li class="menuimg svg-login"><a href="../login/"><span>login</span></a></li>
         <li class="menuimg svg-pen2"><a href="../register"><span>regisetr</span></a></li>
      </ul>
   </nav>
   <ul class="icon">
      <li><a href="#"><img src="../../images/icon_facebook.png" alt="Facebook"></a></li>
      <li><a href="#"><img src="../../images/icon_twitter.png" alt="Twitter"></a></li>
      <li><a href="#"><img src="../../images/icon_instagram.png" alt="Instagram"></a></li>
      <li><a href="#"><img src="../../images/icon_youtube.png" alt="YouTube"></a></li>
   </ul>
</aside>
<!--/.pc-->

<!--小さな端末用（800px以下端末）-->
<aside class="sh">
   <div id="menubar_s" v-if="isOpenClose">
      <nav>
         <ul>
            <li class="menuimg svg-home current"><a href="../../"><span>Home</span></a></li>
            <li class="menuimg svg-login"><a href="../login/"><span>login</span></a></li>
            <li class="menuimg svg-pen2"><a href="../register"><span>regisetr</span></a></li>
         </ul>
      </nav>
      <ul class="icon">
         <li><a href="#"><img src="../../images/icon_facebook.png" alt="Facebook"></a></li>
         <li><a href="#"><img src="../../images/icon_twitter.png" alt="Twitter"></a></li>
         <li><a href="#"><img src="../../images/icon_instagram.png" alt="Instagram"></a></li>
         <li><a href="#"><img src="../../images/icon_youtube.png" alt="YouTube"></a></li>
      </ul>
   </div>
   <!--/#menubar-s-->
</aside>
<!--/.sh-->