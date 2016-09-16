<?php

class Controller_Hand extends Controller_Template
{
  private static $pokerList = array(
    "onePair" => "ワンペア",
    "twoPair" => "ツーペア",
    "threeCard" => "スリー・オブ・ア・カインド",
    "fourCard" => "フォー・オブ・ア・カインド",
    "fullHouse" => "フルハウス",
    "straight" => "ストレート",
    "straightFlush" => "ストレートフラッシュ",
    "flush" => "フラッシュ",
    "poor" => "ハイカード",
  );

  public function action_index()
  {
    $data["cards"] = "";
    $data["poker"] = "";
    $this->template->title = 'ポーカー';
    $this->template->content = View::forge('hand/index', $data);
  }

  public function action_send()
  {
    $this->template->title = 'ポーカー';
    $validation = $this->validation_input();
    if ($validation->error()) {
      $this->template->content = View::forge('hand/index', $validation->error());
      return;
    }

    $data["cards"] = Input::post("cards");
    $data["poker"] = $this->getPoker($data["cards"]);
    $this->template->content = View::forge('hand/index', $data);
  }

  private function getPoker($cards)
  {
    // 初期値
    $strPokerHand = "";
    // 配列にセット
    $cardList = explode(" ", $cards);
    // 数字のみ配列
    $numberList = array();
    foreach ($cardList as $index => $card) {
      array_push($numberList, intval(substr($card, 1, 2)));
    }

    // 判定
    $strPokerHand = $this->getPairPoker($numberList);
    if (strlen($strPokerHand) == 0) {
      $isFlush = $this->isFlash($cardList);
      $isStraight = $this->isStraight($numberList);
      if ($isFlush && $isStraight) {
        $strPokerHand = self::$pokerList["straightFlush"];
      } elseif ($isFlush) {
        $strPokerHand = self::$pokerList["flush"];
      } elseif ($isStraight) {
        $strPokerHand = self::$pokerList["straight"];
      }

    }

    if (strlen($strPokerHand) == 0) {
      $strPokerHand = self::$pokerList["poor"];
    }

    return $strPokerHand;
  }

  /**
  * フラッシュ判定
  * return: boolean
  */
  private function isFlash($cardList) {
    $flush = true;
    $base = substr($cardList[0], 0, 1);

    for ($i=0; $i < count($cardList); $i++) {
      if ($base != substr($cardList[$i], 0, 1)) {
        $flush = false;
        break;
      }
    }
    return $flush;
  }

  /**
  * ストレート判定
  * return: boolean
  */
  private function isStraight($numberList) {

    $straight = false;
    // ストレート判定
    if (max($numberList) - min($numberList) <= 4) {
      $straight = true;
    }

    if (!$straight) {
      // ロイヤルストレート判定
      for ($i=0; $i < count($numberList); $i++) {
        if ($numberList[$i] == 1) {
          // 置き換え
          $numberList[$i] = 14;
        }
      }
    }

    // 再度判定
    if (max($numberList) - min($numberList) <= 4) {
      $straight = true;
    }

    return $straight;
  }

  /**
  * 組み合わせ役
  * return: number
  */
  private function getPairPoker($numberList) {

    $pairCount = 0;
    $strPoker = "";

    for ($i=0; $i < count($numberList) - 1; $i++) {
      for ($j=$i+1; $j < count($numberList); $j++) {
        if ($numberList[$i] == $numberList[$j]) {
          $pairCount++;
        }
      }
    }

    switch ($pairCount) {
      case 1:
        $strPoker = self::$pokerList["onePair"];
        break;
      case 2:
        $strPoker = self::$pokerList["twoPair"];
        break;
      case 3:
        $strPoker = self::$pokerList["threeCard"];
        break;
      case 4:
        $strPoker = self::$pokerList["fullHouse"];
        break;
      case 6:
        $strPoker = self::$pokerList["fourCard"];
        break;

      default:
        break;
    }

    return $strPoker;
  }

  private static function validation_input()
  {
    $val = Validation::forge();
    $val->add_callable(new Customvalidation());
    $val->add_field('cards', 'カード', 'required|alphanum|soot|number|max_numeric|min_numeric|unique');
    $val->run();
    return $val;
  }

}


/**
 * カスタムバリデーション
 */
class Customvalidation {
  // 数字チェック・半角スペースチェック
  public static function _validation_alphanum($param)
  {
    return (preg_match("/^[SHDC0-9 ]+$/", $param)) ? true : false;
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

  // 枚数チェック
  public static function _validation_number($param)
  {
    return count(explode(" ", $param)) == 5;
  }

  // MAX 数値
  public static function _validation_max_numeric($param)
  {
    $array = explode(" ", $param);
    $numberList = array();
    foreach ($array as $index => $card) {
      array_push($numberList, intval(substr($card, 1, 2)));
    }
    return max($numberList) < 14;
  }

  // MIN 数値
  public static function _validation_min_numeric($param)
  {
    $array = explode(" ", $param);
    $numberList = array();
    foreach ($array as $index => $card) {
      array_push($numberList, intval(substr($card, 1, 2)));
    }
    return max($numberList) > 0;
  }

  // ユニークチェック
  public static function _validation_unique($param)
  {
    $array = explode(" ", $param);
    return count(array_unique($array)) == 5;
  }
}
