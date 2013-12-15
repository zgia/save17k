<?php

error_reporting(E_ALL);

include('libs/simple_html_dom.php');
include('libs/functions.php');

$index = '117302';
$book = 'c:/book.txt';

save17kBook2Txt($book, $index);

function save17kBook2Txt($book, $index)
{
    if (!save2Txt($book))
    {
        return false;
    }

    $index = (int) $index;
    if (empty($index))
    {
        return false;
    }

    $basehref = 'http://www.17k.com';

    $html = file_get_html($basehref . '/list/' . $index . '.html');

    $chapterTitle = array();
    foreach ($html->find('div.directory_con div.tit h2') as $h2)
    {
        $chapterTitle[] = trim($h2->plaintext);
    }

    $article = array();
    $i = 0;
    foreach ($html->find('div.directory_con div.con') as $ch)
    {
        $title = $chapterTitle[$i++];
        echo "Get " . $title . "\n";
        save2Txt($file, $title . "\n\n\n");

        foreach ($ch->find('ul li a') as $article)
        {
            echo "\tGet " . trim($article->plaintext) . "\n";
            save2Txt($file, trim($article->plaintext) . "\n\n");

            //http://www.17k.com/chapter/117302/4091109.html
            echo "\tGet " . $basehref . $article->href . "\n";
            $articleHtml = file_get_html($basehref . $article->href);
            $chapterContent = preg_replace('#<!-- 作者有话说 -->.*#', '', $articleHtml->find('#chapterContent', 0)->innertext);
            $content = str_replace('<br>', "\n", trim($chapterContent));

            save2Txt($file, $content . "\n\n");
        }
    }

    return true;
}
