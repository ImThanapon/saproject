<?php 
    include_once('functions/functions.php'); 
    $userdata = new DB_con();
    if (isset($_POST['submit'])) {

        $name = $_POST['name'];
        $username = $_POST['username'];
        $line = $_POST['line'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $check_in = $_POST['check-in'];
        $room = $_POST['room'];
        $address = $_POST['address'];
        $id_card = $_POST['card'];
        $ext = end(explode(".",$_FILES['upload']['name']));
        $filename = md5(uniqid()).".".$ext;
        $avatar = "member/img_profile/".$filename;
        echo $_FILES['upload']['tmp_name'];
        move_uploaded_file($_FILES['upload']['tmp_name'],$avatar);
        $path_img_person =  $avatar;

        if($_POST['password'] != $_POST['check_password']) {
            echo "<script>alert('กรุณากรอกรหัสผ่านให้ตรงกัน');</script>";
        }else{
            $password = md5($_POST['password']);
            $sql = $userdata->registration($name, $line, $phone, $email, $username, $password, $path_img_person, $room, $check_in, $address, $id_card);
            if ($sql) {
                // echo $sql;
                echo "<script>alert('สมัครสมาชิกสำเร็จ / Registor Successful!');</script>";
                echo "<script>window.location.href='login.php'</script>";
            } else {
                echo "<script>alert('Something went wrong! Please try again.');</script>";
                //echo "<script>window.location.href='signin.php'</script>";
            }
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-latest.js"></script>

    <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#show_img_profile').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</head>

<body class="font-set">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="text-start">
                <div class="row">
                    <div class="col">
                        <img class="mb-3" src="img/logo.png" style="width:90px;">
                    </div>
                    <div class="col">
                        <h1 class="display-4">PermSub</h1>
                        <hr class="mt-0 mb-0">
                        <h5>ระบบจัดการหอพักเพิ่มทรัพย์</h5>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-index font-set pt-4 pb-4">
        <div class="card shadow-set" style="border-radius: 15px;margin:auto; width:60%;">
            <div class="card-body">
                <form name="reg_form" method="post" enctype=multipart/form-data>
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><strong>ส่วนที่ 1 : ข้อมูลส่วนตัว</strong></h5>
                                </div>
                            </div>
                            <div class="mt-2 mb-2 mr-2 ml-2">
                                <div class="mt-3">
                                    <label for="fullname" class="form-label">ชื่อผู้พักอาศัย / Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="นาย/นาง/นางสาว ชื่อ-นามสกุล" required>
                                </div>
                                <div class="mt-2">
                                    <label for="fullname" class="form-label">หมายเลขประจำตัวประชาชน 13 หลัก</label>
                                    <input type="text" class="form-control" id="card" name="card"
                                        placeholder="กรอกหมายเลขประจำตัวประชาชน 13 หลัก" maxlength="13" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mt-2">
                                            <label for="fullname" class="form-label">หมายเลขโทรศัพท์ / Telephone</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="06X-XXX-XXXX" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mt-2">
                                            <label class="form-label">ไลน์ไอดี / Line ID</label>
                                            <input type="text" class="form-control" id="line" name="line"
                                                placeholder="กรอก Line ID" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-2">
                                    <label class="form-label">อีเมล / Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="กรอก Email" required>
                                </div>
                                <div class="mt-2">
                                    <label class="form-label">ที่อยู่ตามทะเบียนบ้าน / Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="บ้านเลขที่ หมู่ ตำบล อำเภอ จังหวัด รหัสไปรษณีย์ " required>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><strong>ส่วนที่ 2 : บัญชีผู้ใช้งาน</strong></h5>
                                </div>
                            </div>

                            <div class="mt-2 mb-2 mr-2 ml-2">
                                <div class="mt-3">
                                    <label for="username" class="form-label">ชื่อผู้ใช้ / Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        onblur="checkusername(this.value)" placeholder="Username / กรอกบัญชีผู้ใช้"
                                        required>
                                    <span id="usernameavailable"></span>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mt-2">
                                            <label for="password" class="form-label">รหัสผ่าน / Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password / กำหนดรหัสผ่าน" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mt-2 mb-2">
                                            <label for="password" class="form-label">ยืนยันรหัสผ่าน /Password
                                                Again</label>
                                            <input type="password" class="form-control" id="check_password"
                                                name="check_password" placeholder="Password Again / iหัสผ่านอีกครั้ง"
                                                required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5><strong>ส่วนที่ 3 : ข้อมูลห้องพัก</strong></h5>
                                </div>
                            </div>
                            <div class="mt-2 mb-2 mr-2 ml-2">
                                <div class="mt-1">

                                    <label label class="form-label">หมายเลขห้องพัก / Room Number</label>
                                    <select class="form-select" name="room" id="room">
                                        <?php
                                            if($_GET['room_id']){ ?>
                                        <option selected value="<?php echo $_GET['room_id']; ?>" selected >
                                            <?php echo $_GET['room_id']; ?></option>
                                        <?php 
                                            }else{
                                            ?>
                                        <option selected>กรุณาเลือกห้องพัก</option>
                                        <option value="101">101</option>
                                        <option value="102">102</option>
                                        <option value="103">103</option>
                                        <option value="104">104</option>
                                        <option value="105">105</option>
                                        <option value="106">106</option>
                                        <option value="107">107</option>
                                        <option value="108">108</option>
                                        <option value="109">109</option>
                                        <option value="110">110</option>
                                        <?php }?>
                                    </select>
                                </div>


                                <div class="mt-2">
                                    <label for="check-in" class="form-label">วันที่เข้าพัก / Check-in Date</label>
                                    <input class="form-control" type="date" id="check-in" name="check-in" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center " style="margin:auto;width:300px;">
                        <br>
                        <img class="mb-3 border" id="show_img_profile" src="img/preprofile.png"
                            style="height: 150px;"><br>
                        <label for="upload" class="form-label">คำแนะนำ : ไฟล์ .png .jpg ขนาด 200x200 pixels</label><br>
                        <input type="file" class="mb-3 form-control text-right" id="upload" name="upload"
                            onchange="readURL(this);" required>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                            <button type="submit" name="submit" id="submit" class="btn btn-success">กดเพื่อสมัครสมาชิก /
                                Register</button>
                        </div>
                        <div class="col">
                            <input type="reset" class="btn btn-danger" value="ล้างข้อมูล / Reset">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    function checkusername(val) {
        $.ajax({
            type: 'POST',
            url: 'functions/checkuser_available.php',
            data: 'username=' + val,
            success: function(data) {
                $('#usernameavailable').html(data);
            }
        });
    }
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