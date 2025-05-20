<?php
//SQL Server 接続
//$con=mssql_connect("WPDB03","PHP","Miwa1167");

//$con = sqlsrv_connect("192.168.10.20",array( "UID"=>"wp_sqlserver", "PWD"=>"Hata3123", "Database"=>"WPCT")); //Server,User,password,DB

$con_syokai = sqlsrv_connect("wpagls2022.workport.jp",array( "UID"=>"wp_sqlserver", "PWD"=>"Tenp1379", "Database"=>"SYOKAI")); //Server,User,password,DB
//$con_syokai = sqlsrv_connect("192.168.0.17",array( "UID"=>"wp_sqlserver", "PWD"=>"Tenp1379", "Database"=>"SYOKAI")); //Server,User,password,DB

/*
//WPメンバーリスト、WPグループリスト
$sql="select * from w_t_grow ";
$result=sqlsrv_query($con_wpmain, $sql);

$i = 0;
$row = sqlsrv_fetch_array($result);

echo $row["GRID"];
*/
?>