<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Cards extends Controller_Admin_Crud{

    public $submenu = 'AdminCardsMenu';

    public $skip_auto_render = array(
        'delete',
    );

    protected $_item_name = 'card';
    protected $_crud_name = 'Cards';

    protected $_model_name = 'Card';
    protected $_orderby_field = 'id';

    public $list_fields = array(
        'id',
        'title',
    );

    protected $_filter_fields = array(
        'category_id' => array(
            'label' => 'Показать категорию',
            'type' => 'select',
        ),
    );

    public $_form_fields = array(
        'title' => array('type'=>'text'),
        'category_id' => array(
            'type'=>'select',
            'data'=>array('options'=>array())
        ),
        'photo' => array(
            'type'=>'call_view',
            'data'=>'admin/cards/file',
            'advanced_data'=>array(
                'file'=>array(),
            )
        ),
    );

    protected $_advanced_list_actions = array(
//        array(
//            'action'=>'status',
//            'label'=>'On/Off',
//            'icon'=>array(
//                'field'=>'enable',
//                'values' => array(
//                    '0' => 'eye-close',
//                    '1' => 'eye-open',
//                ),
//            ),
//        ),
    );


    public function action_index(){
        /* Filter Parent_id initialize  */
        $this->_filter_fields['category_id']['data']['options'][0] = 'Все категории';
        $this->_filter_fields['category_id']['data']['options'] = array_merge($this->_filter_fields['category_id']['data']['options'], ORM::factory('CardCategory')->getOptionList());

        if(!isset($this->_filter_values['category_id']))
            $this->_filter_values['category_id'] = 0;
        $this->_filter_fields['category_id']['data']['selected'] = $this->_filter_values['category_id'];

        parent::action_index();
    }

    /**
     * Form preloader
     * @param $model
     * @param array $data
     * @return array|bool|void
     */
    protected function _processForm($model, $data = array()){
        /* Setting categories select field */
        $this->_form_fields['category_id']['data']['options'] = ORM::factory('CardCategory')->getOptionList();
        $this->_form_fields['category_id']['data']['selected'] = $model->category_id;

        /* Setting photos field */
        if(!empty($model->type))
            $this->_form_fields['photo']['advanced_data']['image'] = Model_Card::CARDS_UPLOAD_PATH . $model->id .'.'.$model->type;
        if(!empty($model->swf)){
            $this->_form_fields['photo']['advanced_data']['swf'] = Model_Card::CARDS_UPLOAD_PATH . $model->id .'.swf';
            $this->_form_fields['photo']['advanced_data']['swf_width'] = $model->swf_width;
            $this->_form_fields['photo']['advanced_data']['swf_height'] = $model->swf_height;
        }

        parent::_processForm($model);
    }

    /**
     * Saving Model Method
     * @param $model
     */
    protected function _saveModel($model){
//        echo Debug::vars($_POST);
//        die();
        if(file_exists($_FILES['photoSource']['tmp_name']))
            $model->saveCardPhoto($_FILES['photoSource']['tmp_name']);
        parent::_saveModel($model);
    }

    /**
     * On/Off item
     */
    public function action_status(){
        $article = ORM::factory('News', $this->request->param('id'));
        if($article->loaded()){
            $article->flipStatus();
        }
        $this->redirect($this->_crud_uri . URL::query());
    }

    /**
     * Loading model to render form
     * @param null $id
     * @return ORM
     */
    protected function _loadModel($id = NULL){
        $model = ORM::factory($this->_model_name, $id);
//        $this->_form_fields['photo']['data'] = $model->getThumb();

        return $model;
    }
}
