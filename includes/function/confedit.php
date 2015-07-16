<?php
//PHP配置文件读写 完善改进版
//来自http://www.oschina.net/code/snippet_127872_6125
/**
 * 配置文件操作(查询了与修改)
 * 默认没有第三个参数时，按照字符串读取提取''中或""中的内容
 * 如果有第三个参数时为int时按照数字int处理。
 * 调用demo
    $name="admin";//kkkk
    $bb='234';
    $bb=get_config("./2.php", "bb", "string");
    update_config("./2.php", "name", "admin");
	
	对形如config.php文件的读取，修改等操作 
	<?php
		$name="admin";//kkkk
		$bb='234';
		$db=4561321;
		$kkk="admin";
	?>

	函数定义： 
		配置文件数据值获取：function get_config($file, $ini, $type="string") 
		配置文件数据项更新：function update_config($file, $ini, $value,$type="string") 

	调用方式： 
		get_config("./2.php", "bb");//
		update_config("./2.php", "kkk", "admin");
*/
function get_config($file, $ini, $type="string"){
    if(!file_exists($file)) return false;
    $str = file_get_contents($file);
    if ($type=="int"){
        $config = preg_match("/".preg_quote($ini)."=(.*);/", $str, $res);
        return $res[1];
    }
    else{
        $config = preg_match("/".preg_quote($ini)."=\"(.*)\";/", $str, $res);
        if($res[1]==null){  
            $config = preg_match("/".preg_quote($ini)."='(.*)';/", $str, $res);
        }
        return isset($res[1]) ? $res[1] : '';
    }
}
 
function update_config($file, $ini, $value,$type="string"){
    if(!file_exists($file)) return false;
    $str = file_get_contents($file);
    $str2="";
    if($type=="int"){   
        $str2 = preg_replace("/".preg_quote($ini)."=(.*);/", $ini."=".$value.";",$str);
    }
    else{
        $str2 = preg_replace("/".preg_quote($ini)."=(.*);/",$ini."=\"".$value."\";",$str);
    }
    file_put_contents($file, $str2);
}
?>