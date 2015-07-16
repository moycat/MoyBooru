<?php
	if(!defined('_IN_ADMIN_HEADER_'))
		die;
		
	set_time_limit(0);
	$user = new user();
	if(!$user->gotpermission('is_admin'))
	{
		print "无权访问此页";
		exit;
	}	
	if(isset($_GET['user_id']) && is_numeric($_GET['user_id']))
	{
		$ban_id = $db->real_escape_string($_GET['user_id']);
		$query = "SELECT id, user, ip FROM $user_table WHERE id = '$ban_id' LIMIT 1";
		$result = $db->query($query);
		$row = $result->fetch_assoc();		
		if(!isset($_POST['ban_reason']))
		{
			//Are you an idiot who decided to ban themselves? Let's hope not... ;)
			if(mb_strtolower($row['user']) == "anonymous" || mb_strtolower($row['user']) == mb_strtolower($checked_username))
			{
				print "相信我，你<b>绝壁</b>不会想这样做的……";
				exit;
			}
			print '<div class="content">注意，使用此工具封禁用户将会在整个数据库中搜寻与之相关联的IP地址。这可能会耗费一定时间，不过就算要等到天荒地老，还请坐和放宽<br /><br />
			<form method="post" action="">
			<table><tr><td>			
			用户</td><td><input type="text" value="'.$row['user'].'" size="80" disabled /></td></tr>
			<tr><td>
			理由</td><td><input type="text" name="ban_reason" value="" size="80" /></td></tr>
			<tr><td></td><td>
			<input type="submit" value="封禁" /></td><tr></table>
			</form>
			</div></body></html>
			';
			exit;
		}
		$ban_reason = $db->real_escape_string($_POST['ban_reason']);
		//Let's grab the database values of all three since they are already there.
		$ban_id = $db->real_escape_string($row['id']);
		$ban_username = $db->real_escape_string($row['user']);
		$ban_ip = $db->real_escape_string($row['ip']);

		//These queries could be done with a single join, but why bother making it complicated? 
		//Multiple simple queries shouldn't be that bad on the server... Right?
		print "正在用户表中封禁IP……<br />";
		flush();
		$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
		$db->query($query);
		
		print "正在评论投票表中封禁IP……<br />";
		flush();
		$query = "SELECT * FROM $comment_vote_table WHERE user_id = '$ban_id' GROUP BY ip";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			$ban_ip = $db->real_escape_string($row['ip']);
			$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
			$db->query($query);
		}
		
		print "正在评论表中封禁IP……<br />";	
		flush();		
		$query = "SELECT * FROM $comment_table WHERE user = '$ban_username' GROUP BY ip";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			$ban_ip = $db->real_escape_string($row['ip']);
			$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
			$db->query($query);
		}	
		
		print "正在注释表中封禁IP……<br />";
		flush();		
		$query = "SELECT * FROM $note_table WHERE user_id = '$ban_id' GROUP BY ip";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			$ban_ip = $db->real_escape_string($row['ip']);
			$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
			$db->query($query);
		}
		
		print "正在帖子投票表中封禁IP……<br />";
		flush();		
		$query = "SELECT * FROM $post_vote_table WHERE user_id = '$ban_id' GROUP BY ip";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			$ban_ip = $db->real_escape_string($row['ip']);
			$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
			$db->query($query);
		}		
		
		print "正在历史记录表中封禁IP……<br />";
		flush();		
		$query = "SELECT * FROM $tag_history_table WHERE user_id = '$ban_id' GROUP BY ip";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			$ban_ip = $db->real_escape_string($row['ip']);
			$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
			$db->query($query);
		}	
		
		print "正在帖子表中封禁IP……<br />";		
		flush();
		$query = "SELECT * FROM $post_table WHERE owner = '$ban_username' ORDER BY id DESC";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			$ban_ip = $db->real_escape_string($row['ip']);
			$query = "INSERT INTO $banned_ip_table(ip,user,reason,date_added) VALUES('$ban_ip','$checked_username','$ban_reason','".time()."')";
			$db->query($query);
		}			
	}
	else
		header('Location:../');
?>