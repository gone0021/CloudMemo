<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/CloudMemo/html';
require_once($root . '/app/model/BaseModel.php');

/**
 * TagModel
 */
class TagModel extends BaseModel
{
   /**
    * コンストラクタ
    */
   public function __construct()
   {
      // 親クラスのコンストラクタを呼び出す
      parent::__construct();
   }

   /**
    * tagsを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectTags()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' id';
      $sql .= ' ,user_id';
      $sql .= ' ,tag_name';
      $sql .= ' FROM tags';
      return $sql;
   }

   /**
    * 全てのユーザー情報を取得
    * @return array ユーザーのレコードの配列
    */
   public function getUserTag($user_id)
   {
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectTags();
      $sql .= ' WHERE deleted_at IS NULL ';
      $sql .= ' and user_id = :user_id ';
      $sql .= ' order by id';

      // var_dump($sql);die;

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
}
