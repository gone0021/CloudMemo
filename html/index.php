<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/Util/SessionUtil.php");
// require_once('./app/util/SessionUtil.php');

// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

$title = 'CloudMemo';
?>

<!DOCTYPE html>
<html hreflang="ja">
<?php require_once($root . "./head.php"); ?>

<body>
   <div id="app">
      <div class="container">
         <span id="pagetop"></span>
         <!-- side-navi -->
         <!-- <home-header></home-header> -->

         <?php require_once($root . "./header.php"); ?>
         <?php require_once($root . "./sidenavi.php"); ?>
         <!-- /side-navi -->


         <div class="contents">
            <div id="main">
               <section>
                  <h1>クラウドで同期してどこでも使えるメモ帳</h1>
               </section>

               <section id="home" v-if="isHome">
                  homeでスライド入れる
               </section>

               <home-about v-if="isAbout"></home-about>
               <home-news v-if="isNews"></home-news>
               <home-contact v-if="isContact"></home-contact>
               <!-- <home-home></home-home> -->
            </div>
            <!-- /#main -->
         </div>
         <!-- /#contents -->

         <?php require_once($root . "./footer.php"); ?>

      </div>
      <!-- /#container -->

      <!-- ページの上部に戻るボタン -->
      <p class="nav-fix-pos-pagetop"><a href="#pagetop">↑</a></p>

      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" :class="classOpenClose" @click="onOpenClose()"></div>

   </div>
   <!-- /#app -->

   <script type="text/javascript" src="./js/template/homeHeader.js"></script>
   <script type="text/javascript" src="./js/template/homeHome.js"></script>
   <script type="text/javascript" src="./js/template/homeNews.js"></script>
   <script type="text/javascript" src="./js/template/homeAbout.js"></script>
   <script type="text/javascript" src="./js/template/homeContact.js"></script>

   <script>
      let token = '<?php echo $token ?>';
      // console.log(token);
   </script>

</body>

</html>