<?php

save17kAPK2Txt('/path/to/apk/assets/content/', '1234567890');

function save17kAPK2Txt($dir, $index)
{
    $txtFile = $dir . $index . '.txt';
    $indexFile = $dir . $index . '.in';
    $indexContent = json_decode(file_get_contents($indexFile));

    foreach ($indexContent->volumeList as $chapterList)
    {
        // 章节
        echo $chapterList->name . "\n\n";
        save2Txt($txtFile, $chapterList->name . "\n\n\n\n");
        foreach ($chapterList->chapterList as $chapter)
        {
            // 正文标题
            echo $chapter->name . "\n";
            save2Txt($txtFile, $chapter->name . "\n\n");
            // 正文内容
            save2Txt($txtFile, file_get_contents($dir . $chapterList->id . '\\' . $chapter->id . '.t'));
            save2Txt($txtFile, "\n\n");
        }
        save2Txt($txtFile, "\n\n");
    }
}

function save2Txt($path, $cotent = '')
{
    if (empty($cotent))
    {
        return false;
    }

    if ($handle = fopen($path, 'a+'))
    {
        flock($handle, LOCK_EX);
        $rs = fputs($handle, $cotent);
        flock($handle, LOCK_UN);
        fclose($handle);
        if ($rs !== false)
        {
            return true;
        }
    }
    return false;
}
