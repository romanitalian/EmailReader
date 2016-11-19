# EmailReader

```php
<?php
require_once 'autoload.php';

$Auth = new Auth();
$Auth->user = 'your_email@yandex.ru';
$Auth->pass = '123412341';
$Auth->server = array('inbox' => '{imap.yandex.ru:993/imap/ssl}INBOX');

// Example as your custom wrapper:
$Example = new Example($Auth);
$unseen['Using Example'] = $Example->getUnsen();
$inboxAll['Using Example'] = $Example->getInboxAll();

// or use this way:
$unseen['Using native Reader'] = Email\Reader::getInstance()->setAuth($Auth)->loadAndParseInbox()->content;
$inboxAll['Using native Reader'] = Email\Reader::getInstance()->setAuth($Auth)->loadAndParseInboxAll()->content;

var_dump($unseen);
var_dump($inboxAll);

```

