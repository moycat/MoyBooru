<?php
	require "../inv.header.php";
	require "../includes/header.php";
?>
<div id="content">
<div class="help">

  <h1>帮助：分级</h1>

<div class="section">
<p>所有在 <?php echo $site_url3;?> 上的帖子都属于三种分级之一：敏感的、存疑的、安全的。如果在上传时更改，帖子将默认是“存疑的”。</p>
<p><strong>但是注意，分级并不一定准确，这取决于上传的人是否正确选择。</strong>如果你发现了某篇帖子分级错误，请协助修改。</p>

<div class="section">
	<h4>敏感的</h4>
	<p>任何不适宜于在所有场所观看的帖子都属于此类。</p>
</div>
  
<div class="section">
	<h4>安全的</h4>
	<p>安全的帖子通常可以在任何场合观看，而不会引发问题。</p>
</div>
  
<div class="section">
	<h4>存疑的</h4>
	<p>部分帖子难以判断安全与否，归入此类。</p>
</div>

<div class="section">
	<h4>搜索</h4>
	<p>你可以在搜索框输入以下关键字来只显示指定分级：</p>
	<p><code>rating:safe</code>、<code>rating:questionable</code> 或 <code>rating:explicit</code></p>
	<p>这些关键字不影响其他关键字。</p>
	<p>如果你想屏蔽某个分级的帖子，可以使用以下关键字：</p>
	<p> <code>-rating:safe</code>, <code>-rating:questionable</code>, and <code>-rating:explicit</code>.</p>
	<p>（<code>safe</code>：安全的，<code>questionable</code>：存疑的，<code>explicit</code>：敏感的）</p>
	<p>更详细的搜索请参阅 帮助：搜索。</p>
</div>
</div></body></html>