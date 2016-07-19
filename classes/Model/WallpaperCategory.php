<?php

class Model_CardCategory extends ORM{

    const CATEGORY_COUNTS_CACHE = 'cards_cache';
    const CATEGORY_OPTIONS_CACHE = 'cards_cache';
    const CATEGORY_CACHE_TIME = 86400;

    protected $_table_name = 'cards_category';
    protected $_has_many = array(
        'cards' => array(
            'model' => 'Card',
            'foreign_key' => 'category_id',
        ),
    );

    protected $_uriToMe;

    public function labels(){
        return array(
            'id' => 'Id',
            'alias' => 'Алиас',
            'name' => 'Название',
            'amount' => 'Открыток',
        );
    }

    /**
     * Getting category options list for HTML::select
     * @return array|mixed
     */
    public function getOptionList(){
        if(!$options = Cache::instance()->get(Model_CardCategory::CATEGORY_OPTIONS_CACHE)){
            $options = array();
            $categories = ORM::factory('CardCategory')->find_all();
            foreach($categories as $category)
                $options[$category->id] = $category->name;
            Cache::instance()->set(Model_CardCategory::CATEGORY_OPTIONS_CACHE, $options, Model_CardCategory::CATEGORY_CACHE_TIME);
        }
        return $options;
    }

    /**
     * Getting card uri
     * @return string
     */
    public function getUri(){
        if(is_null($this->_uriToMe)){
            $this->_uriToMe = Route::get('cards_category')->uri(array(
                'id' => $this->id,
                'alias' => $this->alias,
            ));
        }
        return $this->_uriToMe;
    }

    /**
     * @return array|mixed
     * @throws Cache_Exception
     */
    public static function getCounts(){
        $result = array();
        Cache::instance()->delete(self::CATEGORY_COUNTS_CACHE);
        if(NULL === ($result = Cache::instance()->get(self::CATEGORY_COUNTS_CACHE))){
            $counts = DB::select(array(DB::expr('DISTINCT(`category_id`)'), 'category_id'), array(DB::expr('COUNT(`category_id`)'), 'cnt'))
                ->from(ORM::factory('Card')->table_name())
                ->group_by('category_id')
                ->execute();
            foreach ($counts as $count)
                $result[$count['category_id']] = $count['cnt'];
            Cache::instance()->set(self::CATEGORY_COUNTS_CACHE, $result, Date::DAY);
        }
        return $result;
    }
}