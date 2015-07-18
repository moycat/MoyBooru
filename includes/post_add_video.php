<?php
	header("Cache-Control: store, cache");
	header("Pragma: cache");
	require "includes/header.php";
	//die("Maintenance mode. please try again in 1 hour.");
	error_reporting(0);
	ignore_user_abort(1);
	$misc = new misc();
	$userc = new user();
	$ip = $db->real_escape_string($_SERVER['REMOTE_ADDR']);	
	if($userc->banned_ip($ip))
	{
		print "执行失败： ".$row['reason'];
		exit;
	}	
	if(!$userc->check_log())
	{
		if(!$anon_can_upload)
			$no_upload = true;
	}
	else
	{
		if(!$userc->gotpermission('can_upload'))
			$no_upload = true;
	}
	if($no_upload)
	{
		print "你没有上传的权限";
		exit;
	}
	if(isset($_POST['submit']))
	{
		$code = $db->real_escape_string(htmlentities($_POST['code'],ENT_QUOTES,'UTF-8'));
		$already_check = "SELECT COUNT(*) FROM $post_table WHERE image='$code.mp4'";
		$prec = $db->query($already_check);
		$ac = $prec->fetch_assoc();
		if($ac['COUNT(*)'] > 0 || !is_file('./'.$video_folder.'/'.$code.'.mp4'))
		{
			print "代码错误！请检查后再试";
			exit;
		}
		$url = $code.'.mp4';
		$tclass = new tag();
		$misc = new misc();
		$source = $db->real_escape_string(htmlentities($_POST['source'],ENT_QUOTES,'UTF-8'));
		$title = $db->real_escape_string(htmlentities($_POST['title'],ENT_QUOTES,'UTF-8'));
		$tags = strtolower($db->real_escape_string(str_replace('%','',mb_strtolower(mb_trim(htmlentities($_POST['tags'],ENT_QUOTES,'UTF-8'))))));
		$ttags = explode(" ",$tags);
		$tag_count = count($ttags);
		$ttags[] = "视频";
		if($tag_count == 0)
			$ttags[] = "tagme";
		if($tag_count < 5 && strpos(implode(" ",$ttags),"tagme") === false)
			$ttags[] = "tagme";
		foreach($ttags as $current)
		{
			if(strpos($current,'parent:') !== false)
			{
				$current = '';
				$parent = str_replace("parent:","",$current);
				if(!is_numeric($parent))
					$parent = '';
			}
			if($current != "" && $current != " " && !$misc->is_html($current))
			{
				$ttags = $tclass->filter_tags($tags,$current, $ttags);
				$alias = $tclass->alias($current);
				if($alias !== false)
				{
					$key_array = array_keys($ttags, $current);
					foreach($key_array as $key)
						$ttags[$key] = $alias;
				}
			}
		}
		$tags = implode(" ",$ttags);
		foreach($ttags as $current)
		{
			if($current != "" && $current != " " && !$misc->is_html($current))
			{
				$ttags = $tclass->filter_tags($tags,$current, $ttags);
				$tclass->addindextag($current);
				$cache = new cache();
				
				if(is_dir("$main_cache_dir".""."search_cache/".$current."/"))
				{
					$cache->destroy_page_cache("search_cache/".$current."/");
				}
				else
				{
					if(is_dir("$main_cache_dir".""."search_cache/".$misc->windows_filename_fix($current)."/"))
						$cache->destroy_page_cache("search_cache/".$misc->windows_filename_fix($current)."/");		
				}
			}
		}
		asort($ttags);
		$tags = implode(" ",$ttags);
		$tags = mb_trim(str_replace("  ","",$tags));			
		if(substr($tags,0,1) != " ")
			$tags = " $tags";
		if(substr($tags,-1,1) != " ")
			$tags = "$tags ";
		$rating = $db->real_escape_string($_POST['rating']);
		if($rating == "e")
			$rating = "Explicit";
		else if($rating == "q")
			$rating = "Questionable";
		else
			$rating = "Safe";
		if($userc->check_log())
			$user = $checked_username;
		else
			$user = "Anonymous";

		$ip = $db->real_escape_string($_SERVER['REMOTE_ADDR']);
		$newhash = md5_file(time());
		$query = "INSERT INTO $post_table(video, creation_date, hash, image, title, owner, height, width, ext, rating, tags, directory, source, active_date, ip) VALUES('1', NOW(), '".$newhash."', '".$url."', '$title', '$user', '0', '0', '.mp4', '$rating', '$tags', 'video', '$source', '".date("Ymd")."', '$ip')";
		if(!$db->query($query))
		{
			print "视频发布失败"; print $query;
			$ttags = explode(" ",$tags);
			foreach($ttags as $current)
				$tclass->deleteindextag($current);
		}
		else
		{
			$query = "SELECT id, tags FROM $post_table WHERE hash='".$newhash."' AND image='".$url."' AND directory='video'  LIMIT 1";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$tags = $db->real_escape_string($row['tags']);
			$date = date("Y-m-d H:i:s");
			$query = "INSERT INTO $tag_history_table(id,tags,user_id,updated_at,ip) VALUES('".$row['id']."','$tags','$checked_user_id','$date','$ip')";
			$db->query($query) or die($db->error);				
			$cache = new cache();				
			if($parent != '' && is_numeric($parent))
			{
				$parent_check = "SELECT COUNT(*) FROM $post_table WHERE id='$parent'";
				$pres = $db->query($parent_check);
				$prow = $pres->fetch_assoc();
				if($prow['COUNT(*)'] > 0)
				{
					$temp = "INSERT INTO $parent_child_table(parent,child) VALUES('$parent','".$row['id']."')";
					$db->query($temp);
					$temp = "UPDATE $post_table SET parent='$parent' WHERE id='".$row['id']."'";
					$db->query($temp);
					$cache->destroy("cache/".$parent."/post.cache");	
				}
			}				
			if(is_dir("$main_cache_dir".""."cache/".$row['id']))
				$cache->destroy_page_cache("cache/".$row['id']);
			$query = "SELECT id FROM $post_table WHERE id < ".$row['id']." ORDER BY id DESC LIMIT 1";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			$cache->destroy_page_cache("cache/".$row['id']);
			$query = "UPDATE $post_count_table SET last_update='20060101' WHERE access_key='posts'";
			$db->query($query);
			$query = "UPDATE $user_table SET post_count = post_count+1 WHERE id='$checked_user_id'";
			$db->query($query);
			print "<b>视频添加成功</b>";
		}
	}
	print $error;
?>
	<form method="post" target="" enctype="multipart/form-data">
	<table><tr>
	<td>
	视频文件代码<br />
	<input type="text" name="code" id="code">
	<td></tr>
	<tr><td>
	来源<br />
	<input type="text" name="source" value="" />
	</td></tr>
	<tr><td>
	标题<br />
	<input type="text" name="title" value="" />
	</td></tr>
	<tr><td>
	标签<br />
	<input type="text" id="tags" name="tags" value="" /><br />
	<em>以空格分隔（例如：萨摩耶 猹）</em>
	</td></tr>
	<tr><td>
	分级<br />
	<input type="radio" name="rating" value="e" />敏感的
	<input type="radio" name="rating" value="q" checked="true" />存疑的
	<input type="radio" name="rating" value="s" />安全的
	<tr><td>
	我的标签<br />
	<?php if(isset($_COOKIE['tags']) && $_COOKIE['tags'] != ""){$tags = explode(" ",str_replace('%20',' ',$_COOKIE['tags'])); foreach($tags as $current){echo "<a href=\"index.php?page=post&s=list&tags=".$current."\" id=\"t_".$current.'" onclick="toggleTags(\''.$current.'\',\'tags\',\'t_'.$current.'\'); return false;">'.$current.' </a>';}}else{echo '<a href="index.php?page=account-options">编辑</a>';} ?>
	<td></tr>
	<tr><td>
	<input type="submit" name="submit" value="发布" />
	</td></tr>
	</table>
	</form>
	<script type="text/javascript">
	//<![CDATA[
	function toggleTags(tag, id, lid)
	{
		temp = new Array(1);
		temp[0] = tag;
		tags = $(id).value.split(" ");
		if(tags.include(tag))
		{
			$(id).value=tags.without(tag).join(" ");
			$(lid).innerHTML=tag+" ";
		}
		else
		{
			$(id).value=tags.concat(temp).join(" ");
			$(lid).innerHTML="<b>"+tag+"</b> ";
		}
	}
	//]]>
	</script></div></body></html>