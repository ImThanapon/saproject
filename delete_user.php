<?php

define('DB_SERVER', 'localhost'); // Your hostname
define('DB_USER', 'root'); // Database Username
define('DB_PASS', ''); // Database Password
define('DB_NAME', 'sa_project'); // Database Name
$connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$user_id = $_GET['id'];

$res = mysqli_query($connect, 
"UPDATE users 
set 
username = '',
password = '',
name = '',
phone = '',
line = '',
email = '' ,
address = '',
id_card = '' ,
image = '',
check_in = '0000-00-00'
WHERE user_id = '$user_id' ");
if(!empty($res)){
    echo "<script>alert('ลบบัญชีผู้ใช้สำเร็จ');</script>";
    echo "<script>window.location.href='welcome_admin.php'</script>";
}

?>