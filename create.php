<?php
/**
 * SQLite的示例，用面向对象方式
 * 在PHP 5.4中已经弃用了SQLiteDatabase对象，改用SQLite3
 *
 * Created by PhpStorm.
 * User: ford
 * Date: 14-8-19
 * Time: 上午9:55
 */
//$db = new SQLiteDatabase("./images/crm.db", 0666) or die("Failed: $error");	//crm.db数据库文件名，不存在将创建一个，0666文件的访问权限，同unix系统，$error错误信息，要通过引用传递
$db = new SQLite3('./images/crm.db');	//SQLite3不需要后面那几个参数

//创建数据表
$create_query = "
	CREATE TABLE document(int INTEGER PRIMARY KEY, title, intro, body);
	CREATE TABLE dictionary(id INTEGER PRIMARY KEY, word);
	CREATE TABLE lookup(document_id INTEGER, word_id INTEGER, position INTEGER);
	CREATE UNIQUE INDEX word ON dictionary(word);
	";

//执行查询
$db->query($create_query);
unset($db);