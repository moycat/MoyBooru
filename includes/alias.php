<?php
	//number of tags/page
	$limit = 40;
	//number of pages to display. number - 1. ex: for 5 value should be 4
	$page_limit = 6;
	require "header.php";
	if(isset($_POST['tag']) && $_POST['tag'] != "" && isset($_POST['alias']) && $_POST['alias'] != "")
	{
		$tag = $db->real_escape_string(str_replace(" ","_",mb_trim(htmlentities($_POST['tag'], ENT_QUOTES, 'UTF-8'))));
		$alias = $db->real_escape_string(str_replace(" ","_",mb_trim(htmlentities($_POST['alias'], ENT_QUOTES, 'UTF-8'))));
		$reason = $db->real_escape_string(mb_trim(htmlentities($_POST['reason'], ENT_QUOTES, 'UTF-8')));
		$query = "SELECT COUNT(*) FROM $alias_table WHERE tag='$tag' AND alias='$alias'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		if($row['COUNT(*)'] > 0)
			echo "<b>标签修正请求已提交过，请勿再次提交</b><br /><br />";
		else
		{
			$query = "INSERT INTO $alias_table(tag, alias, status, reason) VALUES('$tag', '$alias', 'pending', '$reason')";
			$db->query($query);
			echo "<b>标签修正请求已经提交</b><br /><br />";
		}
	}

	echo '你可以申请修正一个标签，但需要通过管理员的批准<br />
	<div style="color: #ff0000;">例子：如果申请将“乙太”修正为“以太”，那么所有带“乙太”标签的帖子都将贴上“以太”标签而取消原来的“乙太”标签。</div><br /><br />
	';

	if(isset($_GET['pid']) && $_GET['pid'] != "" && is_numeric($_GET['pid']) && $_GET['pid'] >= 0)
		$page = $db->real_escape_string($_GET['pid']);
	else
		$page = 0;
	$query = "SELECT COUNT(*) FROM $alias_table WHERE status !='rejected'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$count = $row['COUNT(*)'];	
	$numrows = $count;
	$result->free_result();
	$query = "SELECT * FROM $alias_table WHERE status != 'rejected' ORDER BY alias ASC LIMIT $page, $limit";
	$result = $db->query($query) or die($db->error);
	$ccount = 0;
	print '<table class="highlightable" style="width: 100%;"><tr><th width="25%"><b>错误标签<small>（当前被贴上的）</small></b></th><th width="25%"><b>正确标签</b><small>（它应该是）</small></th><th>理由</th></tr>';
	while($row = $result->fetch_assoc())
	{
		if($row['status']=="pending")
			$status = "pending-tag";
		else
			$status = "";
		echo '<tr class="'.$status.'"><td>'.$row['alias'].'</td><td>'.$row['tag'].'</td><td>'.$row['reason'].'</td></tr>';
	}
	echo '</table><br /><br />
	<form method="post" action=""><table><tr><td>
	<b>标签</b></td><td><input type="text" name="alias" value=""/></td></tr>
	<tr><td><b>修正为</b></td><td><input type="text" name="tag" value=""/></td></tr>
	<tr><td><b>理由</b></td><td><input type="text" name="reason" value=""/></td></tr>
	</table>
	<input type="submit" name="submit" value="提交"/>
	</form>
	<div id="paginator">';
	$misc = new misc();
	print $misc->pagination($_GET['page'],isset($sub) ? $sub : '',isset($id) ? $id : '',$limit,$page_limit,$numrows, isset($_GET['pid']) ? $_GET['pid'] : '', isset($tags) ? $tags : '');
?></div></body></html>