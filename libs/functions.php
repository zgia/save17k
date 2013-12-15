<?php
/**
 * 保存内容到文件中
 * 
 * @param string $path
 * @param string $cotent
 * @return boolean
 */
function save2Txt($path, $cotent = '')
{
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
