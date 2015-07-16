<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
<?php
	echo '<title>'.$site_url3.'</title>
	<link rel="stylesheet" type="text/css" media="screen" href="'.$site_url.'/default.css?2" title="default" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
	<div id="static-index">
		<h1 style="font-size: 52px; margin-top: 1em;"><a href="'.$site_url.'/">'.$site_url3.'</a></h1>
	';
?>
	<div class="space" id="links">
		<a href="index.php?page=post&amp;s=list" title="分页显示所有帖子">帖子</a>
		<a href="index.php?page=comment&amp;s=list">评论</a>
		<a href="index.php?page=reg">注册</a>
		<a href="index.php?page=favorites&amp;s=list">收藏</a>
	</div>
	<div class="space">
		<form action="index.php?page=search" method="post">
			<input id="tags" name="tags" size="30" type="text" value="" /><br/>
			<input name="searchDefault" type="submit" value="搜索" />
		</form>
	</div>
	<div style="font-size: 80%; margin-bottom: 2em;">
		<p>
<?php
	$query = "UPDATE $hit_counter_table SET count=count+1";
	$db->query($query);
	$query = "SELECT t1.pcount, t2.count FROM $post_count_table AS t1 JOIN $hit_counter_table as t2 WHERE t1.access_key='posts'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	echo '已储存 '.number_format($row['pcount']).' 篇帖子  -  由 <a href="https://github.com/moycat/MoyBooru">MoyBooru</a> Beta 0.5 提供支持
	</p><br />';
	for ($i=0;$i<strlen($row['pcount']);$i++) 
	{
		$digit=substr($row['pcount'],$i,1);
		print '<img src="./images/counter/'.$digit.'.gif" border="0" alt="'.$digit.'"/>'; 						
	}
	echo '<br /><br /><small>总计访客数：'.number_format($row['count']).'</small>
	<br /><br /></div></div><br /><br /><br /><br />
	</body></html>';
?>