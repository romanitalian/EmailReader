<?php
require_once 'autoload.php';

$Auth = new Auth();
$Auth->user = 'test@yandex.ru';
$Auth->pass = '123456';
$Auth->server = array('inbox' => '{imap.yandex.ru:993/imap/ssl}INBOX');

$Example = new Example($Auth);
$unseen = $Example->getUnsen();
$inboxAll = $Example->getInboxAll();

var_dump($unseen);
var_dump($inboxAll);
