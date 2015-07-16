<?php
	//Made to mass add parent to each post. Is this good enough?
	$user = new user();
	if(!$user->gotpermission('is_admin'))
	{
		header('Location:../');
		exit;
	}

	if(!isset($_POST['start']) && !isset($_POST['end']) && !isset($_POST['parent']))
	{
		print '输入ID范围来批量修改<br><Br>
		<form method="post" action="mass_parent.php">
		将这些帖子的父帖子设置为<br>
		<input type="text" name="parent">
		<Br><br>
		
		开始 #:<br>
		<input type="text" name="start">
		<br><br>
		
		结束 #:<br>
		<input type="text" name="end">
		<br><br>
		
		<input type="submit">
		</form>
		';
	}
	else
	{
		$cache = new cache();
		$start = $db->real_escape_string($_POST['start']);
		$end = $db->real_escape_string($_POST['end']);
		$parent_id = $db->real_escape_string($_POST['parent']);
		while($start<=$end)
		{
			$cache->destroy_page_cache("cache/".$start);
			$parent_check1 = "SELECT COUNT(*) FROM $post_table WHERE id='$parent_id'";
			$pres1 = $db->query($parent_check1);
			$prow1 = $pres1->fetch_assoc();
			if($prow1['COUNT(*)'] > 0)
			{
				$temp = "INSERT INTO $parent_child_table(parent,child) VALUES('$parent_id','$start')";
				$db->query($temp);
				$temp = "UPDATE $post_table SET parent='$parent_id' WHERE id='$start'";
				$db->query($temp);
			}
			$start++;
		}
	}
?>