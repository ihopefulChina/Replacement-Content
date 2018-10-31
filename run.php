<?php
/**
 * 有时候我们需要批量替换一些字符串，比如违禁词？邮箱等
 * 设置 $fromstr (需要替换的字符串)
 * 设置 $tostr (替换后的字符串)
 * 本文件需要服务器授权较高,如果遇到permission denied,说明权限受限,请自行解决权限问题
*/
set_time_limit(0);
$fromstr='a';
$tostr='b';

//$fromstr='defer async></script>';
//$tostr='></script>';

function listDir($dir){
global $fromstr,$tostr;
	if(is_dir($dir)){
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false){
				if((is_dir($dir."/".$file)) && !in_array($file,array(".",".."))){
					echo "Folder: ",$file,"\n";
					listDir($dir."/".$file."/");
				}else{
					if($file!="." && $file!=".."){
						$houzhui=substr($file,strrpos($file,".")+1); // 输出后缀名.
						if(in_array($houzhui,array("html","htm","php"))){ // 这里替换 html htm也就是静态网页文件
							$searchword=file_get_contents($dir."/".$file);
							$searchword=str_ireplace($fromstr,$tostr,$searchword);
							$filenum=fopen($dir."/".$file,"w+");
							fwrite($filenum,$searchword);
							fclose($filenum);
							echo $file."\n";
						}
					}
				}
			}
			closedir($dh);
		}
	}
}
listDir("./");
?>
