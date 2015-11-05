<?php
header('Content-Type: text/html;charset=utf-8');

//$name = '状态';
$name = '状态@radio';
$name = '状态@radio|1=是&0=否';

preg_match("/(.*)@([a-z]*)\|?(.*)/",$name,$result);

echo '<pre>';
var_dump($result);

