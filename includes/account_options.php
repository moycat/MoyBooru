<?php
	if(isset($_POST['submit']))
	{
		if(isset($_POST['users']) && $_POST['users'] != "")
		{
			setcookie("user_blacklist",strtolower(str_replace('\\',"&#92;",str_replace(' ','%20',str_replace("'","&#039;",$_POST['users'])))),time()+60*60*24*365);
			$new_user_list = $_POST['users'];
		}
		else
		{
			setcookie("user_blacklist",'',time()-60*60*24*365);
			$new_user_list = " ";
		}
		if(isset($_POST['tags']) && $_POST['tags'])
		{
			setcookie("tag_blacklist",str_replace('\\',"&#92;",str_replace(' ','%20',str_replace("'","&#039;",$_POST['tags']))),time()+60*60*24*365);
			$new_tag_list = $_POST['tags'];
		}
		else
		{
			setcookie("tag_blacklist","",time()-60*60*24*365);
			$new_tag_list = " ";
		}
		if(isset($_POST['cthreshold']) && $_POST['cthreshold'] != "")
		{
			if(!is_numeric($_POST['cthreshold']))
			{
				setcookie('comment_threshold',0,time()+60*60*24*365);
				$new_cthreshold = 0;
			}
			else
			{
				setcookie('comment_threshold',$_POST['cthreshold'],time()+60*60*24*365);
				$new_cthreshold = $_POST['cthreshold'];
			}
		}
		else
		{
			setcookie('comment_threshold',"",time()-60*60*24*365);
			$new_cthreshold = 0;
		}
		if(isset($_POST['pthreshold']) && $_POST['pthreshold'] != "")
		{
			if(!is_numeric($_POST['pthreshold']))
			{
				setcookie('post_threshold',0,time()+60*60*24*365);
				$new_pthreshold = 0;
			}
			else
			{
				setcookie('post_threshold',$_POST['pthreshold'],time()+60*60*24*365);
				$new_pthreshold = $_POST['pthreshold'];
			}
		}
		else
		{
			setcookie('post_threshold',"",time()-60*60*24*365);
			$new_pthreshold = 0;
		}
		if(isset($_POST['my_tags']) && $_POST['my_tags'] != "")
		{
			$user = new user();
			setcookie("tags",str_replace(" ","%20",str_replace("'","&#039;",$_POST['my_tags'])),time()+60*60*24*365);
			$new_my_tags = $_POST['my_tags'];
			if($user->check_log())
			{
				$my_tags = $db->real_escape_string($_POST['my_tags']);			
				$query = "UPDATE $user_table SET my_tags = '$my_tags' WHERE id = '$checked_user_id'";
				$db->query($query);
			}
		}
		else
		{
			setcookie("tags",'',time()-60*60*24*365);
			$new_my_tags = " ";
		}
	}
	header("Cache-Control: store, cache");
	header("Pragma: cache");
	require "includes/header.php";
?>
<div id="content">
<form action="" method="post">
<p><em>用空格分隔独立的标签或用户</em> 你必须开启cookies和JavaScript支持才能使用过滤器。用户名称区分大小写。</p>

<div class="option">
<table cellpadding="0" cellspacing="4">
<tr><td>
<label class="block">标签黑名单</label><p>任何带有黑名单内标签的帖子都会被屏蔽。你也可以屏蔽指定的分级。</p>
</td><td>
<textarea name="tags" rows="20" cols="50"><?php $new_tag_list != "" ? print $new_tag_list : print str_replace('%20',' ', str_replace("&#039;","'",$_COOKIE['tag_blacklist'])); ?></textarea>
</td></tr>
<tr><td>
<label class="block">用户黑名单</label><p>黑名单中任何用户发布的帖子都将被屏蔽。</p>
</td><td>
<input type="text" name="users" value="<?php $new_user_list != "" ? print $new_user_list : print str_replace('%20',' ', str_replace("&#039;","'", $_COOKIE['user_blacklist'])); ?>"/>
</td></tr>
<tr><td>
<label class="block">评论阈值</label>	<p>任何投票评分低于此值的评论都将被屏蔽。</p>
</td><td>
<input type="text" name="cthreshold" value="<?php ($new_cthreshold == "" && !isset($_COOKIE['comment_threshold'])) ? print 0 : $new_threshold != "" ? print $new_cthreshold : print $_COOKIE['comment_threshold']; ?>"/>
</td></tr>
<tr><td>
<label class="block">帖子阈值</label><p>任何投票评分低于此值的帖子都将被屏蔽。</p>
</td><td>
<input type="text" name="pthreshold" value="<?php ($new_pthreshold == "" && !isset($_COOKIE['post_threshold'])) ? print 0 : $new_pthreshold != "" ? print $new_pthreshold : print $_COOKIE['post_threshold']; ?>"/>
</td></tr>
<tr><td>
<label class="block">我的标签</label>
<p>当你发表与编辑帖子时，可以快速选择这里设置的标签。</p>
</td><td>
<textarea name="my_tags" rows="30" cols="50"><?php $new_my_tags != "" ? print $new_my_tags : print str_replace("%20", " ",str_replace('&#039;',"'",$_COOKIE['tags']));?></textarea>	
</td></tr></table>
</div>
<div class="option">
<input type="submit" name="submit" value="Save"/>
</div>
</form></div></body></html>