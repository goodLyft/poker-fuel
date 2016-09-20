<?php
namespace Model\Service;

class PokerService extends \Model{
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

    public static function getPoker($cards)
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
      $strPokerHand = self::getPairPoker($numberList);
      if (strlen($strPokerHand) == 0) {
        $isFlush = self::isFlash($cardList);
        $isStraight = self::isStraight($numberList);
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
    private static function isFlash($cardList) {
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
    private static function isStraight($numberList) {

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
    private static function getPairPoker($numberList) {

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
}
