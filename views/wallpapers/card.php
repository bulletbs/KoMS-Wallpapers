<?php defined('SYSPATH') or die('No direct script access.');?>
<h1><?php echo $card->title?></h1>
<div class="concrete">
    <?if($card->swf):?>
        <object data="<?php echo $card->getFlashUri() ?>" height="<?php echo $card->swf_height?>px" width="<?php echo $card->swf_width?>px" type="application/x-shockwave-flash">
            <param name="allowScriptAccess" value="sameDomain">
            <param name="quality" value="high">
            <param name="wmode" value="transparent">
        </object>
    <?else:?>
        <?php echo HTML::image($card->getImageUri())?>
    <?endif;?>
</div>
<Br>
<Br>
<h1>Отправить открытку</h1>
<form action="" method="post" class="pure-form block_graybg">
    <?if(isset($errors)) echo View::factory('error/validation', array('errors'=>$errors))->render()?>
    <div class="address">
        <h4>Кому</h4>
        <label><span class="zvzd">*</span> Имя получателя</label>
        <input type="text" name="user_to" value="<?php echo Arr::get($_POST, 'user_to')?>">
        <label><span class="zvzd">*</span> E-mail получателя</label>
        <input type="text" name="email_to" value="<?php echo Arr::get($_POST, 'email_to')?>">
    </div>
    <div class="address">
        <h4>От кого</h4>
        <label><span class="zvzd">*</span> Имя отправителя</label>
        <input type="text" name="user_from" value="<?php echo Arr::get($_POST, 'user_from')?>">
        <label><span class="zvzd">*</span> E-mail отправителя</label>
        <input type="text" name="email_from" value="<?php echo Arr::get($_POST, 'email_from')?>">
    </div>
    <div class="clear"></div>
    <div class="message">
        <label>Текст поздравления</label>
        <textarea name="message"><?php echo Arr::get($_POST, 'message')?></textarea>

        <Br><br><?php echo Captcha::instance() ?>
        <?= Form::label('captcha', __('Enter captcha code')) ?>
        <?php echo Form::input('captcha', NULL, array('id' => 'captcha-key'))?>
    </div>
    <input type="submit" value="Отправить" class="pure-button pure-button-primary">
    <div class="clear"></div>
</form>
<br>
<h2>Другие открытки из рубрики «<?= $category->name?>»</h2>
<ul class="cards_wrapper">
<?php foreach ($other_cards as $card) :?>
    <li>
        <?php echo HTML::anchor($card->getUri(), HTML::image($card->getThumbUri()))?>
        <span><?php echo $card->title ?></span>
    </li>
<?php endforeach; ?>
</ul>
<div class="clear"></div>