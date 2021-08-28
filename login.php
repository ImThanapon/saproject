<?php 
    session_start();
    include_once('functions/functions.php'); 
    $userdata = new DB_con();
    if (isset($_POST['login'])) {
        $uname = $_POST['username'];
        $password = md5($_POST['password']);

        if($uname =='admin'){
            $result = $userdata->admin_signin($uname, $password);
        }else{
            $result = $userdata->signin($uname, $password);
        }
        

        $num = mysqli_fetch_array($result);
        
        if ($num > 0) {
            $_SESSION['user_id'] = $num['user_id'];
            $_SESSION['name'] = $num['name'];
            $_SESSION['status'] = $num['status'];
            $_SESSION['img_profile'] = $num['image'];

            if( $_SESSION['status'] =='user'){

                $_SESSION['room'] = $num['room_id'];
                $_SESSION['check_in'] = $num['check_in'];
                $_SESSION['phone'] = $num['phone'];
                $_SESSION['id_card'] = $num['id_card'];
                $_SESSION['line'] = $num['line'];
                
                if(!empty($num['invoice_id'])){
                    $result = $userdata->member_detail($uname, $password);
                    $num = mysqli_fetch_array($result);
                    if(!empty($num)){
                        $_SESSION['water_unit'] = $num['water_unit'];
                        $_SESSION['electric_unit'] = $num['electric_unit'];
                        $_SESSION['rent'] = $num['rent'];
                        $_SESSION['total'] = $num['total'];
                        $_SESSION['invoice_id'] = $num['invoice_id'];
                        $_SESSION['invoice_time'] = $num['invoice_time'];
                        $_SESSION['receipt_id'] = $num['receipt_id'];
                        $_SESSION['receipt_time'] = $num['receipt_time'];  
                        $_SESSION['water_price'] = 17 * $_SESSION['water_unit'];
                        $_SESSION['electric_price'] = 17 * $_SESSION['electric_unit'];
                    }
                   
                }else{
                    $_SESSION['water_unit'] = 0;
                    $_SESSION['electric_unit'] = 0;
                    $_SESSION['rent'] = 0;
                    $_SESSION['total'] = 0;
                    $_SESSION['invoice_id'] = 'no_data';
                    $_SESSION['invoice_time'] = 'no_data';
                    $_SESSION['receipt_id'] = 'no_data';
                    $_SESSION['receipt_time'] = 'no_data';  
                    $_SESSION['water_price'] = 17 * $_SESSION['water_unit'];
                    $_SESSION['electric_price'] = 17 * $_SESSION['electric_unit'];
                }
                

                echo "<script>alert('Login Successful!');</script>";
                echo "<script>window.location.href='welcome.php'</script>";
            }elseif($_SESSION['status'] =='admin'){
                echo "<script>alert('Login Successful!');</script>";
                echo "<script>window.location.href='admin.php'</script>";
            }
        } else {
            echo "<script>alert('Something went wrong! Please try again.');</script>";
            echo "<script>window.location.href='login.php'</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
    <div class="bg-set pt-1 font-set">
        <div class="form-log">
            <div class=" " style="border-radius: 15px;">
                <div class="" style="text-align: center;">
                    <!-- <i style="width:250px;" class="text-white" data-feather="box"></i> -->
                    <img class="mb-3" src="img/logo.png" style="width:300px;">
                    <h2 class="mb-3 pt-2 pb-2 text-white shadow-set">ระบบสมาชิกหอพักเพิ่มทรัพย์</h2>
                </div>
                <form method="post">
                    <div class="">
                        <!-- <h5 class=""><i data-feather="user" class="mr-2"></i>Username</h5> -->
                        <input type="text" class="form-control form-control-lg" id="username" name="username"
                            placeholder="username / กรอกบัญชีผู้ใช้" required>
                        <span id="usernameavailable"></span>
                        <br>
                        <!-- <h5 class=""><i data-feather="key" class="mr-2"></i>Password</h5> -->

                        <input type="password" class="form-control form-control-lg" id="password" name="password"
                            placeholder="password / กรอกรหัสผ่าน" required>
                        <div class="mt-3" style="text-align: center;">
                            <button type="submit" name="login" class="btn btn-info" style="">เข้าสู่ระบบ <i
                                    data-feather="arrow-right-circle" class="mr-2" style="padding:2px;"></i></button>
                            <a href="register.php" class="btn btn-dark">ลงทะเบียนผู้พักใหม่ <i
                                    data-feather="arrow-right-circle" class="mr-2" style="padding:2px;"></i></a>
                        </div>
                        <!-- <div class="text-center">
                            <h5 class="mt-3">User</h5>
                            <span>Username : user</span><br>
                            <span>Password : 1234</span>
                            
                            <h5 class="mt-3">Admin</h5>
                            <span>Username : admin</span><br>
                            <span>Password : 1234</span>
                        </div> -->

                        <!-- <hr>
                        <div class="mt-3" style="text-align: center;">
                            ไปที่หน้า
                            <a href="index.php" style="color: grey;">Home Page </i></a>
                        </div> -->
                    </div>
                </form>

            </div>
        </div>

    </div>


    <script>
    feather.replace()
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
</body>
<footer class="text-center" style="padding-top:15px;">
    <span>Copyright &copy; 2021-2022 <a
            href="https://www.facebook.com/me/">Nack.OSC</a><br>เว็บเพจนี้เป็นส่วนหนึ่งของรายวิชา
        การวิเคราะห์และออกแบบระบบสารสนเทศ Information System Analysis and Design รหัสวิชา 02739323</span>
    <p>จัดทำโดย นายธนพล วิเศษสังข์ รหัสนิสิต 6121600233 เลขที่ 3</p>
</footer>

</html>