2个小功能
==============

一、将17k下载的apk中的文章保存到一个txt中

1、下载apk；  
2、改扩展名为zip，解压；  
3、进入`assets`目录，解压文件夹内的`content.zip`，解压后的`content`目录下有个“`xxxxxx.in`”文件；  
4、假设`content`目录路径为：`C:\single_117302_chineseall_v1.0_release.zip\assets\content\`；  
5、17k-apk.php，第三行；  
6、将“`/path/to/apk/assets/content/`”，改成上面那个目录；  
* 注1：如果目录中含“\”，则将其替换为“\\”  
* 注2：如果目录最后不是“\\”或者“/”，请加上  

7、将“`1234567890`”改成“`xxxxxx.in`”文件名中的“`xxxxx`”，注意不要带“`.in`”；  
8、更改后的第三行：  
* `save17kAPK2Txt('C:\\single_117302_chineseall_v1.0_release.zip\\assets\\content\\', '117302');`  

9、运行后，生成的txt文件会保存在`content`目录下。  


二、将17k下载的文章保存到一个txt中
1、更改17k-book.php，将第8行的$index改成小说的ID；  
2、运行此文件。  