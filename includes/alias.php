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
		$query = "SELECT COUNT(*) FROM $alias_table WHERE tag='$tag' AND alias='$alias'";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		if($row['COUNT(*)'] > 0)
			echo "<b>标签-别名组合已经提交</b><br /><br />";
		else
		{
			$query = "INSERT INTO $alias_table(tag, alias, status) VALUES('$tag', '$alias', 'pending')";
			$db->query($query);
			echo "<b>标签-别名组合已经提交</b><br /><br />";
		}
	}

	echo '你可以申请建立一个标签-别名组合，但在其可用前需要先通过管理员的批准<br />
	<div style="color: #ff0000;">例子：美国可以是美利坚合众国的别名</div><br /><br />
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
	print '<table class="highlightable" style="width: 100%;"><tr><th width="25%"><b>标签：<small>（你在搜索框中输入的）</small></b></th><th width="25%"><b>别名：</b><small>（它应该是）</small></th><th>理由：</th></tr>';
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
	<b>别名：</b></td><td><input type="text" name="alias" value=""/></td></tr>
	<tr><td><b>别名至：</b></td><td><input type="text" name="tag" value=""/></td></tr>
	</table>
	<input type="submit" name="submit" value="提交"/>
	</form>
	<div id="paginator">';
	$misc = new misc();
	print $misc->pagination($_GET['page'],$sub,$id,$limit,$page_limit,$numrows,$_GET['pid'],$tags);
?></div></body></html>