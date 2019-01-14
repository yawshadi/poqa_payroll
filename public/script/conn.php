<?php

$con = mysql_connect('localhost','root','')  or throw new frameworkError('Could not connect to the server!');
 
// Select a database:
mysql_select_db('marketplace')  or throw new frameworkError('Could not select a database.');

?>