# MoyBooru
一个PHP的画板程序，基于Gelbooru 0.1.11。

分享，评价，享受。

(It won't support English in the near future.)

# 功能
1、[TODO]自由地分享图片与视频。

2、对他人的帖子发表评论与打分。

3、内含一个简单的论坛。

4、[TODO]内含一个Wiki程序。

5、[TODO]支持照片集合。

6、[TODO]多语言支持。（目前仅中文化）

【有待添加】

# 安装
1、在config.php中设置好MySQL数据库信息。将所有文件放至网站根目录。

2、将以下目录设置为可写：

images, tmp, thumbnails, cache

3、确保PHP配置正确，以下以Windows环境为例，Linux请确认对应设置或模块正确配置。

 - extension=php_mbstring.dll
 
 - extension=php_gd2.dll
 
 - extension=php_mysql.dll
 
 - extension=php_mysqli.dll
 
 - gd.jpeg_ignore_warning = 1

4、浏览器访问/install/目录，输入管理员信息安装站点。安装后删除install目录。

5、booru.xml应当被重命名为站点名称，并请编辑其中内容以适合你的站点。同时需要编辑Header.php中的内容（includes目录下）。

6、后台管理地址/admin/。根目录的config.php中有更多设置。

7、如果无法正常搜索3个字符以下的标签，请在MySQL的配置文件（Windows中为my.ini，Linux中为my.cnf）的[mysqld]字段中加入以下内容以修改全文索引限制：

	 - ft_min_word_len = 1
	 
	 - ft_stopword_file =

# 缘由
很久以前我就想要一个画板程序。（不要问为什么>//<）

试过Danbooru，无论x86还是树莓派，无论VPS还是实体机，都跪了，装不上啊。

试过Gelbooru，但0.1.11比较简陋。它的0.2.x（当前版本）很不错，但是是闭源的。

看过其他的，感觉好丑，不喜欢。

所以我就决定自己弄一个了啊……Gelbooru 0.1.11是开源的，虽然比较不完善，但是感觉是一个好的模板。

# 但是……
作为一名天朝高中生，你懂我的苦逼。没时间啊，所以更新会很慢吧……

而且编程技术还是挺丑的……不然也不需要模板了。
