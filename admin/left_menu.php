<?php
echo '<html><head>
<link rel="stylesheet" type="text/css" media="screen" href="'.$site_url.'/default.css" title="default" />
<title></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body>
	<div id="header">
		<h2 id="site-title"><a href="'.$site_url.'/admin/">后台管理</a> / <a href="'.$site_url.'/index.php?page=post&s=list"><i>访问网站</i></a></h2><span style="color: #999999; padding-left: 20px;">鼠标悬停在链接上可获取更多信息</span><br><br><br>
</div>
		<div id="content">
		<div id="post-list">
		<div class="sidebar">

		<h5>日常管理</h5><br />
		<ul id="tag-sidebar">
		<li><a href="?page=reported_posts" title="查看用户报告的帖子">帖子报告</a></li>
		<li><a href="?page=reported_comments" title="查看用户报告的评论与其相关信息">评论报告</a></li>
		<li><a href="?page=alias" title="审核用户提交的标签修正请求">标签修正请求</a></li>
		</ul>
		<br />';

if($user->gotpermission('is_admin'))
{
	echo '<h5>管理工具</h5>
	<ul id="tag-sidebar">
	<li><a href="?page=mass_parent" title="批量修改一些帖子的父帖子">父帖子批量修改</a></li>
	</ul>
	<h5>用户组工具</h5>
	<ul id="tag-sidebar">
	<li><a href="?page=add_group" title="新增一个群组">创造新群组</a></li>
	<li><a href="?page=edit_group" title="标记群组的权限">群组权限设置</a></li>
	</ul>';
}
?>
</div></div>