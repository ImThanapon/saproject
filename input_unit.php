<?php 

    session_start();

    if ($_SESSION['user_id'] == "" || $_SESSION['status'] == "user" ) {
        header("location: welcome.php");
    }  else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        $result = $userdata->getData();
        $row =  mysqli_fetch_assoc($result);

        if (isset($_POST['submit'])) {
            $water = $_POST['water_unit'];
            $electric = $_POST['elect_unit'];
            $rent = $_POST['rent_unit'];
            $invoice_day = $_POST['invoice_day'];
            $water_price = $water * 17;
            $electric_price = $electric * 8;
            $total = $electric_price + $water_price + $rent;
            echo $water."-";
            echo $electric."-";
            echo $rent."-";
            echo $_GET["id"]."-";
            echo $electric_price + $water_price + $rent;
            $code_id = uniqid();
            echo $code_id."-";
            $insert_success = $userdata->insert_invoice($_GET["id"], $water, $electric, $rent, $total, $invoice_day);
                if ($insert_success) {
                    // echo $sql;
                    echo "<script>alert('กรอกข้อมูลสำเร็จ/ Insert Data Successful!');</script>";
                    echo "<script>window.location.href='admin.php'</script>";
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดระหว่างบันทึกข้อมูล.');</script>";
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

    <!-- <style>
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
    </style> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
</head>

<body class="font-set bg-index" style="font-size: large;">
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
                    <a href="input_unit.php?id=101" class="btn btn-warning rounded-pill">กรอกมาตรน้ำ-ไฟ</a>
                    <a href="welcome_admin.php" class="btn btn-info rounded-pill">จัดการห้องพัก</a>
                    <a href="logout.php" class="btn btn-danger rounded-pill">Logout</a>
                </div>
            </div>
        </div>
    </nav>


    <div class="container">

        <div class="row mt-3 mb-5">
            <div class="col-4
            
            ">
                <div class="card card-body" style="border-radius: 15px;">
                    <h3 class="text-center">เลือกห้องพัก</h3>
                    <hr>
                    <div class="row">
                        <div class="col mb-2">
                            <a href="input_unit.php?id=101" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                101</a>
                        </div>
                        <div class="col">
                            <a href="input_unit.php?id=102" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                102</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col mb-2">
                            <a href="input_unit.php?id=103" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                103</a>
                        </div>
                        <div class="col">
                            <a href="input_unit.php?id=104" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                104</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col mb-2">
                            <a href="input_unit.php?id=105" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                105</a>
                        </div>
                        <div class="col">
                            <a href="input_unit.php?id=106" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                106</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col mb-2">
                            <a href="input_unit.php?id=107" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                107</a>
                        </div>
                        <div class="col">
                            <a href="input_unit.php?id=108" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                108</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col mb-2">
                            <a href="input_unit.php?id=109" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                109</a>
                        </div>
                        <div class="col">
                            <a href="input_unit.php?id=110" type="button" class="btn btn-block btn-info"
                                style="height:40px;">ห้อง
                                110</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col">

                <div class="card" style="border-radius: 15px;">
                    <div class="card-header pt-3" style="text-align: center;">
                        <h2>มาตรประปาและไฟฟ้า </h2>
                    </div>
                    <form method="post">
                        <div class="card-body" style="margin-right:25px;">
                            <div class="row" style="margin-top:15px;">
                                <div class="col-4" style="text-align:right;padding-top:7px;">
                                    <h5 class="card-title">วันที่กรอกข้อมูล</h5>
                                </div>
                                <div class="col-8">
                                <input class="form-control" type="date" id="invoice_day" name="invoice_day" required>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;">
                                <div class="col-4" style="text-align:right;padding-top:7px;">
                                    <h5 class="card-title">หมายเลขห้องพัก</h5>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control" id="room" name="room"
                                        value="<?php echo $_GET["id"]; ?>" disabled="disabled">
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;">
                                <div class="col-4" style="text-align:right;padding-top:7px;">
                                    <h5 class="card-title">หน่วยน้ำ</h5>
                                </div>
                                <div class="col-8">
                                    <input type="number" step=0.1 class="form-control" id="water_unit" name="water_unit"
                                        min=" 0" max="500" placeholder="กรอกหน่วยประปา"
                                        required>
                                </div>
                            </div>

                            <div class="row" style="padding-top:15px;">
                                <div class="col-4" style="text-align:right;padding-top:7px;">
                                    <h5 class="card-title">หน่วยไฟ</h5>
                                </div>
                                <div class="col-8">
                                    <input type="number" step=0.1 class="form-control" id="elect_unit" name="elect_unit" min="0" max="500"
                                        placeholder="กรอกหน่วยไฟฟ้า" required>
                                </div>
                            </div>

                            <div class="row" style="padding-top:15px;">
                                <div class="col-4" style="text-align:right;padding-top:7px;">
                                    <h5 class="card-title">ค่าเช่าห้อง</h5></h5>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control" id="rent_unit" name="rent_unit" min="0" max="5000"
                                        placeholder="กรอกค่าเช่าห้อง" required>
                                </div>
                            </div>
                            <div class="mt-3 mb-2" style="text-align: right;">
                                <button type="submit" name="submit" id="submit" class="btn btn-success">บันทึกข้อมูล /
                                    Save</button>
                            </div>


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