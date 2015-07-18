<?php
	require "../includes/function/confedit.php";
	if(!defined('_IN_ADMIN_HEADER_'))
		die;
	if(isset($_POST['site_url']))
	{
		update_config("../config.php", "site_url", $_POST['site_url']);
		update_config("../config.php", "site_url3", $_POST['site_url3']);
		update_config("../config.php", "thumbnail_url", $_POST['thumbnail_url']);
		update_config("../config.php", "image_folder", $_POST['image_folder']);
		update_config("../config.php", "video_folder", $_POST['video_folder']);
		update_config("../config.php", "dimension", $_POST['dimension'], 'int');
		update_config("../config.php", "thumbnail_folder", $_POST['thumbnail_folder']);
		
		print '设置已更新<br/>';
	}
?>
<b>站点基本设置</b>
<form name="form1" method="post" action="">
  <p>站点地址：
    <label for="site_url"></label>
  <input name="site_url" type="text" id="site_url" value="<?php echo get_config("../config.php", "site_url"); ?>">
  <em>请输入形如“http://booru.neko”的地址，或不填（推荐）。不要以斜线结尾</em>
  </p>
  <p>站点名：
    <label for="site_url3"></label>
    <input name="site_url3" type="text" id="site_url3" value="<?php echo get_config("../config.php", "site_url3"); ?>">
  <em>将显示在首页和头部</em></p>
  <p>缩略图目录URL：
    <label for="thumbnail_url"></label>
    <input name="thumbnail_url" type="text" id="thumbnail_url" value="<?php echo get_config("../config.php", "thumbnail_url"); ?>">
  <em>以斜线开头，不要以斜线结尾，可不修改</em></p>
  <p>图片文件夹名称：
    <label for="image_folder"></label>
    <input name="image_folder" type="text" id="image_folder" value="<?php echo get_config("../config.php", "image_folder"); ?>">
  <em>可不修改</em></p>
  <p>视频文件夹名称：
    <label for="video_folder"></label>
    <input name="video_folder" type="text" id="video_folder" value="<?php echo get_config("../config.php", "video_folder"); ?>">
  <em>可不修改</em></p>
  <p>
    缩略图尺寸：
      <label for="dimension"></label>
    <input name="dimension" type="text" id="dimension" value="<?php echo get_config("../config.php", "dimension", "int"); ?>">
  <em>与Danbooru中相同</em></p>
  <p>缩略图文件夹名称：
    <label for="thumbnail_folder"></label>
    <input name="thumbnail_folder" type="text" id="thumbnail_folder" value="<?php echo get_config("../config.php", "thumbnail_folder"); ?>">
  <em>可不修改</em>  </p>
  <p>
    <input type="submit" name="button" id="button" value="提交">
  </p>
</form>

