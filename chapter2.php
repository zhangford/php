<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-13
 * Time: 下午3:13
 */
$var = null;

if($var)
{
	echo "这是个Null值";
}
else
{
	echo "null值不可能为true";
}
?>
<header>
	<h1>PHP5语言基础</h1>
</header>
<p>PHP没有全局变量，在主程序主定义的变量不能在函数中直接使用，但是可以通过数组$GLOBALS[]来访问它。</p>
<p>管理变量：isset()-判断变量是否被定义；unset()-取消之前定义的变量；empty()-检查一个变量是否没有被声明或者值是false。</p>
<p>PHP字符串长度支取决于系统平台和C编译器，它最起码支持2GB的长度，不过不要写程序来测试这个了，内存未必够用。</p>
<p>可以通过字符串变量大括号内加索引值来访问里面的字符，比如：$str = "ABCD"；可以用$str{1}来取得其中的第2个字符。</p>
<p>PHP的布尔型变理取值</p>
<table>
	<tr><th>数据类型</th><th>False值</th><th>True值</th></tr>
	<tr><td>整型</td><td>0</td><td>所有非0的值</td></tr>
	<tr><td>浮点型</td><td>0.0</td><td>所有非0的值</td></tr>
	<tr><td>字符串</td><td>空字符串""，0字符串"0"</td><td>所有其他字符串</td></tr>
	<tr><td>Null</td><td>总是</td><td>总不</td></tr>
	<tr><td>数组</td><td>如果不含任何元素</td><td>如果含有一个以上元素</td></tr>
	<tr><td>对象</td><td>总不</td><td>总是</td></tr>
	<tr><td>资源</td><td>总不</td><td>总是</td></tr>
</table>
<p>最好为所有控制语句的子句加上大括号，即便只有一条语句，这样会使代码易于理解，也便于调试时添加代码。</p>
<p>break用来中断循环，它可以接收一个可选参数，表示从里往外中断的多少层循环。如：break 1;等同于break。continue也可以接收同样的参数。</p>
<p>不要在for循环的条件表达式里面写入大多运算表达式，因为他们都将在每次循环中执行。</p>
<p>PHP允许通过引用来返回变量，只需在定义和调用函数时在函数名前加&符号，这种方法不常用。要定义参数为引用传递，需在要参数变量前加&，比如：function square(&$n){}</p>