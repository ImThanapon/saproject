<?php 
    session_start();
    include_once('functions/functions.php'); 
    $userdata = new DB_con();
    if (isset($_POST['login'])) {
        $uname = $_POST['username'];
        $password = md5($_POST['password']);
        $result = $userdata->signin($uname, $password);
        $num = mysqli_fetch_array($result);
        if ($num > 0) {
            $_SESSION['id'] = $num['id'];
            $_SESSION['name'] = $num['name'];
            echo "<script>alert('Login Successful!');</script>";
            echo "<script>window.location.href='admin.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again.');</script>";
            echo "<script>window.location.href='signin.php'</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>



    <div class="pb-4" style="background-image: linear-gradient(to bottom right , #8470FF, #FFB6C1);height:1000px;">
        <div class="container">
            <div class="text-left" style="padding-top:50px; color: white;">
                <div class="row">
                    <div class="col-8">
                        <h1 style="font-size:220px">PermSub <br></h1>
                        <h1 style="font-size:100px; padding-left:10px">Dormitory<br></h1>
                        <h1 style="color:black; padding-left:20px">หอพักเพิ่มทรัพย์</h1>
                        <h2 style="color:black; padding-left:20px">บริการห้องพักให้เช่า ในราคามิตรภาพ</h2>
                        <div style="margin-top:100px;">
                            <a href="register.php" class="mt-5 btn btn-info">ลงทะเบียนผู้พักใหม่ <i
                                    data-feather="user-check" class="mr-2" style="padding:2px;"></i></a>
                            <a href="login.php" class="mt-5 btn btn-dark">เข้าสู่ระบบ <i
                                    data-feather="arrow-right-circle" class="mr-2" style="padding:2px;"></i></a>

                            <div class="row mt-3" style="opacity: 0.9;">
                                <div class="col-5 col-md-2 col-lg-2" style="width:400px;">
                                    <div class="card ">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-2"><img src="img/man.png" style="width:60px;"></div>
                                                <div class="col-10">
                                                    <h5 class="card-title text-dark"><i data-feather="shield"
                                                            class="mr-2"></i>การันตีความปลอดภัย</h5>
                                                    <p class="card-text text-success">ด้วยเจ้าหน้าที่รักษาความปลอดภัย
                                                    </p>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div style="width:400px;">
                                    <div class="card">
                                        <div class="card-body">

                                            <h5 class="card-title text-dark"><i data-feather="heart"
                                                    class="mr-2"></i>อุ่นใจกว่าเดิมด้วยระบบคีย์การ์ด</h5>
                                            <p class="card-text text-danger">เข้าและออกหอพักอย่างปลอดภัย กันผู้คนภายนอก
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-4 text-right">
                        <img src="img/logo.png" style="width:600px;">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer style="text-align: center;">
        <hr>
        <span>Copyright &copy; 2021-2022 <a
                href="https://www.facebook.com/me/">Nack.OSC</a><br>เว็บเพจนี้เป็นส่วนหนึ่งของรายวิชา
            การวิเคราะห์และออกแบบระบบสารสนเทศ Information System Analysis and Design รหัสวิชา 02739323</span>
        <p>จัดทำโดย นายธนพล วิเศษสังข์ รหัสนิสิต 6121600233 เลขที่ 3</p>
    </footer>




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


</html>