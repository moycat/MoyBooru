<?php
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	<title>'.$site_url3.'';
	if(isset($lozerisdumb))
		print " ".$lozerisdumb;
	echo '</title>
		<link rel="stylesheet" type="text/css" media="screen" href="'.$site_url.'/default.css?2" title="default" />
		<link rel="search" type="application/opensearchdescription+xml" title="'.$site_url3.'" href="'.$site_url.'/default.xml" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="一个可匿名的图片/视频分享站点。" />
		<link href="/import/video-js/video-js.css" rel="stylesheet" type="text/css">
		<script src="/import/video-js/video.js"></script>
		<script>
		videojs.options.flash.swf = "/import/video-js/video-js.swf";
		</script>
		<script src="/import/video-js/lang/zh-CN.js"></script>
		<script src="'.$site_url.'/script/prototype.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/global.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/scriptaculous.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/builder.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/effects.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/dragdrop.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/controls.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/slider.js?2" type="text/javascript"></script>
		<script src="'.$site_url.'/script/notes.js?2" type="text/javascript"></script>
		<!--[if lt IE 7]>
			<script defer type="text/javascript" src="'.$site_url.'/script/pngfix.js?2"></script>
		<![endif]-->
	</head>
<body>
	<div id="header">
		<h2><a href="'.$site_url.'/index.php">'.$site_url3.'</a></h2>
				<ul class="flat-list" id="navbar">

			<li><a href="'.$site_url.'/index.php?page=account">我的账户</a></li>
			<li><a href="'.$site_url.'/index.php?page=post&amp;s=list&amp;tags=all">帖子</a></li>
			<li><a href="'.$site_url.'/index.php?page=comment&amp;s=list">评论</a></li>
			<li><a href="'.$site_url.'/index.php?page=alias&amp;s=list">标签修正</a></li>
			<li><a href="'.$site_url.'/index.php?page=forum&amp;s=list">论坛</a></li>
			<li><a href="'.$site_url.'/index.php?page=post&amp;s=random">随机</a></li>
			<li><a href="'.$site_url.'/help/index.php">帮助</a></li>
';
?><li id="notice"></li></ul></div><div id="long-notice"></div>