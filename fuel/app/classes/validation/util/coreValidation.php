<?php
namespace Validation\Util;

class CoreValidation {
  // 数字チェック・半角スペースチェック
  public static function _validation_alphanum($param)
  {
    return (preg_match("/^[SHDC0-9 ]+$/", $param)) ? true : false;
  }

  // 枚数チェック
  public static function _validation_number($param, $num=5)
  {
    return count(explode(" ", $param)) == $num;
  }

  // MAX 数値
  public static function _validation_max_numeric($param, $limitNum=14)
  {
    $array = explode(" ", $param);
    $numberList = array();
    foreach ($array as $index => $card) {
      array_push($numberList, intval(substr($card, 1, 2)));
    }
    return max($numberList) < $limitNum;
  }

  // MIN 数値
  public static function _validation_min_numeric($param, $limitNum=0)
  {
    $array = explode(" ", $param);
    $numberList = array();
    foreach ($array as $index => $card) {
      array_push($numberList, intval(substr($card, 1, 2)));
    }
    return max($numberList) > $limitNum;
  }

  // ユニークチェック
  public static function _validation_unique($param, $uniqNum=5)
  {
    $array = explode(" ", $param);
    return count(array_unique($array)) == $uniqNum;
  }
}
