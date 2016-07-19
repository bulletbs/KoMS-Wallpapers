<?php defined('SYSPATH') or die('No direct script access.');?>
<h1>Просмотр полученой открытки</h1>

<div class="concrete">
    <?php echo HTML::image($card->getImageUri()) ?>
</div>
<div class="block_graybg">
    <b>От: <?php echo $message->user_from ?> (<?php echo $message->email_from ?>)</b><br>
    <br>
    <?php echo $message->message ?><br>
</div>
<br>
<?php echo HTML::anchor(Route::get('cards')->uri(array('action'=>'card', 'id'=>$message->card_id)), 'Переслать эту открытку', array('class'=>'pure-button'))?>&nbsp;
<?php echo HTML::anchor(Route::get('cards_main')->uri(), 'Ответить на эту открытку', array('class'=>'pure-button'))?>
