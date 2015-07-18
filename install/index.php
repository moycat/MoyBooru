<title>MoyBooru安装程序</title>

<?php
	require "../includes/function/confedit.php";
	if(isset($_POST['settings']))
	{
		require "../config.php";
		$db_host = $_POST['db_host'];
		$db_base = $_POST['db_base'];
		$db_user = $_POST['db_user'];
		$db_pw = $_POST['db_pw'];
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
			print "<br />安装顺利结束。现在你可以用你设定的账号密码登入网站了。";
			update_config("../config.php", "mysql_host", $db_host);
			update_config("../config.php", "mysql_user", $db_base);
			update_config("../config.php", "mysql_pass", $db_user);
			update_config("../config.php", "mysql_db", $db_pw);
		}
		else
			print "你已经在这个数据库中安装了MoyBooru，将不会创造新用户。<br /><br />";
		exit();
	}
?>

<h1>MoyBooru安装程序</h1>
<form method="post" action="index.php">
<table>
<tr><td>数据库地址<br />
<input type="text" name="db_host" id="db_host" value="127.0.0.1" />
</td></tr>
<tr><td>数据库名<br />
<input type="text" name="db_base" id="db_base" value="moybooru" />
</td></tr>
<tr><td>数据库用户名<br />
<input type="text" name="db_user" id="db_user" value="moybooru" />
</td></tr>
<tr><td>数据库密码<br />
<input type="text" name="db_pw" id="db_pw" value="moybooru" />
</td></tr>
<tr><td>
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