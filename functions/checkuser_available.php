<?php 

    include_once('functions.php');

    $usernamecheck = new DB_con();

    // Getting post value
    $uname = $_POST['username'];

    $sql = $usernamecheck->usernameavailable($uname);

    $num = mysqli_num_rows($sql);

    if ($num > 0) {
        echo "<span style='color: red;'>ไม่สามารถใช้ชื่อบัญชีนี้ได้</span>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    } else {
        echo "<span style='color: green;'>สามารถได้ชื่อบัญชีนี้ได้</span>";
        echo "<script>$('#submit').prop('disabled', false);</script>";
    }

?>