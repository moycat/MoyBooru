<?php
	$mysql_host = "127.0.0.1";
	$mysql_user = "moybooru";
	$mysql_pass = "moybooru";
	$mysql_db = "moybooru";
	
//【站点基本设置】
	//站点基本地址（不要以斜线结尾，可不修改）
	$site_url = "";
	//缩略图目录的URL（以斜线开头，不要以斜线结尾，可不修改）
	$thumbnail_url = "/thumbnails";
	//站点名，将会在头部显示
	$site_url3 = "Moyyyyyy Booru";
	//图片文件夹的名称
	$image_folder = "images";
	//视频文件夹的名称
	$vedio_folder = "vedios";
	//缩略图的尺寸，与Danbooru中相同
	$dimension = 150;
	//缩略图文件的的名称
	$thumbnail_folder = "thumbnails";
	
//【数据中的表名称设置】
	//用户表
	$user_table = "users";
	//帖子表
	$post_table = "posts";
	//标签索引表
	$tag_index_table = "tag_index";
	//文件夹索引表
	$folder_index_table = "folder_index";
	//收藏夹表
	$favorites_table = "favorites";
	//注释表
	$note_table = "notes";
	//历史注释表
	$note_history_table = "notes_history";
	//评论表
	$comment_table = "comments";
	//评论投票表
	$comment_vote_table = "comment_votes";
	//帖子投票表
	$post_vote_table = "post_votes";
	//群组表
	$group_table = "groups";
	//历史标签表
	$tag_history_table = "tag_history";
	//评论计数表
	$comment_count_table = "comment_count";
	//帖子计数的缓存表，每日更新（站点优化项目之一）
	$post_count_table = "post_count";
	//点击计数表
	$hit_counter_table = "hit_counter";
	//收藏计数表
	$favorites_count_table = "favorites_count";
	//标签修正表
	$alias_table = "alias";
	//主从帖子关系表
	$parent_child_table = "parent_child";
	//论坛主题索引表
	$forum_topic_table = "forum_topics";
	//论坛帖子表
	$forum_post_table = "forum_posts";
	//删除帖子表
	$deleted_image_table = "delete_images";
	//封禁IP表
	$banned_ip_table = "banned_ip";
	//图像的域名 例如：http://img1.booru.neko/, http://img2.booru.neko/folder/folder/
	$domains = array(''.$site_url.'');
	
//【通用设置】
	
	//允许上传的图片最大宽度 (0为无限制)
	$max_upload_width = 0;
	//允许上传的图片最大高度 (0为无限制)
	$max_upload_height = 0;
	//允许上传的图片最小宽度 (0为无限制)
	$min_upload_width = 150;
	//允许上传的图片最小高度 (0为无限制)
	$min_upload_height = 150;
	
	//开启注册？
	$registration_allowed = true;

	//邮件设置
	$site_email = "noemail@example.com";
	$email_recovery_subject = "找回你在 ".$site_url3." 上的密码";
	
	//允许匿名用户提交帖子报告？
	$anon_report = false;
	//允许匿名用户编辑自己发表的帖子？
	$anon_edit = true;
	//允许匿名用户评论？
	$anon_comment = true;
	//允许匿名用户投票？
	$anon_vote = false;
	//允许匿名用户发帖？
	$anon_can_upload = false;
	//发表后重新编辑限时（分钟）
	$edit_limit = 20;
	//缓存目录 所有的缓存文件都将储存在其子目录中，请将其设置在RAM或快速Raid磁盘上。默认未开启。
	$main_cache_dir = "NUL:\\";
?>