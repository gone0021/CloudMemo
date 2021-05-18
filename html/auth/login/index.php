<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/Util/SessionUtil.php");

// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// SESSIONに保存したPOSTデータ（パスワードは保存しない）
// ユーザー名
$name = "";
if (!empty($_SESSION['post']['name'])) {
   $name =  $_SESSION['post']['name'];
}
// メールアドレス
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
// 誕生日
$birthday = date("2000-01-01");
if (!empty($_SESSION['post']['birthday'])) {
   $birthday = $_SESSION['post']['birthday'];
}

$title = 'CloudMemo';
?>

<!DOCTYPE html>
<html lang="jp">
<?php require_once($root . "../head.php"); ?>

<body>
   <div id="app">
      <div class="container">
         <span id="pagetop"></span>
         <?php require_once($root . "../header.php"); ?>
         <?php require_once($root . "./auth/sidenavi.php"); ?>

         <div class="contents">
            <div id="main">
               <section id="register">

                  <!-- 送信フォーム -->
                  <h2 class="title">Login<span>ログイン</span></h2>

                  <?php if (!empty($_SESSION["msg"]["error"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["error"] ?>
                     </p>
                  <?php endif ?>

                  <form action="./login.php" method="post">
                     <input type="hidden" class="ws" name="token" value="<?= $token ?>">

                     <table class="ta2">
                        <tr>
                           <th>メールアドレス</th>
                           <td>
                              <input type="email" name="email" id="email" class="ws" value="">
                           </td>
                        </tr>

                        <tr>
                           <th>パスワード</th>
                           <td>
                              <input type="password" name="password" id="password" class="ws">
                           </td>
                        </tr>

                     </table>

                     <div class="center">
                        <input type="submit" value="確認" class="btn" @click="onRegCheck()">
                        <input type="reset" value="リセット" class="btn">
                     </div>
                  </form>

                  <div class="center">
                     <a href="../pass/">パスワードを忘れた方はこちら</a>
                  </div>
                  <!-- <home-home></home-home> -->
               </section>

            </div>
            <!-- /#main -->

         </div>
         <!-- /#contents -->
         <!-- <div class="push"></div> -->
         <?php require_once($root . "../footer.php"); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" :class="classOpenClose" @click="onOpenClose()"></div>

   </div>
   <!-- /#app -->
</body>

</html>