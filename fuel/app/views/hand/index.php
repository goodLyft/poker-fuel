<?php echo Form::open('hand/send'); ?>
  <div class="form-group">
    <div class="form-group">
      <?php echo Form::label('カードを入力してください ','cardLabel'); ?>
      <?php echo Form::Input('cards', '', array('class' => 'form-control', 'placeholder' => 'D1 D2 D3 D4 D5')); ?>
    </div>
    <div class="form-group">
      <?php echo $cards; ?><br />
      <?php echo $poker; ?>
    </div>
    <div class="form-group">
      <?php echo Form::button('submit', 'Send Poker', array('class' => 'btn center btn-primary')); ?>
    </div>
    <div class="form-group">
      <small class="form-text text-muted">スート（S：スペード、H：ハート、D：ダイア、C：クラブ）</small><br />
      <small class="form-text text-muted">カード（1 - 13）</small><br />
      <small class="form-text text-muted">ストレートフラッシュ：例）C7 C6 C5 C4 C3</small><br />
      <small class="form-text text-muted">フォー・オブ・ア・カインド：例）C10 D10 H10 S10 D5</small><br />
      <small class="form-text text-muted">フルハウス：例）S10 H10 D10 S4 D4</small><br />
      <small class="form-text text-muted">フラッシュ：例）H1 H12 H10 H5 H3</small><br />
      <small class="form-text text-muted">ストレート：例）S8 S7 H6 H5 S4</small><br />
      <small class="form-text text-muted">スリー・オブ・ア・カインド：例）S12 C12 D12 S5 C3</small><br />
      <small class="form-text text-muted">ツーペア：例）H13 D13 C2 D2 H11</small><br />
      <small class="form-text text-muted">ワンペア：例）C10 S10 S6 H4 H2</small><br />
      <small class="form-text text-muted">ハイカード：例）D1 D10 S9 C5 C4</small><br />
    </div>
<?php echo Form::close(); ?>
