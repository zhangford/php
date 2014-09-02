<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-9-2
 * Time: 上午10:50
 */
?>
<header><h1>性能</h1></header>
<section>
	<article>
		<p>设计技巧</p>
		<ol>
			<li>了解状态：翻得很烂。大意是为了在服务环境器中使用全局的状态变量，要么使用Cookie在本地存储（不安全）；要么在多台服务器中指定一台来存储Session。</li>
			<li>缓存：Pear中有个缓存包，Pear中的东西很多已经停止维护了。放弃。</li>
			<li>不要超标设计：文不对题，一堆废话。</li>
		</ol>
		<section>
			<h2>压力测试</h2>
			<p>Apache服务器自带一个压力测试工具Apache Benchmarking，当前命令名为ab2。通过模拟一定数量的客户端发送请求到服务器。示例：</p>
			<pre>ab -n 10000 -c 10 http://localhost/machine</pre>
			<p>-n选项设置请求的数量，-c设置客户端的并发数量。这行命令将发送10000个请求，一次10个。结果如下图：</p>
			<img src="images/ab2.png" />
			<p>还有个叫siege的测试工具，以及Zend Studio提供的性能分析工具。再往后都是与Zend相关的，这些收费的东东，用不上。</p>
		</section>
	</article>

</section>
<footer>
</footer>