<?php
require_once 'autoload.php';

$Auth = new Auth();
$Auth->user = 'your_email@yandex.ru';
$Auth->pass = '123412341';
$Auth->server = array('inbox' => '{imap.yandex.ru:993/imap/ssl}INBOX');

$Example = new Example($Auth);
$unseen = $Example->getUnsen();
$inboxAll = $Example->getInboxAll();

var_dump($unseen);
var_dump($inboxAll);
