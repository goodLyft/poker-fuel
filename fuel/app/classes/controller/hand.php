<?php
use Model\Service\Pokerservice;
use Validation\Pokervalidation;

class Controller_Hand extends Controller_Template
{
  public function before()
  {
      parent::before();

      // 初期値設置
      $this->template->title = 'ポーカー';
      View::set_global(array(
          'cards' => '',
          'poker' => '',
      ), null, true);
  }

  public function action_index()
  {
    $this->template->content = View::forge('hand/index');
  }

  public function action_send()
  {
    $errorList = Pokervalidation::validation();
    if (count($errorList) > 0) {
      $this->template->content = View::forge('hand/index', $errorList);
      return;
    }
    $data["cards"] = Input::post("cards");
    $data["poker"] = PokerService::getPoker($data["cards"]);
    $this->template->content = View::forge('hand/index', $data);
  }
}
