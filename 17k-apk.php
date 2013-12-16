<?php

error_reporting(E_ALL);

include('libs/class_17k.php');
$YIQIKAN = new YiQiKan();

$book = '/path/to/apk/assets/content/';
$index = '1234567890';

$YIQIKAN->save17kAPK2Txt($book, $index);
