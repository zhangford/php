<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-16
 * Time: 下午2:44
 */
$conn = mysqli_connect('localhost', 'root', 'al8840dd', 'machinemanager');
$stmt = $conn->prepare('INSERT INTO user(userId, userName) VALUES (?,?)');
$stmt->bind_param('is', $userId, $userName);	//参数1‘is'表示后面的参数类型i 表示第一个number型，s表示string
//接下来，指定参数值，然后执行即可，这个插入是失败的，因为不是合适的，没有错误提示，有点不好
$userId=1;
$userName='aaaa';
$stmt->execute();
$userId=2;
$userName='bbbb';
$stmt->execute();
$userId=3;
$userName='cccc';
$stmt->execute();
$userId=4;
$userName='dddd';
$stmt->execute();

//下面是获取数据,这个语法干净简洁
$stmt = $conn->prepare('SELECT userId,userName FROM user');
$stmt->execute();
$stmt->bind_result($userId, $userName);
echo "<table>\n";
echo "<tr><th>Id</th><th>Name</th></tr>";
while($stmt->fetch())
{
	echo "<tr><td>$userId</td><td>$userName</td></tr>";
}
echo "</table>\n";
?>
<header>
	<h1>使用PHP5访问数据库</h1>
</header>
<p>几乎每个mysqli的函数都有一个面向过程和面向对象配对的方法或者属性。比如，有面向过程的mysqli_options也有面向对象的$mysqli->options，它们的功能是一样的。</p>
<p>mysqli_init、mysqli_options和mysqli_real_connect函数可以在连接数据库时设置更多的选项。<em>暂时用不到</em></p>
<p>MySQL客户端有两种类型查询：缓冲查询-将接收查询的结果并存储在客户端内存中，接下来获取记录的请求仅从本地内存获得，优点是很容易找到，可以自由地移动当前行指针，因为结果都在客户端，缺点就是需要额外内存（这不算什么缺点了），需要接收到所有结果后才会返回值；无缓冲查询-可以在MySQL服务器开始返回值的时候就开始获取并显示或处理数据行。使用无缓冲结果集时，必须用mysqli_fetch_row函数，或者在给服务器发送其他任何命令前用mysqli_free_result函数关闭结果集。</p>
<p>mysqli的两种连接方式：
	<ul>
		<li>$mysqli = new mysqli('localhost', 'db_user', 'user_password' 'database_name');</li>
		<li>$conn = mysqli_connect('localhost', 'db_user', 'user_password' 'database_name');</li>
	</ul>
	两者都得到一个数据库操作对象。
</p>
<p>mysqli_query函数返回一个结果对象集，如果查询失败，使用mysqli_error函灵长或$conn->error属性来确定失败原因。为了使用无缓冲查询，需要在查询时指定参数MYSQLI_USE_RESULT，比如$conn->query("SELECT * FROM USER", MYSQLI_USE_RESULT")。在执行结束后，一般要加上$result->free();$conn->close()。使用mysqli_multi_query还可以同时进行多个SQL查询。</p>
<section>
	<h2>查询结果的三种获取方式，它们的参数都是查询结果</h2>
	<ul>
		<li>枚举数组：mysqli->fetch_row()或mysqli_fetch_row()-检索一个结果集合的下一行。当在mysql_store_result()之后使用时，如果没有更多的行可检索时，mysql_fetch_row()返回NULL。当在mysql_use_result()之后使用时，当没有更多的行可检索时或如果出现一个错误，mysql_fetch_row()返回NULL。</li>
		<li>联合数组：mysqli->fetch_assoc()或mysqli_fetch_assoc()-结果集中取得一行作为关联数组。mysql_fetch_assoc() 和用 mysql_fetch_array() 加上第二个可选参数 MYSQL_ASSOC 完全相同。它仅仅返回关联数组。这也是 mysql_fetch_array() 初始的工作方式。如果在关联索引之外还需要数字索引，用 mysql_fetch_array()。</li>
		<li>对象变量：mysqli->fetch_object()或mysqli_fetch_object()-和 mysql_fetch_array() 类似，只有一点区别——返回一个对象而不是数组。间接地也意味着只能通过字段名来访问数组，而不是偏移量（数字是合法的属性名）。 </li>
	</ul>
</section>
<p>
	mysqli扩展与mysql扩展相比的一个主要优势之一就是预备语句。有两种，一种是执行数据处理的语句，一种是执行数据取回的语句。预备语句可以把PHP的变量直接绑定到数据为输入和输出中。
</p>
<p>预备语句的使用：创建一个查询模板并发送到MySQL服务器。MySQL服务器接收到查询模板后，对其进行验证以确保格式正确，然后进行语义解析，最后存储在一个特殊的缓冲区中。随后MySQL会返回一个特殊的句柄，用来在接下来的操作中指向该预备语句。</p>
<p>对于执行数据处理的查询语句，需要使用？作为占位符，比如SELECT * FROM user WHERE id=?; 以及INSERT INTO user(id,name) VALUES(?,?);。输入变量的过程如下：
<ol>
	<li>预备解析语句</li>
	<li>绑定输入变量</li>
	<li>赋值到绑定的变量</li>
	<li>执行预备语句</li>
</ol>
输出变量的过程如下：
<ol>
	<li>预备解析语句</li>
	<li>执行预备语句</li>
	<li>绑定输出变量</li>
	<li>把数据提取到输出变量中</li>
</ol>
执行一个预备语句或从一个预备语句中获取数据可以重复多次，直到语句结束或者没有更多数据要获取。
</p>
<table>
	<tr><th>函数名</th><th>描述</th></tr>
	<tr><td>mysqli_prepare<br />$mysqli->prepare</td><td>预备执行一个SQL语句</td></tr>
	<tr><td>mysqli_stmt_bind_result<br />$stmt->bind_result</td><td>绑定变量到语句的结果集中</td></tr>
	<tr><td>mysqli_stmt_bind_param<br />$stmt->bind_param</td><td>绑定变量到语句中，需要按顺序指定变量类型：s=string, i=number, d=double, b=blob（二进制数据及大文件，比如JPEG）</td></tr>
	<tr><td>mysqli_stmt_execute<br />stmt->execute</td><td>执行一个语句，参数包函一个语句对象</td></tr>
	<tr><td>mysqli_stmt_fetch<br />stmt->fetch</td><td>获取数据到输出变量中，参数包含一个语句对象</td></tr>
	<tr><td>mysqli_stmt_close<br />stmt->close</td><td>关闭一个预备语句</td></tr>
</table>
<section>
	<h2>SQLite</h2>
	<p>PHP5引入并默认绑定可用。SQLite自成一体，不需要服务器，不需要客户端/服务器模式，内置在应用中，只要能访问到数据库文件即可。用它建立数据库很简单，不需要管理员干预。同时有面向过程和面向对象两种接口。不能处理二进制数据，要存储二进制数据，需要先进行编码。它在处理大量读取查询并少量写入的应用是非常方便的。</p>
	<ul>
		<li>启动数据库：因为SQLite不需要一个守护进程来实现功能，所以启动就是创建起这一个特殊格式的文件。如果你想创创建一个数据库，只需简单打开一个文件，如果文件不存在它会自动创建。</li>
		<li>简单的查询：SQLite只有两种数据类型，INTEGER用来存储数字，将INTEGER设置为PRIMARY KEY可以实现自增加。当然，一个表只能有一个这样的字段。另一种数据类型是不需要指定的，类似于VARCHAR字段。</li>
		<li>错误处理：因为每个查询都可能抛出一个警告，因此在查询函数前最好加上@抑制错误。如果查询失败，可以用sqlite_last_error和sqlite_error_string函数来获取错误的文字描述，虽然这些描述不太清楚。</li>
		<li>触发器：SQLite支持触发器，使用CREATE TIRGER语句定义。</li>
		<li>用户定义函数：SQLite不能执行所有默认的SQL函数，但是它提供了自定义函数的功能。定义好之后就可以在代码中使用了。</li>
	</ul>
	<p>因为SQLite写入里比较慢，所以最好使用事务处理来操作整体的数据导入，而不是一条条的导入。但是在进行事务处理时，会锁定整个数据库。</p>
</section>
<footer>
	<p>没有完整的源代码示例，而且SQLiteDatabase对象已被弃用。感觉这本书有点差劲了。后面的Pear DB是用PHP写的数据库访问层，语法罗嗦，不如内容函数速度快，忽略。</p>
</footer>