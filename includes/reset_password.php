<?php
	session_start();
	$user = new user();
	if($user->check_log())
		header("Location: index.php?page=account");
	else
	{
		header("Cache-Control: store, cache");
		header("Pragma: cache");
		require "includes/header.php";	
	}
	if(isset($_POST['username']) && $_POST['username'] != "")
	{
		$user = $db->real_escape_string(htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'));
		$query = "SELECT email, id FROM $user_table WHERE user='$user' LIMIT 1";
		$result = $db->query($query);
		$count = $result->num_rows();
		if($count > 0)
		{	
			$row = $result->fetch_assoc();
			if($row['email'] != "" && $row['email'] != NULL && strpos($row['email'],"@") !== false && strpos($row['email'],".") !== false && strlen($row['email']) > 2)
			{		
				$misc = new misc();
				$code = hash('sha256',rand(132,1004958327747882664857));
				$link = $site_url."/index.php?page=reset_password&code=".$code."&id=".$row['id'];
				$body = '你的账户正在申请找回密码。<br /><br /> 如果你没有申请，请忽略这封邮件。<br /><br />为了重置你的密码，请点击下面的链接： <a href="'.$link.'">'.$link.'</a>';
				$misc->send_mail($row['email'],$email_recovery_subject,$body);
				$query = "UPDATE $user_table SET mail_reset_code='$code' WHERE id='".$row['id']."'";				
				$db->query($query);				
				print "一封带有重置密码链接的邮件已经发至你的邮箱。<br />";
			}
			else
				print "你的账户没有设置邮箱。<br />";
		}
		else
			print "你的账户没有设置邮箱。<br />";
	}
	if(isset($_GET['code']) && $_GET['code'] != "" && isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']))
	{
		$id = $db->real_escape_string($_GET['id']);
		$code = $db->real_escape_string($_GET['code']);
		$query = "SELECT id FROM $user_table WHERE id='$id' AND mail_reset_code='$code' LIMIT 1";
		$result = $db->query($query) or die($db->error);
		if($result->num_rows() > 0)
		{
			$_SESSION['reset_code'] = $code;
			$_SESSION['tmp_id'] = $id;
			echo '<form method="post" action="index.php?page=reset_password">
			<table><tr><td>
			输入你的新密码
			<input type="password" name="new_password" value="" />
			</td></tr>
			<tr><td>
			<input type="submit" name="submit" value="提交" />
			</td></tr>
			</table>				
			</form>';
		}
		else
		{
			print "无效的密码重置链接。<br />";
		}
	}
	if(isset($_POST['new_password']) && $_POST['new_password'] != "" && isset($_SESSION['tmp_id']) && $_SESSION['tmp_id'] != "" && is_numeric($_SESSION['tmp_id']) && isset($_SESSION['reset_code']) && $_SESSION['reset_code'] != "")
	{
		$code = $db->real_escape_string($_SESSION['reset_code']);
		$id = $db->real_escape_string($_SESSION['tmp_id']);
		$pass = $db->real_escape_string($_POST['new_password']);		
		$user = new user();
		$query = "SELECT id FROM $user_table WHERE id='$id' AND mail_reset_code='$code'";
		$result = $db->query($query) or die($db->error);
		if($result->num_rows() > 0)
		{
			$user->update_password($id,$pass);
			$query = "UPDATE $user_table SET mail_reset_code='' WHERE id='$id' AND mail_reset_code='$code'";
			$db->query($query);
			unset($_SESSION['tmp_id']);
			unset($_SESSION['reset_code']);
			print "你的密码已修改。<br />";
		}	
	}
	if(!isset($_GET['code']) && $_GET['code'] == "")
	{	
		echo'<form method="post" action="index.php?page=reset_password">
		<table><tr><td>
		用户名 
		<input type="text" name="username" value="" />
		</td></tr>
		<tr><td>
		<input type="submit" name="submit" value="提交" />
		</td></tr>
		</table></form>';
	}
?>