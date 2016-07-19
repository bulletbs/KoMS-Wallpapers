<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_CardsCategory extends Controller_Admin_Crud
{
    public $submenu = 'AdminCardsMenu';

    protected $_item_name = 'category';
    protected $_crud_name = 'Cards Categories';

    protected $_model_name = 'CardCategory';

    public $list_fields = array(
        'id',
        'name',
    );

    public $_form_fields = array(
        'name' => array('type'=>'text'),
        'alias' => array('type'=>'text'),
    );


    /**
     * Form preloader
     * @param $model
     * @param array $data
     * @return array|bool|void
     */
    protected function _processForm($model, $data = array()){

        parent::_processForm($model);
    }

    /**
     * Loading model to render form
     * @param null $id
     * @return ORM
     */
    protected function _loadModel($id = NULL){
        $model = ORM::factory($this->_model_name, $id);
        return $model;
    }
}
