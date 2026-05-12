<?PHP

$host="localhost";
$user_sql="root";
$pass_sql="";
$db="halfday";
$condb=mysqli_connect($host,$user_sql,$pass_sql,$db);

if (!$condb) {
    die("Connection failed: " . mysqli_connect_error());
}
?>