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
		<p>正则表达式的语法：定界符 表达式 定界符 [修饰符]，定界符可以是/或|和@，在需要匹配Email地址的时候就不要使用@作为定界符的表达式了。</p>
		<p>函数preg_math用来匹配正则表达式，它的第一个参数是正则式，第二个参数是需要匹配的字符串。还可以传递第三个参数，一个引用变量，匹配的文本将通过引用存放到这个名字命名的数组中。正则表达式的规则太长，不常用，用到时再查吧。</p>
		<p>preg_math_all可以重复地匹配正则表达式与字符串，从文档中提取信息时它可以找到所有有用的数据。</p>
		<p>preg_replace是替换函数，可以基于正则式匹配进行文本替换。</p>
		<p>preg_split函数可以用正则表达式来分割字符串，当然在一般情况下用explode会更快，只是后者只能使用简单的字符作为分割符。使用preg_split时它会在最后返回一个空元素，为此可以在使用第三个参数-l意为没有限制和第四个参数PREG_SPLIT_NO_EMPTY来去除最后的空元素。</p>
	</article>
	<article>
		<h2>日期处理</h2>
		<p>正则表达式和日期处理这两小节占了很大篇幅，里面都是PHP的规则，没人能全背下来吧，背下来也没什么用。</p>
		<p>PHP的日期和时间计算基于UNIX时间戳，自1970-01-01 00:00:00开始以秒计算的数字，也就是UNIX新纪元的开始。PHP只处理32位非负的整型数作为时间戳，它的范围至2038年1月19日。要处理这个范围以外的时间需要安装PEAR::Date包。</p>
		<p>接下来，使用GD来处理图形。GD这部分只是讲了两个示例，不够丰富。现在用HTML5轻松可以实现，用到时再说吧。</p>
		<p>Unicode只是给字符分配编码，它通常不被用来存储文本。一个UTF-8编码的字符串中的字符可以是1到6字节长，而且可以表示所有来自UCS的2<sup>31</sup>个字符。</p>
		<p>PHP有两个支持字符集转换的函数，自带的是mbstring，还有一个外部库所提供的iconv函数，后者支持的字符范围更广。</p>
	</article>
</section>
<footer>
	<p>本章讨论了PHP中高级编程是地经常需要的各种特性。可惜讲得都不详细，而且不清楚。</p>
</footer>