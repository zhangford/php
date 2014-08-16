<?php
/**
 * 这一章练习文件上传
 *
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-15
 * Time: 上午10:15
 */

/**
 * 处理文件上传的配置
 */
$max_file_size = 50000;	//假设这个值等于php.ini中设置的值
$upload_required = true;
$upload_page = './chapter5.php';
$upload_dir = '/srv/www/htdocs/php/images/';
$error_message = false;

//借用一直do...while循环作一个简易goto，最后设置while(0)，因此这个循环只能执行一次

do
{
	if(!isset($_FILES['book_image']))
	{
		$error_message = '没有所需的表单数据提交！';
		break;	//中断while
	}
	else
	{
		$book_image = $_FILES['book_image'];
	}

	//检查所有错误号
	switch($book_image['error'])
	{
		case UPLOAD_ERR_INI_SIZE:
			$error_message = '文件大小超过了配置文件的上限'.$max_file_size.'Byte';
			break 2;	//跳出switch和while
		case UPLOAD_ERR_PARTIAL:
			$error_message = '文件上传出错！';
			break 2;
		case UPLOAD_ERR_NO_FILE:
			$error_message = '没有选择上传图片，如需上传<a href='.$upload_page.'>点击此处</a>';
			break 2;
		case UPLOAD_ERR_FORM_SIZE:
			$error_message = '文件大于表单预设值！';
		case UPLOAD_ERR_OK:
			if($book_image['size'] > $max_file_size)
			{
				$error_message = '文件太大了，它不能大于'.$max_file_size.'字节';
			}
			break 2;
		default:
			$error_message = '发生了未知错误，<a href='.$upload_page.'>请重试</a>';

	}

	//检查文件类型
	if(!in_array($book_image['type'], array('image/jpeg', 'image/pjpeg', 'image/png')))
	{
		$error_message = "只能接受JPEG/PNG文件";
		break;
	}

}while(0);

//如果没有错误出现，移动文件到上传目录中
if(!$error_message)
{
	if(!@move_uploaded_file($book_image['tmp_name'], $upload_dir.$book_image['name']))
	{
		$error_message = '保存文件时出错！';
	}
}

if($error_message)
{
	echo $error_message;
}
else
{
	echo "<img src=images/".$book_image['name']." />";
}


?>
<header>
	<h1>如何用PHP写一个Web应用</h1>
</header>
<p>在编程中也要尽量注意，将内容与逻辑分离。将内容文本以及输出的判断，单独存放在变量之中，在页面显示部分只填写变量即可。</p>
<p>$_REQUEST数组包括了$_GET、$_POST和$_COOKIE几个数组中的所有元素，如果这几个数组中有重名元素，那么$_REQUEST数组将按将php.ini文件中指定的顺序对其进行重写，默认顺序是EGPCS，用后面出现的变量数据覆盖前面的。其中G代表$_GET，C代表$_COOKIE，P代表$_POST，E代表$_ENV，S代表$_SERVER。</p>
<p>由于Cookie是容易伪造的，因此除非确有必要在本地存储数据，否则，还是使用sessions好。</p>
<p>session ID可以传递到cookie中或是添加到URL中来跨越网站应用，如果确有必要，将它保存在cookie中要好于用URL传递（会被监听）。因此，最好在调用session_start()之前，执行ini_set('session.use_cookies',1); ini_set('session.use_only_cookies',0);后者设置为1则会在用户没有打开cookie时提示打开，强制使用cookie，没必要。</p>
<p>可以在执行session_start()之前用session_name('NAME')来修改session ID在cookie中的名字，默认为PHP_SESSID。在用session_destroy()注销会话和它的相关数据之前，用$_SESSION = array()来清空SESSION是必要的。</p>
<p>文件上传，只比POST复杂一点。它的form属性中多了一项:enctype="multipart/form-data"。</p>
<form enctype="multipart/form-data" action="./chapter5.php" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="1600000" />
	上传文件<input name="book_image" type="file" />
	<br />
	<input type="submit" value="上传" />
</form>
<p>$_FILES数组以2维数组的形式包含了每一个上传文件的信息，处理脚本可以通过上传文件的名字作为关键字来访问这些信息。如本例中的$_FILES['book_image']，它的数组二维元素包括name-文件上传前的原始名称（string（8）），type-文件类型，tmp_name-在服务器中的临时文件名，上传结束后会自动删除，error错误号（见下面列表），size-文件大小。</p>
<table>
	<tr><th>值</th><th>常量</th><th>说明</th></tr>
	<tr><td>0</td><td>UPLOAD_ERR_OK</td><td>文件上传成功且没有错误发生</td></tr>
	<tr><td>1</td><td>UPLOAD_ERR_INI_SIZE</td><td>上传文件大小超过了php.ini中设置的值</td></tr>
	<tr><td>2</td><td>UPLOAD_ERR_FROM_SIZE</td><td>上传文件大小超过了表单中的特殊表单项MAX_FILE_SIZE设置的值,因为这个值可被伪装，所以不建议使用</td></tr>
	<tr><td>3</td><td>UPLOAD_ERR_PARTIAL</td><td>只接收到部分内容，所以上传有问题</td></tr>
	<tr><td>4</td><td>UPLOAD_ERR_NO_FILE</td><td>根本没有文件上传，因为用户没有选择文件，由于这个选项不是必填项，因此可不算错误，用来检查用户是否选择了上传文件是不错的</td></tr>
</table>
<p>在php.ini文件中有几个与上传相关配置：upload_max_filesize-上传文件最大值，默认为2MB；post_max_size-一个POST请求鸡许的最大数据量，默认为8MB；file_uploads,确定脚本是否可以使用远程文件的名字，默认是开启；upload_tmp_dir-文件上传后的临时目录，默认为系统的临时文件目录tmp。</p>
<p>把所有代码放到一个文件中是不明智的，但是可以根据请求参数不同，用一个文件做跳转，当然这要在跳转数目较少的情况下。应当要用每个脚本只负责一项功能的方式来架构应用程序，这样代码便于维护。</p>
<p>除上述两种方式外，还有一种逻辑与显示分离的方式，这也是大多数框架中采用的方式。即先将页面的框架（静态部分）定义好，有内容的地方（动态部分）用变量补充，形成了所谓的tpl文件。这个每个部分只需要将里面的变量值先运算完成，最后用include引入tpl文件即可。<a href='./template.tpl'>tpl文件示例</a></p>
<footer><p>这一章，很多地方用到数组，而且最后用数组实现的模板代码不好理解，实现的功能却很简单。不用也罢。</p></footer>

