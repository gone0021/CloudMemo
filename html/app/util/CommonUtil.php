<?php

/**
 * 共通関数クラスです。
 */
class CommonUtil
{
   /**
    * POSTされたデータをサニタイズする
    *
    * @param array $before サニタイズ前のPOST配列
    * @return array サニタイズ後のPOST配列
    */
   public static function sanitaize($before)
   {
      $after = array();

      // postされたデータを
      foreach ($before as $k => $v) {
         $after[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
      }
      // GoogleMapのiframeのみデコード
      if (!empty($after['map_item']) && preg_match("/&lt;iframe src=\&quot;https:\/\/www.google\.com\/maps(.*?)&lt;\/iframe&gt;/s", $after['map_item'])) {
         $after['map_item'] = htmlspecialchars_decode($after['map_item'], ENT_QUOTES);
      }
      return $after;
   }
   // googleMapのiframe文字列の参考
   // https://ja.stackoverflow.com/questions/28159/iframe%E3%82%92%E6%AD%A3%E8%A6%8F%E8%A1%A8%E7%8F%BE%E3%81%A7%E5%88%A4%E5%88%A5%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95

}
