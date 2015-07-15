<?php
	if($registration_allowed != true)
		die("<br /><b>注册功能已关闭</b>");
	$user = new user();
	$ip = $db->real_escape_string($_SERVER['REMOTE_ADDR']);	
	if($user->banned_ip($ip))
	{
		print "执行失败：".$row['reason'];
		exit;
	}	
	if($user->check_log())
	{
		header("Location:index.php?page=account");
		exit;
	}
	if(isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "" && isset($_POST['conf_pass']) && $_POST['conf_pass'] != "")
	{
		$misc = new misc();
		$username = $db->real_escape_string(str_replace(" ",'_',htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8')));
		$password = $db->real_escape_string($_POST['pass']);
		$conf_password = $db->real_escape_string($_POST['conf_pass']);
		$email = $db->real_escape_string($_POST['email']);
		if($password == $conf_password)
		{
			$user = new user();
			if(!$user->signup($username,$password,$email))
			{
				require "includes/header.php";
				print "注册失败。可能的原因：数据库错误，用户名已存在，或你的用户名中有不允许的字符。请确认用户名不含制表符、空格、分号、逗号。也请确认用户名长度不小于3。<br />";
			}
			else
			{
				$user->login($username,$password);
				header("Location:index.php?page=account");
				exit;
			}
		}
		else
		{
			require "includes/header.php";
			print "密码不匹配。<br />";
		}
	}
	else
		require "includes/header.php";
?>
<form method="post" action="index.php?page=reg">
<table><tr><td>
用户名：<br />
<input type="text" name="user" value="" />
</td></tr>
<tr><td>
密码：<br />
<input type="password" name="pass" value="" />
</td></tr>
<tr><td>
确认密码：<br />
<input type="password" name="conf_pass" value="" />
</td></tr>
<tr><td>
E-mail（非必需，找回密码需要）：<br />
<input type="text" name="email" value="" />
</td></tr>
<tr><td>
<input type="submit" name="submit" value="注册" />
</td></tr>
</table>
</form></div></body></html>