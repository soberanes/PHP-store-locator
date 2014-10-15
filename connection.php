<?php
$hostname = 'localhost';
$username = 'root';
$password = 'root';
$dbname   = 'store_locator';

mysql_connect($hostname, $username, $password)
or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
mysql_set_charset('utf8');