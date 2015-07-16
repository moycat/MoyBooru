<?php
	if(!defined('_IN_ADMIN_HEADER_'))
		die;
	$user = new user();
	if(!$user->gotpermission('is_admin'))
	{
		header('Location: ../');
		exit;
	}
	if(isset($_GET['delete']) && is_numeric($_GET['delete']))
	{
		$del_id = $db->real_escape_string($_GET['delete']);
		$query = "DELETE FROM $group_table WHERE id ='$del_id'";
		$db->query($query);
		
	}
	if(isset($_POST['check']) && $_POST['check'] == 1)
	{
		(isset($_POST['delete_posts']) && $_POST['delete_posts'] == true) ? $dposts = "TRUE" : $dposts = "FALSE";
		(isset($_POST['delete_comments']) && $_POST['delete_comments'] == true) ? $dcomments = "TRUE" : $dcomments = "FALSE";
		(isset($_POST['admin_panel']) && $_POST['admin_panel'] == true) ? $apanel = "TRUE" : $apanel = "FALSE";
		(isset($_POST['is_default']) && $_POST['is_default'] == true) ? $is_default = "TRUE" : $is_default = "FALSE";
		(isset($_POST['rnotes']) && $_POST['rnotes'] == true) ? $rnotes = "TRUE" : $rnotes = "FALSE";
		(isset($_POST['rtags']) && $_POST['rtags'] == true) ? $rtags = "TRUE" : $rtags = "FALSE";
		(isset($_POST['fposts']) && $_POST['fposts'] == true) ? $fposts = "TRUE" : $fposts = "FALSE";
		(isset($_POST['ftopics']) && $_POST['ftopics'] == true) ? $ftopics = "TRUE" : $ftopics = "FALSE";
		(isset($_POST['flock']) && $_POST['flock'] == true) ? $flock = "TRUE" : $flock = "FALSE";
		(isset($_POST['fedit']) && $_POST['fedit'] == true) ? $fedit = "TRUE" : $fedit = "FALSE";
		(isset($_POST['fpin']) && $_POST['fpin'] == true) ? $fpin = "TRUE" : $fpin = "FALSE";
		(isset($_POST['anotes']) && $_POST['anotes'] == true) ? $anotes = "TRUE" : $anotes = "FALSE";
		(isset($_POST['cupload']) && $_POST['cupload'] == true) ? $cupload = "TRUE" : $cupload = "FALSE";
		(isset($_POST['iadmin']) && $_POST['iadmin'] == true) ? $iadmin = "TRUE" : $iadmin = "FALSE";
		if($is_default == "TRUE")
		{
			$query = "UPDATE $group_table SET default_group=FALSE";
			$db->query($query);
		}
		$query = "UPDATE $group_table SET delete_posts=$dposts, delete_comments=$dcomments, admin_panel=$apanel, default_group=$is_default, reverse_notes=$rnotes, reverse_tags=$rtags, delete_forum_posts=$fposts, delete_forum_topics=$ftopics, lock_forum_topics=$flock, edit_forum_posts=$fedit, pin_forum_topics=$fpin, alter_notes=$anotes, can_upload=$cupload, is_admin=$iadmin WHERE id='".$db->real_escape_string($_POST['group'])."'";
		
		if($db->query($query))
			print '权限编辑成功';
		else
			print '权限编辑失败';
	}
	if(isset($_POST['group_name'])  && $_POST['group_name'] != "")
	{
		$gname = $db->real_escape_string($_POST['group_name']);
		$query = "SELECT * FROM $group_table WHERE id='$gname'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
?>
<div class="content">
	<form method="post" action="">
	<table class="highlightable" style="font-size: 12px; width: 100%;"><tr><td>
	群组 <?php print $row['group_name']; ?><br />
	</td></tr>
	<tr><td>
	可以删除帖子<br />
	<input type="checkbox" name="delete_posts" <?php $row['delete_posts'] == true ? print 'checked=true' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以删除评论<br />
	<input type="checkbox" name="delete_comments" <?php $row['delete_comments'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以访问管理后台<br />
	<input type="checkbox" name="admin_panel" <?php $row['admin_panel'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	默认组（新用户注册后所在群组）<br />
	<input type="checkbox" name="is_default" <?php $row['default_group'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以恢复注释<br />
	<input type="checkbox" name="rnotes" <?php $row['reverse_notes'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以恢复标签<br />
	<input type="checkbox" name="rtags" <?php $row['reverse_tags'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以删除论坛帖子<br />
	<input type="checkbox" name="fposts" <?php $row['delete_forum_posts'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以删除论坛主题<br />
	<input type="checkbox" name="ftopics" <?php $row['delete_forum_topics'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以锁定论坛帖子<br />
	<input type="checkbox" name="flock" <?php $row['lock_forum_topics'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以编辑所有论坛帖子<br />
	<input type="checkbox" name="fedit" <?php $row['edit_forum_posts'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以置顶论坛主题<br />
	<input type="checkbox" name="fpin" <?php $row['pin_forum_topics'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以修改、创造、删除注释<br />
	<input type="checkbox" name="anotes" <?php $row['alter_notes'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	可以发表帖子<br />
	<input type="checkbox" name="cupload" <?php $row['can_upload'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	管理员组 <span style="color: #ff0000;">注意，选中此项后此组内用户都将成为管理员！</span><br />
	<input type="checkbox" name="iadmin" <?php $row['is_admin'] == true ? print 'checked="true"' : print ''; ?>/>
	</td></tr>
	<tr><td>
	<input type="hidden" name="check" value="1"/>
	</td></tr>
	<tr><td>
	<input type="hidden" name="group" value="<?php print $gname; ?>"/>
	</td></tr>
	<tr><td>
	<input type="submit" name="submit" value="保存"/>
	</td></tr></table>
	</form>

	<br />
	请注意，如果你要删除这个组，请确保没有任何用户在其中。否则可能会导致无法预料的错误。
	<br />
	<a href="?page=edit_group&delete=<?php echo $row['id']; ?>">删除此用户组（慎重）</a>
<?php
	}
	else
	{
		echo '<form method="post" action="">
		<table><tr><td>
		群组：<br />
		<select name="group_name">
		<option>选择用户组……</option>';
		
		$uid = $db->real_escape_string($_COOKIE['user_id']); 
		$query = "SELECT group_name, id, (SELECT t1.is_admin FROM $group_table AS t1 JOIN $user_table AS t2 ON t2.id='$uid'WHERE t1.id=t2.ugroup) AS admin FROM $group_table ORDER BY id ASC";
		$result = $db->query($query);
		while($row = $result->fetch_assoc())
		{
			if($row['admin'] == true && $row['id'] == 1)
			{
				echo "<option value=\"".$row['id']."\">".$row['group_name']."</option>";
			}
			else if($row['id'] != 1 && $row['id'] > 1)
			{
				echo "<option value=\"".$row['id']."\">".$row['group_name']."</option>";
			}
		}
		echo '</select></td></tr>
		<tr><td>
		<input type="submit" name="submit" value="提交"/>
		</td></tr></table></form>
		';
	}
?>