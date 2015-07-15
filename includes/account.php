<?php 
	echo '<div id="content"><div id="user-index">';
	$user = new user(); 
	if($user->check_log())
	{
		echo '<h4><a href="index.php?page=login&amp;code=01">&raquo; 注销</a></h4>
		<p>点击此处退出你的账户。</p>
		<h4><a href="index.php?page=account_profile&id='.$checked_user_id.'">&raquo; 个人文档</a></h4>
		<p>在这里查看你的个人信息。</p>
		<h4><a href="index.php?page=favorites&amp;s=view&amp;id='.$_COOKIE['user_id'].'">&raquo; 我的收藏</a></h4>
		<p>查看或编辑你的所有收藏。</p>';		
	}
	else
	{
		print '<h2>你尚未登录</h2><h4><a href="index.php?page=login&amp;code=00">&raquo; 登录</a></h4><p>如果你已经注册过一个账户，你可以在此处登录。如果你的浏览器启用了cookies，你将在之后自动登录。</p>';
		if($registration_allowed == true)
			echo '<h4><a href="index.php?page=reg">&raquo; 注册</a></h4><p> '.$site_url3.' 上90%的功能不需要注册账户，但是注册后会解锁更多额外功能（如收藏等）。注册本站不需要提供电子邮件地址。</p>';
		else
			echo '<p><b>注册功能已关闭</b></p>';
	}
?>
<h4><a href="index.php?page=favorites&amp;s=list">&raquo; 收藏纵览</a></h4>
<p>查看所有人收藏的帖子</p>
<h4><a href="index.php?page=account-options">&raquo; 选项</a></h4>
<p>设置账户选项</p>
</div></div></body></html>