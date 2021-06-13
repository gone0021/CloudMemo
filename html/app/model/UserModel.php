<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/CloudMemo/html';
require_once($root . '/app/model/BaseModel.php');

/**
 * UserModel
 */
class UserModel extends BaseModel
{
   /**
    * コンストラクタ
    */
   public function __construct()
   {
      // 親クラスのコンストラクタを呼び出す
      parent::__construct();
   }

   // --- select ---

   /**
    * ユーザーを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectUser()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' id';
      $sql .= ' ,user_name';
      $sql .= ' ,email';
      $sql .= ' ,birthday';
      $sql .= ' ,password';
      $sql .= ' ,price_plan';
      $sql .= ' ,is_admin';
      $sql .= ' last_login_at';
      $sql .= ' FROM users';
      return $sql;
   }

   /**
    * 全てのユーザー情報を取得
    * @return array ユーザーのレコードの配列
    */
   public function getUser()
   {
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectUser();
      $sql .= ' WHERE deleted_at IS NULL ';
      $sql .= ' order by id';

      // セレクトで取得した情報をSQL文にセット
      $stmt = $this->dbh->prepare($sql);
      // SQL文の実行
      $stmt->execute();
      // PDO::FETCH_ASSOC：カラム名をキーとする連想配列で取得
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   /**
    * ユーザー名から当該ユーザーを検索
    * @param string $name ユーザー名
    * @return array ユーザー情報の配列
    */
   public function getUserName($name)
   {
      // $nameが空だったら、空の配列を返却
      if (empty($name)) {
         return array();
      }

      $sql = $this->selectUser();
      $sql .= ' WHERE deleted_at IS NULL ';
      $sql .= ' and user_name = :user_name ';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_name', $name, PDO::PARAM_STR);
      $stmt->execute();
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      // 検索結果が0件のときは空の配列を返却
      if (!$rec) {
         return array();
      }

      return $rec;
   }

   /**
    * メールアドレスから当該ユーザーを検索
    * @param string $email メールアドレス
    * @return array ユーザー情報の配列
    */
   public function getEmail($email)
   {
      if (empty($email)) {
         return array();
      }

      $sql = $this->selectUser();
      $sql .= ' WHERE deleted_at IS NULL ';
      $sql .= ' and email = :email ';

      $stmt = $this->dbh->prepare($sql);
      // パラメータをバインド（:emailをポストしてきたemailの値へ変換） 
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      // 検索結果が0件のときは空の配列を返却
      if (!$rec) {
         return array();
      }

      return $rec;
   }

   // --- insert ---
   /**
    * ユーザーの新規登録
    * @param array $data 作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function insertUser($data)
   {
      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'INSERT INTO users (';
      $sql .= 'user_name,';
      $sql .= 'email,';
      $sql .= 'birthday,';
      $sql .= 'password';
      $sql .= ') ';
      $sql .= 'values (';
      $sql .= ':user_name,';
      $sql .= ':email,';
      $sql .= ':birthday,';
      $sql .= ':password';
      $sql .= ')';

      // 情報をSQL文にセット
      $stmt = $this->dbh->prepare($sql);
      // パラメータをバインド
      $stmt->bindParam(':user_name', $data['user_name'], PDO::PARAM_STR);
      $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindParam(':birthday', $data['birthday'], PDO::PARAM_STR);
      $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
      // SQL文の実行
      $ret = $stmt->execute();

      return $ret;
   }

   // --- update ---
   
   /**
    * ユーザーのログイン日時の更新
    * @param array $id usersのid
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */

   public function updateUserLastLogin($id) {
      $sql = '';
      $sql .= 'UPDATE users set';
      $sql .= ' last_login_at = CURRENT_TIME';
      $sql .= ' where id = :id';
 
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $ret = $stmt->execute();

      return $ret;
   }


   /**
    * ユーザー情報の更新
    * @param array $data 作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function updatetUserPassword($data)
   {
      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'UPDATE users set ';
      $sql .= 'password = :password ';
      $sql .= 'where email = :email ';

      // 情報をSQL文にセット
      $stmt = $this->dbh->prepare($sql);
      // パラメータをバインド
      $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
      // SQL文の実行
      $ret = $stmt->execute();

      return $ret;
   }

   // --- serch ---
   /**
    * メールアドレスからユーザーを検索してパスワードをチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
    */
   public function checkPassEmail($email, $password)
   {
      $rec = $this->getEmail($email);

      // パスワードの妥当性チェックを行い、妥当性がないときは空の配列を返却
      // password_verify()については、
      // https://www.php.net/manual/ja/function.password-verify.php
      // 参照。
      if (!password_verify($password, $rec['password'])) {
         return array();
      }

      unset($rec['password']);

      return $rec;
   }

   /**
    * メールアドレスからユーザーを検索して誕生日をチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
    */
   public function checkBirthdayForEmail($email, $birthday)
   {
      $rec = $this->getEmail($email);

      if ($birthday != $rec['birthday']) {
         return array();
      }

      unset($rec['password']);

      return $rec;
   }
}
