<?php defined('SYSPATH') or die('No direct script access.');?>
<h1>Открытка отправлена</h1>

Ваша открытка была успешно отправлена!<br>
Получатель сможет просмотреть ее перейдя по ссылке, отправленой в письме.<br><br>
<?php echo HTML::anchor(Route::get('cards_main')->uri(), 'Вернуться к просмотру открыток')?>