<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-14
 * Time: 下午1:15
 */

echo $_SERVER['HTTP_USER_AGENT'];
?>
<header>
	<h1>PHP高级面向对象编程和设计模式</h1>
</header>
<p>__call函数进行方法重载，这个说得并不详细。</p>
<p>如果类实现了Iterator接口，就可以用foreach循环来遍历对象属性，象数组那样。感觉不实用。</p>
<p>用$_SERVER['HTTP_USER_AGENT']可以取得用户的操作系统及浏览器数据。</p>
<section>
	<header><h2>面向对象程序设计用到的几种设计模式</h2></header>
	<ul>
		<li>策略模式：执行相同动作，但是内容不同，创建抽象类。比如：同样是下载，Linux下需要下载tar.gz格式，windows下需要下载zip格式。这一模式主要是定义类的动作，如果有一堆相同动作的类，可以整个为一个抽象类，用来规范类定义。策略模式经常和工厂模式一起使用。</li>
		<li>单件模式：用一个类的实例来处理应用中的一些集中操作，这个对象覆盖整个应用范围，通过静态函数getInstance()来与类的实例对话。它的构造函数和__clone方法都定义为private，以防止出现第二个类的实例。</li>
		<li>工厂模式：以一个类（工厂类）通过一个静态方法控制其它类的实例化。比如：用一个抽象的User类定义用户的基本动作，AdminUser和CustomerUser类继承并实现User类，用工厂类UserFactory来根据用户类型实例化不同的类。用一个类来调度其他有共性的类，这种方式应当比较有趣，但是有点罗嗦啊。</li>
		<li>观察者模式：通过实例化一个叫Observer的接口（它有一个函数notify($obj)）的类来实现，通过这个类可以在影响到其所管理的类的数据发生变化时，令其所管理的类作出相应变化。</li>
	</ul>
</section>
<p>PHP5具用了映射能力，用来实时地收集脚本信息。这一节翻得狗屁不通。</p>
<footer>
	<p>本章覆盖了更多的PHP高级面向对象的特性，它们中有许多在执行大型的面向对象应用中很重要。由于PHP5的优执，使用常用的面向对象编程方法例如设计模式，相对以往 的PHP版本来说，现在已经成为现实。如果想更加深入了解，我们建议你了解更多的有关设计模式和面向对象方法的资料。</p>
</footer>