<?php 

    session_start();

    if ($_SESSION['user_id'] == "" || $_SESSION['status'] == "user" ) {
        header("location: welcome.php");
    }  else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        $result = $userdata->edit_profile($_GET['id']);
        $row =  mysqli_fetch_assoc($result);
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $id_card = $_POST['card'];
            $phone = $_POST['phone'];
            $line = $_POST['line'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $check_in = $_POST['check-in'];
            $room = $_POST['room'];
            $updated = $userdata->update($_GET['id'], $name, $id_card, $phone, $line, $email, $address, $room, $check_in);
            if ($updated) {
                echo "<script>alert('แก้ไขข้อมูลสำเร็จ / Update Successful!');</script>";
                echo "<script>window.location.href='welcome_admin.php'</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด !');</script>";
                //echo "<script>window.location.href='signin.php'</script>";
            }
            
        }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="style.css" type="text/css">

    <style>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .sidebar {
            top: 11.5rem;
            padding: 0;
        }
    }

    .navbar {
        box-shadow: inset 0-1px 0 0 rgba(0, 0, 0, 0.1);
    }

    @media (min-width: 768px) {
        .navbar {
            top: 0;
            position: sticky;
            z-index: 999;
        }
    }

    .sidebar .nav-link {
        color: #333;
    }

    .sidebar .nav-link.active {
        color: #0d6efd;
    }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
</head>

<body class="font-set bg-set">
    
    <nav class="navbar navbar-light bg-light" style="opacity: 0.9;">
        <div class="container">
            <div class="row" style="opacity: 2;">
                <div class="col text-left mt-3">
                    <div class="row">
                        <div class="col-2">
                            <img class="mb-3" src="img/logo.png" style="width:100px;">
                        </div>
                        <div class="col">
                            <h3 class="display-3">PermSub</h3>
                            <h5>ระบบจัดการหอพักเพิ่มทรัพย์</h5>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col" style="text-align: right;">
                    <h4>ผู้ดูแลระบบ - Admin</h4>
                    <h6>ชื่อ : <?php echo $_SESSION['name']; ?></h6>
                    <span>สถานะ : <div class="spinner-grow spinner-grow-sm text-success" role="status"></div><span
                            color="success"> ปกติ </span></span>
                    <hr>
                    <a href="admin.php" class="btn btn-primary rounded-pill">หน้าหลัก</a>
                    <a href="input_unit.php?id=1" class="btn btn-warning rounded-pill">กรอกมาตรน้ำ-ไฟ</a>
                    <a href="welcome_admin.php" class="btn btn-info rounded-pill">จัดการห้องพัก</a>
                    <a href="logout.php" class="btn btn-danger rounded-pill">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-set font-set pt-4">
        <div class="shadow-set " style="margin:auto; width:70%;">
            <div class="card" style="border-radius: 15px;">
                <div class="card-body">
                    <form name="reg_form" method="post" enctype=multipart/form-data>
                        <div class="row">
                            <div class="col-8">
                                <div class="mt-3 card">
                                    <div class="card-header">
                                        <h5><strong>ส่วนที่ 1 : ข้อมูลส่วนตัว</strong></h5>
                                    </div>
                                </div>
                                <div class="mt-2 mb-2 mr-2 ml-2">
                                    <div class="mt-3">
                                        <label for="fullname" class="form-label">ชื่อผู้พักอาศัย / Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="นาย/นาง/นางสาว ชื่อ-นามสกุล"
                                            value="<?php echo $row["name"]; ?>" maxlength="50" required>
                                    </div>
                                    <div class="mt-2">
                                        <label for="fullname" class="form-label">หมายเลขประจำตัวประชาชน 13 หลัก</label>
                                        <input type="text" class="form-control" id="card" name="card"
                                            placeholder="กรอกหมายเลขประจำตัวประชาชน 13 หลัก"
                                            value="<?php echo $row["id_card"]; ?>" maxlength="13" required>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mt-2">
                                                <label for="fullname" class="form-label">หมายเลขโทรศัพท์ /
                                                    Telephone</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    placeholder="06X-XXX-XXXX" value="<?php echo $row["phone"]; ?>"
                                                    maxlength="10" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mt-2">
                                                <label class="form-label">ไลน์ไอดี / Line ID</label>
                                                <input type="text" class="form-control" id="line" name="line"
                                                    placeholder="กรอก Line ID" value="<?php echo $row["line"]; ?>"
                                                    maxlength="50" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">อีเมล / Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="กรอก Email" value="<?php echo $row["email"]; ?>" maxlength="50"
                                            required>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">ที่อยู่ตามทะเบียนบ้าน / Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="บ้านเลขที่ หมู่ ตำบล อำเภอ จังหวัด รหัสไปรษณีย์ "
                                            value="<?php echo $row["address"]; ?>" maxlength="100" required>
                                    </div>

                                    <div class="mt-1">
                                        <label   label class="form-label">หมายเลขห้องพัก / Room Number</label>
                                        
                                        <select class="form-select" name="room" id="room">                                            
                                            <option value="<?php echo $row["room_id"]; ?>" selected><?php echo $row["room_id"]; ?></option>
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
                                        </select>
                                    </div>

                                    <div class="mt-2">
                                    <label for="check-in" class="form-label">วันที่เข้าพัก / Check-in Date</label>
                                    <input class="form-control" type="date" id="check-in" name="check-in" required>
                                </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mt-3 card">
                                    <div class="card-header">
                                        <h5><strong>รูปประจำตัว / Profile Image</strong></h5>
                                    </div>
                                    
                                </div>
                                    <div class="mt-5 text-center">
                                        <?php  
                                        if(empty($row['image'])){ ?>
                                        <img src="img/preprofile.png" alt="" style="height:400px; width:400px;">
                                        <?php }else{
                                            ?>
                                        <img class="border border-5 rounded-pill shadow-lg p-2 mb-5 bg-body rounded" src="<?php echo $row['image']; ?>" alt=""
                                            style="height: 300px; width:300px;">
                                        <?php
                                        } ?>
                                    </div>
                            </div>
                        </div>
                        <div class="text-center " style="margin:auto;width:300px;">
                            <br>
                            <button type="submit" name="submit" id="submit" class="btn btn-warning btn-lg">แก้ไขข้อมูล</button>
                            <a href="welcome_admin.php" type="submit" name="submit" id="submit"
                                class="btn btn-danger btn-lg">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
</body>
<footer class="text-center pb-2 mt-2" style="padding-top:15px;background-color: white;">
    <span>Copyright &copy; 2021-2022 <a
            href="https://www.facebook.com/me/">Nack.OSC</a><br>เว็บเพจนี้เป็นส่วนหนึ่งของรายวิชา
        การวิเคราะห์และออกแบบระบบสารสนเทศ Information System Analysis and Design รหัสวิชา 02739323</span>
    <p>จัดทำโดย นายธนพล วิเศษสังข์ รหัสนิสิต 6121600233 เลขที่ 3</p>
</footer>

</html>


<?php 

}

?>