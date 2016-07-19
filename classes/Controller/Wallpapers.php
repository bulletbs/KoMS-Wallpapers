<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Котроллер справочного раздела
 */

class Controller_Cards extends Controller_System_Page
{
    public function before(){
        parent::before();
        $this->styles[] = 'assets/cards/css/cards.css';
        if($this->auto_render === TRUE){
            $this->breadcrumbs->add('Открыти', Route::get('cards_main')->uri());
        }
    }

    /**
     * Главная страница открыток и категории
     * @throws Kohana_Exception
     */
    public function  action_index(){
        $alias = Request::current()->param('alias');
        $cards = ORM::factory('Card');
        $categories = ORM::factory('CardCategory')->cached(Model_CardCategory::CATEGORY_CACHE_TIME)->find_all();
        if(!is_null($alias)){
            $category = ORM::factory('CardCategory')->where('alias', '=', $alias)->find();
            if($category->loaded())
                $cards->where('category_id', '=', $category->id);
        }
        $count = clone ($cards);
        $count = $count->count_all();
        $pagination = Pagination::factory(array(
            'total_items' => $count,
            'group' => 'cards',
        ))->route_params(array(
            'controller' => Request::current()->controller(),
            'alias' => $alias,
        ));
        $cards = $cards->offset($pagination->offset)->limit($pagination->items_per_page)->find_all();
        $this->template->content->set(array(
            'alias' => $alias,
            'cards' => $cards,
            'pagination' => $pagination,
            'categories' => $categories,
            'counts' => Model_CardCategory::getCounts(),
        ));
    }

    /**
     * Страница с открыткой и формой отправки
     * @throws HTTP_Exception_404
     */
    public function  action_card(){
        $id = Request::current()->param('id');
        $card = ORM::factory('Card', $id);
        if(!$id || !$card->loaded())
            throw new HTTP_Exception_404;

        if(Request::current()->method() == Request::POST){
            $validation = Validation::factory($_POST)
                ->rules('user_from', array(
                    array('not_empty'),
                ))
                ->rules('email_from', array(
                    array('not_empty'),
                    array('email', array(':value')),
                ))
                ->rules('user_to', array(
                    array('not_empty'),
                ))
                ->rules('email_to', array(
                    array('not_empty'),
                    array('email', array(':value')),
                ))
                ->rules('captcha', array(
                    array('not_empty'),
                    array('Captcha::checkCaptcha', array(':value', ':validation', ':field'))
                ))
                ->labels(array(
                    'user_from' => 'Имя отправителя',
                    'email_from' => 'E-mail отправителя',
                    'user_to' => 'Имя получателя',
                    'email_to' => 'E-mail получателя',
                    'captcha' => __('Enter captcha code'),
                ));
            if(!$validation->check()) {
                $this->template->content->set('errors', $validation->errors('messages/validation'));
            }
            else{
                $key = md5(time() . $_POST['user_to']);
                $card_message = ORM::factory('CardMessage');
                $card_message->values(array(
                    'user_id' => Auth::instance()->logged_in('login') ? $this->current_user->id : NULL,
                    'user_from' => $_POST['user_from'],
                    'email_from' => $_POST['email_from'],
                    'user_to' => $_POST['user_to'],
                    'email_to' => $_POST['email_to'],
                    'message' => $_POST['message'],
                    'key' => $key,
                    'card_id' => $id,
                    'time' => time(),
                    'sended' => 1,
                ));
                try{
                    $card_message->save();
                    Email::instance()
                        ->to(Arr::get($_POST, 'email_to'))
                        ->from(KoMS::config()->robot_email)
                        ->subject(KoMS::config()->project['name'].': Вам отправили открытку')
                        ->message(View::factory('cards/card_letter', array(
                            'data' => Arr::extract($_POST, array('user_from', 'user_to', 'email_from', 'email_to')),
                            'text'=> strip_tags(Arr::get($_POST, 'text')),
                            'site_name'=> KoMS::config()->project['name'],
                            'card_url'=> 'http://'.$_SERVER['HTTP_HOST'].Kohana::$base_url.Route::get('card_receive')->uri(array('key'=>$key)),
                        ))->render()
                            , true)
                        ->send();
                    $this->redirect('cards/sended');
                    return;
                }
                catch(ORM_Validation_Exception $e){
                    $this->template->content->set('errors', $e->errors('messages/validation'));
                }
            }
        }
        elseif(Auth::instance()->logged_in('login')){
            $_POST['user_from'] = $this->current_user->profile->name;
            $_POST['email_from'] = $this->current_user->email;
        }

        $other_cards = ORM::factory('Card')->where('category_id','=',$card->category_id)->limit(10)->order_by(DB::expr('rand()'))->find_all();

        $this->styles[] = "media/libs/pure-release-0.6.0/forms-min.css";
        $this->template->content->set(array(
            'card' => $card,
            'category' => $card->category,
            'other_cards' => $other_cards,
        ));
    }

    /**
     * Страница с сообщением об успешной отправке открытки
     */
    public function  action_sended(){
//        $this->template->content->set(array());
    }

    /**
     * Страница получения открытки
     */
    public function  action_receive(){
        $key = Request::current()->param('key');
        $message = ORM::factory('CardMessage')->where('key', '=', $key)->find();
        if(!$key || !$message->loaded())
            throw new HTTP_Exception_404;
        $message->set('received', 1)->update();
        $this->template->content->set(array(
            'card' => $message->card,
            'message' => $message,
        ));
    }
}
