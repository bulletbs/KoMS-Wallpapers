<?php defined('SYSPATH') or die('No direct script access.');?>
<h1>Открытки</h1>

<?if(isset($categories)):?>
    <?php foreach ($categories as $category) :?>
        <div class="sectionLink"><?php echo HTML::anchor($category->geturi(), $category->name, array('class'=>$alias == $category->alias ?  : ''))?> <span>(<?= (isset($counts[$category->id]) ? $counts[$category->id] : 0 )?>)</span></div>
    <?php endforeach; ?>
    <div class="clear"></div>
<?endif;?>
<br>

<ul class="cards_wrapper">
<?php foreach ($cards as $card) :?>
    <li>
        <?php echo HTML::anchor($card->getUri(), HTML::image($card->getThumbUri()))?>
        <span><?php echo $card->title ?></span>
    </li>
<?php endforeach; ?>
</ul>
<?php echo $pagination->render() ?>
