<?php
	if(!isset($_GET['uname']) && !isset($_GET['id']))
	{
		header('Location: index.php');
		exit;
	}
	if(isset($_GET['id']) && is_numeric($_GET['id']) || isset($_GET['uname']) && $_GET['uname'] != "")
	{
		if(isset($_GET['uname']))
		{
			$uname = $db->real_escape_string($_GET['uname']);
			$query = "SELECT id FROM $user_table WHERE user='$uname'";
			$result = $db->query($query) or die($db->error);
			$row = $result->fetch_assoc();
			$result->close();
			$id = $row['id'];
		}
		else
			$id = $db->real_escape_string($_GET['id']);
		$query = "SELECT t1.user, t1.record_score, t1.post_count, t1.comment_count, t1.tag_edit_count, t1.forum_post_count, t1.signup_date, t2.group_name FROM $user_table as t1 JOIN $group_table AS t2 ON t2.id=t1.ugroup WHERE t1.id='$id'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_assoc();
		if($result->num_rows == 0)
		{
			header('Location: index.php?page=post&s=list');
			exit;
		}
		require 'includes/header.php';
		$result->close();
		$user = $row['user'];
		$query = "SELECT fcount FROM $favorites_count_table WHERE user_id='$id'";
		$result = $db->query($query) or die($db->error);
		$r = $result->fetch_assoc();
		$result->close();
		($r == '') ? $row['fcount'] = 0 : $row['fcount'] = $r['fcount'];
		?>
			<div id="content">
			<h2><?php print $row['user'];
			$user2 = new user();
			if($user2->gotpermission('is_admin')){echo ' | <a href="'.$site_url.'/admin/index.php?page=ban_user&user_id='.$id.'">封禁此用户</a>';}?></h2>
				<div>
					<table width="100%" class="highlightable">
		<tr>
		  <td width="20%"><strong>注册日期</strong></td>
		  <td width="80%"><?php if(!is_null($row['signup_date']) && $row['signup_date']!=""){ print mb_substr($row['signup_date'],0,strlen($row['signup_date'])-9,'UTF-8');} else { echo "N/A";} ?></td>
		</tr>
		<tr>
		  <td><strong>群组</strong></td>
		  <td>
		   <?php print ucfirst(mb_strtolower($row['group_name'],'UTF-8')); ?>
		  </td>
		</tr>
		<tr>
		  <td><strong>帖子</strong></td>
		  <td><a href="index.php?page=post&amp;s=list&amp;tags=user:<?php print $row['user']; ?>"><?php print $row['post_count']; ?></a></td>
		</tr>
		<tr>
		  <td><strong>收藏</strong></td>
		  <td><a href="index.php?page=favorites&amp;s=view&amp;id=<?php print $id;?>"><?php print $row['fcount']; ?></a></td>
		</tr>
		<tr>

		  <td><strong>评论</strong></td>
		  <td><?php print $row['comment_count']; ?></td>
		</tr>
		<tr>
		  <td><strong>编辑标签</strong></td>
		  <td><a href="index.php?page=account&amp;s=tag_edits&id=<?php echo $id; ?>"><?php print $row['tag_edit_count']; ?></a></td>
		</tr>
		  <td><strong>论坛帖子</strong></td>
		  <td><?php print $row['forum_post_count']; ?></td>
		</tr>
	  </table>
	</div>
<?php
		$cache = new cache();
		$domain = $cache->select_domain();
?>
		<script type="text/javascript">
		//<![CDATA[
			posts = {}; pignored = {};
		//]]>
		</script>
		<div style="display:none">
			<a href="#" id="blacklist-count"></a>
			<a href="#" id="blacklisted-sidebar"></a>
		</div>
	<div style="margin-bottom: 1em; float: left; clear: both;">
	  <h4>最近收藏</h4>
	  <div>
<?php 
		$query = "SELECT favorite FROM $favorites_table WHERE user_id='$id' ORDER BY added DESC LIMIT 5";
		$result = $db->query($query) or die($db->error);
		while($row = $result->fetch_assoc())
		{
			$query = "SELECT id, directory as dir, image, tags, owner, rating, score, video FROM $post_table WHERE id='".$row['favorite']."'";
			$res = $db->query($query) or die($db->error);
			$r = $res->fetch_assoc();
			if($r['video'] == true)
				$eurl = $thumbnail_url.'/'.'video.png';
			else
				$eurl = $thumbnail_url.'/'.$r['directory'].'/thumbnail_'.$r['image'];
			?>
				<span class="thumb" id="p<?php print $r['id']; ?>"><a href="index.php?page=post&amp;s=view&amp;id=<?php print $r['id']; ?>"><img src="<?php echo $eurl; ?>" alt="<?php print $r['tags'].' 【分级】'.$r['rating'].' 【分数】'.$r['score'].' 【用户】'.$r['owner']; ?>" class="preview" title="<?php print $r['tags'].' 【分级】'.$r['rating'].' 【分数】'.$r['score'].' 【用户】'.$r['owner']; ?>"></a></span>
			<script type="text/javascript">
			//<![CDATA[
			
				posts['<?php print $r['id']; ?>'] = {'tags':'<?php print mb_strtolower(str_replace('\\',"&#92;",str_replace("'","&#039;",substr($r['tags'],1,strlen($r['tags'])-2))),'UTF-8');?>'.split(/ /g), 'rating':'<?php print mb_strtolower($r['rating'],'UTF-8'); ?>', 'score':'<?php print $r['score']; ?>', 'user':'<?php print mb_strtolower(str_replace('\\',"&#92;",str_replace(' ','%20',str_replace("'","&#039;",$r['owner']))),'UTF-8'); ?>'}
			//]]>
			</script>
			<?php
			$res->close();
		}
		if($result->num_rows<1)
		{
			print '<p>Signifying nothing.</p>';
		}
?>
</div>
</div>
<div style="margin-bottom: 1em;  float: left; clear: both;">
<h4>最近上传 <a href="index.php?page=post&amp;s=list&amp;tags=user:<?php print $user; ?>">&raquo;</a></h4>
<div>
<?php
		$query = "SELECT id, directory as dir, image, tags, rating, score, owner, video FROM $post_table WHERE owner='$user' ORDER BY id DESC LIMIT 5";
		$result = $db->query($query) or die($db->error);
		while($row = $result->fetch_assoc())
		{
			if($row['video'] == true)
				$eurl = $thumbnail_url.'/'.'video.png';
			else
				$eurl = $thumbnail_url.'/'.$row['dir'].'/thumbnail_'.$row['image'];
?>
  <span class="thumb" id="p<?php print $row['id']; ?>"><a href="index.php?page=post&amp;s=view&amp;id=<?php print $row['id']; ?>"><img src="<?php echo $eurl; ?>" alt="<?php print $row['tags'].' 【分级】'.$row['rating'].' 【分数】'.$row['score'].' 【用户】'.$row['owner']; ?>" class="preview" title="<?php print $row['tags'].' 【分级】'.$row['rating'].' 【分数】'.$row['score'].' 【用户】'.$row['owner']; ?>"></a></span>
	<script type="text/javascript">
		//<![CDATA[
			posts['<?php print $row['id']; ?>'] = {'tags':'<?php print mb_strtolower(str_replace('\\',"&#92;",str_replace("'","&#039;",substr($row['tags'],1,strlen($row['tags'])-2))),'UTF-8');?>'.split(/ /g), 'rating':'<?php print mb_strtolower($row['rating'],'UTF-8'); ?>', 'score':'<?php print $row['score']; ?>', 'user':'<?php print mb_strtolower(str_replace('\\',"&#92;",str_replace(' ','%20',str_replace("'","&#039;",$row['owner']))),'UTF-8'); ?>'}
		//]]>
		</script>
<?php
		}
		if($result->num_rows<1)
		{
			echo '<p>Signifying nothing.</p>';
		}
		$result->close();
		echo'<script type="text/javascript">
		filterPosts(posts)
		</script>
		</div></div>';
	}
?>