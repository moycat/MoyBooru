<?php
	$user = new user();
	if($_GET['code'] == "00")
	{
		if($user->check_log())
		{
			header("Location:index.php?page=account");
			exit;
		}
		if(isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "")
		{
			$username = $db->real_escape_string(htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8'));
			$password = $db->real_escape_string($_POST['pass']);
			if(!$user->login($username, $password))
				header("Location:index.php?page=login&code=00");
			else
				header("Location:index.php?page=account");
			exit;
		}
		header("Cache-Control: store, cache");
		header("Pragma: cache");
		require "includes/header.php";
		echo '<form method="post" action="">
		<table><tr><td>
		用户名<br />
		<input type="text" name="user" value="" />
		</td></tr>
		<tr><td>
		密码<br />
		<input type="password" name="pass" value="" />
		</td></tr>
		<tr><td>
		<input type="submit" name="submit" value="登录" />
		</td></tr>
		<tr><td>
		<a href="index.php?page=reset_password">忘记密码？</a>
		</td></tr></table></form>';
	}
	if($_GET['code'] == "01")
		$user->logout();
?></div></body></html>