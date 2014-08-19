<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-19
 * Time: 下午3:46
 */
?>
<header>
	<h1>错误处理</h1>
</header>
<p>许多造成错误的因素是脚本控制之外的。网络超时、硬盘空间满、硬件错误等等，这些错误与代码没有关系。PHP默认会把错误信息显示给用户，对于大多数错误，PHP在显示错误后继续运行。这些错误是给开发者看的，有时你需要将它们捕获并以用户容易理解的方式显示给用户。</p>
<p>错误抑制操作符@，将所在行的错误级别降到0，阻止错误信息输出。</p>
<p>如果你想在代码中产生一个异常，使用throw语句：比如：throw new FileException("couldn't read file");catch根据Exception类的类型来判断是什么错误。如果异常在任何地方都没有被捕获，PHP提供了异常处理函数来打印错误信息，也可以通过调用set_exception_handler()来指定自己定函数替换内置操作。</p>
<footer>
	<p>这一章有一半的内容在讲pear的错误处理，列出一堆方法变量，没有讲pear，而对于try...throw...catch也没有仔细讲。真是差劲的一本书。</p>
</footer>