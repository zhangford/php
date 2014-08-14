<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-13
 * Time: 下午2:26
 */
?>
<header><h1>PHP5的新特性</h1></header>
<p>php5的新特性</p>
<ul>
	<li>接口interface：一个类只能有一个父类，但是可以用若干接口</li>
	<li>instanceof操作符：判断一个变量是否属于一个类</li>
	<li>final标记：用它标记的方法和类不可被继承</li>
	<li>clone关键字：复制对象，可以在类内定义__clone()方法，它将在clone对象时被调用</li>
	<li>在类中定义常量使用const关键字</li>
	<li>abstract定义抽象类：不能被实例化，但是可以被继承，在类中用abstract定义抽象方法，以便在继承子类中再定义</li>
	<li>直接引用方法返回的对象，比如：$obj->method()->method2();</li>
	<li>__autoload方法,比如：
	<pre>
		function __autoload($class_name)
		{
			include_once('$class_name'.'php');
		}
	</pre>
	</li>
</ul>
<p>PHP5的改进</p>
<ul>
	<li>XML和Web服务：所有扩展均使用libxml2</li>
	<li>SimpleXML：使得PHP极为轻松地处理XML文档</li>
	<li>支持SOAP：轻量对象访问协议</li>
	<li>支持 SQLite</li>
	<li>Tiny扩展和Perl扩展：对我来说没什么用处</li>
</ul>
<footer>
	<p>你必定为PHP5的大量改进而感动。由于这只是初步的叙述，没有覆盖所有的改进，而仅仅列出了主要的改进。其他的改进包括辅助特性、一系列错误的修下和大部分的底层结构的改进。接下来其他章节将详细介绍PHP5，并且对已经提到的或没有提到的新特性向你进行深度的阐述。</p>
</footer>