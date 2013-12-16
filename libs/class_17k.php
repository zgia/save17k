<?php

/**
 * 保存17K网站到文本文件
 *
 * @author zGia!
 */
class YiQiKan
{

	private $baseHref = 'http://www.17k.com';

	/**
	 * 保存APK到文本，默认保存到APK文件所在目录
	 *
	 * @todo 直接处理APK
	 *
	 * @param string 需要的文件所在目录
	 * @param string 待处理文件的索引号
	 *
	 * @return boolean
	 */
	function save17kAPK2Txt($dir, $index)
	{
		$txtFile = $dir . $index . '.txt';
		if (!save2Txt($txtFile))
		{
			return false;
		}
		if (empty($index))
		{
			return false;
		}

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

	/**
	 * 保存17K小说公众章节到文本
	 *
	 * @param string	文本文件路径
	 * @param integer	小说书号
	 * @return boolean
	 */
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

		$html = file_get_html($this->baseHref . '/list/' . $index . '.html');

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
				echo "\tGet " . $this->baseHref . $article->href . "\n";
				$articleHtml = file_get_html($this->baseHref . $article->href);
				$chapterContent = preg_replace('#<!-- 作者有话说 -->.*#', '', $articleHtml->find('#chapterContent', 0)->innertext);
				$content = str_replace('<br>', "\n", trim($chapterContent));

				save2Txt($file, $content . "\n\n");
			}
		}

		return true;
	}

	/**
	 * 保存内容到文件中
	 *
	 * @param string $path
	 * @param string $cotent
	 * @return boolean
	 */
	public function save2Txt($path, $cotent = '')
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

}
