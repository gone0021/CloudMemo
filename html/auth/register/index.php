<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/util/SessionUtil.php");

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
                  <h2 class="title">Regiter<span>新規登録</span></h2>

                  <form action="./check.php" method="post">
                     <input type="hidden" name="token" value="<?= $token ?>">

                     <table class="ta2">
                        <tr>
                           <th>ユーザー名</th>
                           <td>
                              <input type="text" name="name" value="<?= $name ?>" id="name" class="">

                              <!-- バリデーション -->
                              <?php if (isset($_SESSION['msg']['name'])) : ?>
                                 <p class="error"><?= $_SESSION['msg']['name'] ?></p>
                              <?php endif ?>
                           </td>
                        </tr>

                        <tr>
                           <th>メールアドレス</th>
                           <td>
                              <input type="text" name="email" value="<?= $email ?>" id="email" class="">

                              <!-- バリデーション -->
                              <?php if (isset($_SESSION['msg']['email'])) : ?>
                                 <p class="error"><?= $_SESSION['msg']['email'] ?></p>
                              <?php endif ?>
                           </td>
                        </tr>

                        <tr>
                           <th>誕生日</th>
                           <td>
                              <input type="date" name="birthday" value="<?= $birthday ?>" id="birthday" class="">

                              <!-- バリデーション -->
                              <?php if (isset($_SESSION['msg']['pass1'])) : ?>
                                 <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
                              <?php endif ?>
                           </td>
                        </tr>

                        <tr>
                           <th>パスワード</th>
                           <td>
                              <input type="password" name="password">

                              <!-- バリデーション -->
                              <?php if (isset($_SESSION['msg']['pass2'])) : ?>
                                 <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
                              <?php endif ?>
                           </td>

                        </tr>

                        <tr>
                           <th>パスワード（確認用）</th>
                           <td>
                              <input type="password" name="pass2" id="pass2" class="">

                              <!-- バリデーション -->
                              <?php if (isset($_SESSION['msg']['pass2'])) : ?>
                                 <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
                              <?php endif ?>
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
         <?php require_once($root . "./footer.php"); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" :class="classOpenClose" @click="onOpenClose()"></div>

   </div>
   <!-- /#app -->
</body>

</html>