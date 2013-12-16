<?php

error_reporting(E_ALL);

include('libs/simple_html_dom.php');
include('libs/class_17k.php');

$YIQIKAN = new YiQiKan();

$index = '117302';
$book = 'c:/book.txt';

$YIQIKAN->save17kBook2Txt($book, $index);
