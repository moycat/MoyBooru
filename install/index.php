<?php
	if(isset($_POST['settings']))
	{
		require "create_db.php";
		$user = $db->real_escape_string($_POST['user']);
		$pass = $db->real_escape_string($_POST['pass']);
		$email = $db->real_escape_string($_POST['email']);
		$pass = sha1(md5($pass));
		$query = "SELECT * FROM $user_table";
		$result = $db->query($query);
		if($result->num_rows == "0")
		{
			$query = "INSERT INTO $user_table(user,pass,ugroup,email,signup_date) VALUES('$user','$pass','1','$email',NOW())";
			$db->query($query) or die($db->error);
		}
		else
			print "你已经在这个数据库中安装了MoyBooru，安装程序将不会继续进行。<br /><br />";
		print "<br />安装顺利结束。现在你可以用你设定的账号密码登入网站了。";
		exit();
	}
?>
<h1>MoyBooru安装程序</h1>
<form method="post" action="index.php">
<table><tr><td>
账号（将被设置成为管理员）<br />
<input type="text" name="user" value=""/>
</td></tr>
<tr><td>
密码<br />
<input type="text" name="pass" value=""/>
</td></tr>
<tr>
  <td>
E-mail<br />
<input type="text" name="email" value=""/>
</td></tr>
<tr><td>
<input type="hidden" name="settings" value="1"/>
</td></tr>
<tr><td>
<input type="submit" name="submit" value="安装"/>
</td></tr></table></form>