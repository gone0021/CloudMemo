<?php
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/CloudMemo/html";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/util/ValidationUtil.php");
require_once($root . "/app/model/UserModel.php");

// セッションスタート
SessionUtil::sessionStart();


// フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
   $_SESSION['msg']['err'] = "不正な処理が行われました。";
   header('Location: ./');
   exit;
}
// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// ユーザークラスのインスタンス
$userModel = new UserModel();

// バリデーションチェック
$validityCheck = array();
// 名前のバリデーション
$validityCheck[] = validationUtil::isValidName(
   $post['name'],
   $_SESSION['msg']['name']
);
// // メールアドレスのバリデーション
// $validityCheck[] = validationUtil::isValidEmail(
//    $post['email'],
//    $_SESSION['msg']['email']
// );

// // 誕生日のバリデーション
// $validityCheck[] = validationUtil::isBirthday(
//    $post['birthday'],
//    $_SESSION['msg']['birthday']
// );
// // メールアドレスのバリデーション
// $validityCheck[] = validationUtil::isValidPass(
//    $post['pass1'],
//    $_SESSION['msg']['pass1']
// );
// // ダブルチェック
// $validityCheck[] = validationUtil::isDoubleCheck(
//    $post['pass1'],
//    $post['pass2'],
//    $_SESSION['msg']['pass2']
// );

// var_dump($validityCheck);


// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      header('Location: ./');
      exit;
   }
}

// パスワードの暗号化
$hash = password_hash($post['pass2'], PASSWORD_DEFAULT);

// パスワードを伏せ字に
$pass = str_repeat('*', strlen($post["pass2"]));
// $hide = $post["pass2"];

// エラーメッセージをクリア
unset($_SESSION['msg']);
$_SESSION['msg'] = null;

//  var_dump($hide);
// ページタイトル
$title = '登録内容の確認';
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
                  <h2 class="title">REGISTER<span>新規登録</span></h2>

                  <form action="./register.php" method="post">
                     <input type="hidden" name="token" value="<?= $token ?>">

                     <table class="ta2">
                        <tr>
                           <th>ユーザー名</th>
                           <td>
                              <?= $post['name'] ?>
                              <input type="hidden" name="name" value="<?= $post['name'] ?>">
                           </td>
                        </tr>

                        <tr>
                           <th>メールアドレス</th>
                           <td>
                              <?= $post['email'] ?>
                              <input type="hidden" name="email" value="<?= $post['email'] ?>">
                           </td>
                        </tr>

                        <tr>
                           <th>誕生日</th>
                           <td>
                              <?= $post['birthday'] ?>
                              <input type="hidden" name="birthday" value="<?= $post['birthday'] ?>">
                           </td>
                        </tr>

                        <tr>
                           <th>パスワード</th>
                           <td>
                              <?= $post["pass2"] ?>
                              <input type="hidden" name="pass2" value="<?= $hash ?>">
                           </td>

                        </tr>
                     </table>

                     <div class="center">
                        <input type="submit" value="送信" class="btn ">
                        <!-- <button onclick="location.href='./';"> 戻る</button> -->
                        <input type="button" value="戻る" class="btn " onclick="location.href='./';">
                     </div>
                  </form>
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