<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Меню админа"
 */
class Controller_Widgets_AdminCardsMenu extends Controller_System_Widgets {

    public $template = 'widgets/adminsubmenu';    // Шаблон виждета

    public function action_index()
    {
        $select = lcfirst(Request::initial()->controller());
        $menu = array(
            'Открытки' => array('cards'),
            'Категории' => array('cardsCategory'),
        );

        // Вывод в шаблон
        $this->template->menu = $menu;
        $this->template->select = $select;
    }

}