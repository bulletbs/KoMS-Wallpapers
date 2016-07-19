<?php

class Model_CardMessage extends ORM{

    protected $_table_name = 'cards_message';

    protected $_belongs_to= array(
        'card' => array(
            'model' => 'Card',
            'foreign_key' => 'card_id',
        ),
    );

    public function labels(){
        return array(
            'id' => 'Id',
            'category_id' => 'Категория',
            'title' => 'Подпись',
            'views' => 'Просмотров',
            'type' => 'Тип',
            'swf' => 'Flash uri',
            'swf_width' => 'ширина Flash',
            'swf_height' => 'высота Flash',
        );
    }
}