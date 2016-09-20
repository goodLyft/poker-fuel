<?php
namespace Validation;

class Pokervalidation extends \Validation\Util\CoreValidation
{

  public static function validation()
  {
    $error = array();
    $val = \Validation::forge();
    $val->add_callable(new PokerValidation());
    $val->add_field('cards', 'カード', 'required|alphanum|soot|number|max_numeric|min_numeric|unique');
    $val->run();
    if ($val->error()) {
      foreach ($val->error() as $key => $value) {
        $error[$key] = $value->get_message();
      }
    }
    return $error;
  }

  // スートチェック（S：スペード、H：ハート、D：ダイア、C：クラブ）
  public static function _validation_soot($param)
  {
    $flag = true;
    $array = explode(" ", $param);
    for ($i=0; $i < count($array); $i++) {
      if (!preg_match("/^[SHDC]+$/", substr($array[$i], 0, 1))) {
        $flag = false;
        break;
      }
    }
    return $flag;
  }
}
