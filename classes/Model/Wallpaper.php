<?php

class Model_Card extends ORM {
    CONST CARDS_UPLOAD_PATH = 'media/upload/cards/';

    protected $_table_name = 'cards';
    protected $_belongs_to = array(
        'category' => array(
            'model' => 'CardCategory',
            'foreign_key' => 'category_id',
        )
    );

    protected $_uriToMe;

    public function labels()
    {
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


    public function delete()
    {
        if (file_exists(self::CARDS_UPLOAD_PATH . $this->id . '.' . $this->type))
            unlink(self::CARDS_UPLOAD_PATH . $this->id . '.' . $this->type);
        if (file_exists(self::CARDS_UPLOAD_PATH . $this->id . '.swf'))
            unlink(self::CARDS_UPLOAD_PATH . $this->id . '.swf');
        parent::delete();
    }

    /**
     * @param $file
     */
    public function saveCardPhoto($file){
        if(file_exists($file) && Image::isImage($file)){
            $image = Image::factory($file);
            $this->type = $image->findExtension();
            $image->image_set_max_edges(600,600);
            $image->save(DOCROOT . self::CARDS_UPLOAD_PATH . $this->id . '.' . $this->type, 85);
            $image->image_fixed_resize(100, 100);
            $image->save(DOCROOT . self::CARDS_UPLOAD_PATH . $this->id .'_thumb'. '.' . $this->type, 85);
        }
    }

    /**
     * Getting card uri
     * @return string
     */
    public function getUri(){
        if(is_null($this->_uriToMe)){
            $this->_uriToMe = Route::get('cards')->uri(array(
                'id' => $this->id,
                'action' => 'card',
            ));
        }
        return $this->_uriToMe;
    }

    /**
     * @return string
     */
    public function getImageUri(){
        return self::CARDS_UPLOAD_PATH . $this->id . '.' . $this->type;
    }

    /**
     * @return string
     */
    public function getThumbUri(){
        return self::CARDS_UPLOAD_PATH . $this->id . '_thumb.' . $this->type;
    }

    /**
     * @return string
     */
    public function getFlashUri(){
        return self::CARDS_UPLOAD_PATH . $this->id . '.swf';
    }
}