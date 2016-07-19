<?php defined('SYSPATH') or die('No direct script access.');?>
<html>
<head>
    <title></title>
</head>
<body>
<b>Здравствуйте,  <?php echo $data['user_to'] ?>!</b><br />
<br />
Вам отправили открытку из сервиса открыток <?php echo $site_name?>.<br />
==========================================<br />
<b>Отправитель: </b><?php echo $data['user_from']?></a><br />
<b>Контактный e-mail: </b><a href="mailto:<?php echo $data['email_from']?>"><?php echo $data['email_from']?></a><br />
<br />
Просмотреть открытку и текст поздравления можно здесь - <a href="<?php echo $card_url?>">Октрытки на <?php echo $site_name?></a>
==========================================<br />
С уважением,<br />
Администрация сайта <?php echo $site_name ?>
</body>
</html>