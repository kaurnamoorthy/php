<?php
// mysql credentials
$host = "localhost";
$user = "username";
$pass = "password";
$dbname="dbname";
//get path to mysql dump utility
//$dump_path = "C:\\xampp\mysql\\bin\\";
$row = mysqli_fetch_array(mysqli_query(mysqli_connect($host, $user, $pass, $dbname), "select @@datadir as mydir;"),MYSQLI_ASSOC);  
$dump_path =  str_replace("data","bin",$row["mydir"]);
//echo $dump_path;
//exit;

//get location to store backups
$save_path = realpath(dirname(__FILE__)) . "\\BACKUP\\"; 
//echo $save_path;
//exit;

// mysql connection
mysql_connect( $host , $user , $pass );

// format dir name
$today = date("Y-m-d");

//check if directory exists otherwise create it
if ( !file_exists ( is_dir ($save_path ) ) )
{
   // mkdir( $save_path . $today );
}

// list all mysql dbs
$result = mysql_list_dbs();

// init counter var
$i = 0;

// list all databases in mysql
while ( $i < mysql_num_rows ( $result ) )
{
    $tb_names[$i] = mysql_tablename ( $result, $i );
       $i++;
}

// loop through table names and do the dump
for ( $i=0; $i<count($tb_names); $i++ )
{
    $do = $dump_path . "mysqldump -h " . $host . " -u " . $user . " -p" . $pass . " --opt " . $tb_names[$i] . " > " . $save_path .  $today . ".sql";

	if($tb_names[$i]==$dbname) 
{
//echo  $do;
   // echo $do;
	passthru($do,$result);
}
}
echo "Dump created successfully". "<!--a href=https://mydomain/" .  $today .  ".sql".">&nbsp;&nbsp;Download</a-->"

?>