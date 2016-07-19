<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="well well-small" id="photoInputs">
    <?if(isset($advanced_data['swf'])):?>
        <h3>Загруженный flash</h3>
        <object width="<?php echo $advanced_data['swf_width']?>" height="<?php echo $advanced_data['swf_width']?>" data="<?php echo $advanced_data['swf'] ?>"></object>
    <?elseif(isset($advanced_data['image'])):?>
        <h3>Загруженная открытка</h3>
        <?php echo HTML::image($advanced_data['image'])?>
    <?endif?>

    <h3>Загрузить открытку</h3>
    <div class="form-group">
        <?php echo Form::label('photoSource', 'Картинка', array('class' => 'control-label'))?>
        <?php echo Form::file('photoSource', array('class' => 'form-control'))?>
    </div>
<!--    <div class="form-group">-->
<!--        --><?php //echo Form::label('swfSource', 'Flash', array('class' => 'control-label'))?>
<!--        --><?php //echo Form::file('swfSource', array('class' => 'form-control'))?>
<!--    </div>-->
</div>