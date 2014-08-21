<?php
/**
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-19
 * Time: 下午4:34
 */
?>
<header>
	<h1>PHP5处理XML</h1>
</header>
<p>使用PHP来读取和传输XML文档，使用XML作为与远程服务通讯的协议。W3C提供了<a href="http://validator.w3.org/">检查文档是否是合适的XML或HTML的页面</a>。</p>
<p>PHP有两种解析XML的工具SAX（Simple API for XML，解析整个XML文档，并遍历其中每个开始和结束标记或者其他元素的事件。）和DOM（Document Object Model，把整个文档解析为一个树形结构，并且可以用PHP中的函数来遍历）。PHP5提供了另外一种解析方法-SimpleXML。</p>
<p>下面是示例源代码：</p>
<pre>
<?php
//创建XML解析器对象，可选参数定义的是解析时所使用的编码，执行成功时将返回一个XML解析处理器以便使用所有其他XML解析函数
$xml = xml_parser_create('utf-8');

//因为SAX是通过处理事件工作的，所以需要启动处理器。这个例子中有两人个最重要的处理器，一个是针对开始和结束标记，另一个是针对字符数据
//下面这两条语句来启动上述两个处理器，但它们必须在任何动作发生前执行。
xml_set_element_handler($xml, 'start_handler', 'end_handler');		//后面的两个参数是处理器函数名称，下面，我们自己定义处理器函数
xml_set_character_data_handler($xml, 'character_handler');

/**
 * 自定义的开始标记处理器函数
 *
 * @param $xml XML解析器对象
 * @param $tag 标记的名字
 * @param $attributes 为标记定义的属性
 */
function start_handler($xml, $tag, $attributes)
{
	global $level;

	echo "\n".str_repeat(' ', $level).'&gt;&gt;&gt;'.$tag;
	foreach($attributes as $key => $value)
	{
		echo " $key $value";
	}

	$level++;
}

/**
 * 自定义的结束标记处理器函数
 *
 * @param $xml XML解析器对象
 * @param $tag 对象标记名
 */
function end_handler($xml, $tag)
{
	global $level;

	$level--;
	echo str_repeat(' ', $level)."&lt;&lt;&lt;$tag";
}

//为了让脚本有效工作，需要执行字符处理器来显示所有的内容，下面定义字符处理器函数

/**
 * 字符处理器函数
 * @param $xml XML解析器对象
 * @param $data 要解析的数据
 */
function character_handler($xml, $data)
{
	global $level;

	$data = split("\n", wordwrap($data, 76 - $level*2));
	foreach($data as $line)
	{
		echo str_repeat(' ',$level + 1).$line."\n";
	}
}
//下面这行关闭大小写折叠（标记全用大写）
xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, false);

//执行了所有的处理器后，就可以开始解析XML了
xml_parse($xml, file_get_contents('index.php'));

?>
</pre>
<p>上面这个结果看起来很难看，因为字符数据处理器是针对对数据的每一个比特调用的，所以有许多空白。可以通过把所有数据放到缓冲区来改进这个结果，并且只在标记结束或新新标记开始时才输出数据。下面是新的输出<em>(注意，下面没有关闭大小写折叠，所以全用大写输出)</em>：</p>
<pre>
<?php
//初始化变量
$level = 0;
$char_data = '';

//创建解析器句柄
$xml = xml_parser_create('utf-8');

//设置处理器
xml_set_element_handler($xml, 'begin_handler', 'finish_handler');
xml_set_character_data_handler($xml, 'char_handler');

//开始在一次执行中解析整个文件
xml_parse($xml, file_get_contents('index.php'));

/**
 * 处理器函数
 */
/**
 * 缓冲区输出函数，这里用到了全局变量
 */
function flush_data()
{
	global $level, $char_data;
	//当存在数据时，修正数据并输出
	$char_data = trim($char_data);
	if(strlen($char_data) > 0)
	{
		echo "\n";
		//下面开始输出
		$data = split("\n", wordwrap($char_data, 76-$level*2));
		foreach($data as $line)
		{
			echo str_repeat(' ', $level + 1)."[$line]\n";
		}
	}

	//清除缓冲区中的数据
	$char_data = '';
}

/**
 * 开始标记的处理器
 * @param $xml XML解析器句柄
 * @param $tag 对象标记名
 * @param $attributes 为标记定义的属性
 */
function begin_handler($xml, $tag, $attributes)
{
	global $level;

	//从字符处理器中清空收集的数据
	flush_data();

	//把属性改为一个字符串，然后输出
	echo "\n".str_repeat(' ', $level).$tag;
	foreach($attributes as $key => $value)
	{
		echo " $key='$value'";
	}

	//提高缩百级别
	$level++;
}

function finish_handler($xml, $tag)
{
	global $level;

	//从字符处理器中清空收集的数据
	flush_data();
	//减少缩进量
	$level--;
	echo "\n".str_repeat(' ',$level)."/$tag";
}

function char_handler($xml, $data)
{
	global $level, $char_data;
	//增加字符处理器到缓冲区中
	$char_data .= ' '.$data;
}
?>
</pre>
<p>使用DOM比SAX要简单的多，但是要付出内存。因为DOM会在内存中建立一个包含XML文件结构树。下面是使用DOM的例子（这个示例执行失败，里面没有更详细说明，当前JSON比XML更简单实用，暂时略过）。</p>
<pre>
<?php
$dom = new DOMDocument();
$dom->load('muscadine.xml');
$root = $dom->documentElement;

process_children($root);

/**
 * 这个函数使用了递归调用，遍历全部结点
 *
 * @param $node
 */
function process_children($node)
{
	$children = $node->childNodes;

	foreach($children as $elem)
	{
		if($elem->nodeType == XML_TEXT_NODE)
		{
			if(strlen(trim($elem->nodeValue)))
			{
				echo trim($elem->nodeValue)."\n";

			}
			elseif($elem->nodeType == XML_ELEMENT_NODE)
			{
				if($elem->nodeName == 'body')
				{
					echo $elem->getAttributeNode('background')->value."\n";
				}
				process_children($elem);
			}
		}
	}
}
?>
</pre>
<p>还可以使用DOM来创建一个XML文档</p>
<?php
$dom = new DOMDocument();

//创建html元素
$html = $dom->createElement('html'); 	//所有元素都是通过调用createElement方法创建的
echo "\n";
$html->setAttribute("xmlnx", "http://www.w3.org/1999/xhtml");
$html->setAttribute("xml:lang", "en");
$html->setAttribute("lang", "en");
$dom->appendChild($html);
echo "\n";

//创建head元素，注意元素的创建顺序和嵌套关系
$head = $dom->createElement('head');
$html->appendChild($head);
echo "\n";
$title = $dom->createElement('title');
$title->appendChild($dom->createTextNode("XML Example"));
$head->appendChild($title);

echo "\n";
//创建body元素
$body = $dom->createElement('body');
$body->setAttribute('background', 'bg.png');
$html->appendChild($body);
//创建p元素
$p = $dom->createElement('p');
$body->appendChild($p);

//P元素的内容比复杂一些，要按元素顺序一一写入
//添加文字
$text = $dom->createTextNode('Moved to');
$p->appendChild($text);
//增加A元素
$a = $dom->createElement('a');
$a->setAttribute('href', 'http://example.org');
$a->appendChild($dom->createTextNode('example.org'));	//注意这行
$p->appendChild($a);

$text = $dom->createTextNode('.');
$p->appendChild($text);
$br = $dom->createElement('br');
$p->appendChild($br);
$text = $dom->createTextNode('foo & bar');
$p->appendChild($text);

echo $dom->saveXML();
?>
<p>SimpleXML是处理XML最简单的方法，PHP5中默认开启，只需要以数据结构形式来访问即可。它有四个简单规则：</p>
<ol>
	<li>属性表示元素的迭代器：表示你可以循环body中的所有p标记</li>
	<li>数字索引表示元素：比如，你可以这样访问body中的第2个p标签$sx->body->p[1]</li>
	<li>非数字索引表示属性：你可以这样访问body的背景$sx->body['background']</li>
	<li>允许用字符串转换访问XML文件中所有的数据：表示你可以从元素中访问所有的文本数据，但是不包括其子元素的，如果想要显示子元素的内容可以加入asXML()方法，比如$sx->body->p[1]->asXML();</li>
</ol>
<p>创建SimpleXML对象有三种方式：
	<ol>
		<li>使用simplexml_load_file()函数直接载入XML文档并赋值给变量。比如：$sxl = simplexml_load_file('test.xml')</li>
		<li>使用simplexml_load_string()函数从字符串变量中载入XML文档并赋值给变量</li>
		<li>使用simplexml_load_dom()导入一个用PHP DOM函数创建的DomDocument对象。</li>
	</ol>
如果想遍历body节点所有的子元素，可以使用children()方法。比如：foreach($sx->body->children() as $element)。如果想遍历一个元素所有属性的话则使用attributtes()方法，比如：foreach($sx->body->p[0]->attributes() as $attribute).
保存xml文件的方法如下：file_put_contents('filename.xml', $sx2->asXML)。
</p>

<footer>
	<p>这一章讲的XML还有点用处，但是不详细。后面说的SOAP没有说清楚这东西是什么，为什么要用这东西，能实现什么。</p>
</footer>