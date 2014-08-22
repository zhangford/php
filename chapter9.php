<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-21
 * Time: 下午3:02
 */
?>
<header><h1>主流扩展</h1></header>
<section>
	<article>
		<h2>文件与流</h2>
		<h3>文件访问</h3>
		<p>用fopen()函数创建一个文件句柄。有两个必选参数，第一个是文件路径，第二个是模式。注意在windows系统中是区分文本和二进制文件的，因此，为了脚本在Windows 下通用，在创建二进制文件时一定要加入b参数，虽然在Unix系统下b参数没有任何作用。</p>
		<p>fopen()还有第三个可选参数-true，首先会在当前目录下寻找文件，找不到的话会去include路径中寻找。比如，下面的程序将打印php.ini:</p>
		<pre>
		//设置包含路径
		ini_set('include_path', '/etc/php5/apache2');
		//开启指向文件的句柄
		$fp = fopen('php.ini', 'r', true);	//因为这不是个二进制文件所以不管在Win下还是linux下都不需要使用b参数

		//读取所有行并显示
		while(!feof($fp))		//feof()检查最后一次fgets()或fread()后是否已到文件末尾
		{
			$line = trim(fgets($fp,256));
			echo ">$line<\n";

		}
		//关闭句柄
		fclose($fp);
		</pre>
		<h3>程序输入和输出</h3>
		<p>与UNIX的甩有IO都是一个文件的说法类似，PHP中所有IO都是流。</p>
		<p>popen()向程序提供单向IO，一次只可以使用w或r一种模式，当打开一个流时（也可以叫做一个管道，因为只能在里面顺序操作），可以使用所有常规的文件函数来从该管道读取或写入。下面是个读取输出的例子：</p>
		<pre>
		$fp = popen('ls', 'r');
		while(!feof($fp))
		{
			echo fgets($fp);
		}
		pclose($fp);
		</pre>
	</article>
	<article>
		<h2>正则表达式</h2>
	</article>
</section>
<footer>
</footer>