<?php 

    session_start();

    if ($_SESSION['user_id'] == "" || $_SESSION['status'] == "user" ) {
        header("location: welcome.php");
    }  else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        $result_invoices = $userdata->getDataInvoices();
        $row_invoices =  mysqli_fetch_assoc($result_invoices);
        
        $result_receipts = $userdata->getDataReceipts();
        $row_receipts =  mysqli_fetch_assoc($result_receipts);
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
        <div class="row">
            <div class="col">
                <div class="mt-3 mb-3 card">
                    <h2 class="card-header" style="text-align:center;">รายการค้างชำระ</h2>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ห้องเลขที่</th>
                                        <th scope="col">วันที่ออกบิล</th>
                                        <th scope="col">ยอดค้างชำระ</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i=1; foreach( $result_invoices as $row_invoices ) { ?>
                                    <tr>
                                        <th><?php echo $i ?></th>
                                        <td><span
                                                class="badge rounded-pill bg-primary"><?php echo $row_invoices['room_id']; ?></span>
                                        </td>
                                        <td><?php echo $row_invoices['invoice_time']; ?></td>
                                        <td><span
                                                class="badge rounded-pill bg-warning text-dark"><?php echo $row_invoices['total']; ?></span>
                                        </td>
                                    </tr>
                                    <?php  $i = $i+1; }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mt-3 mb-3 card">
                    <h2 class="card-header" style="text-align:center;">ชำระเงินแล้ว</h2>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">รูปโอนเงิน</th>
                                        <th scope="col">ห้องเลขที่</th>
                                        <th scope="col">วันที่ออกบิล</th>
                                        <th scope="col">ยอดค้างชำระ</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i=1; foreach( $result_receipts as $row_receipts ) { ?>
                                    <tr>
                                        <th><?php echo $i ?></th>
                                        <?php  
                                if(empty($row_receipts['bill_image'])){ ?>
                                        <th scope="row"><img src="img/prebille.png" alt=""
                                                style="height:50px; width:50px;">
                                        </th>
                                        <?php }else{
                                    ?>
                                        <th scope="row"><img src="<?php echo $row_receipts['bill_image']; ?>" alt=""
                                                style="height:50px; width:50px;"></th>
                                        <?php
                                } ?>


                                        <td><span
                                                class="badge rounded-pill bg-primary"><?php echo $row_receipts['room_id']; ?></span>
                                        </td>
                                        <td><?php echo $row_receipts['invoice_time']; ?></td>
                                        <td><span
                                                class="badge rounded-pill bg-success"><?php echo $row_receipts['total']; ?></span>
                                        </td>
                                    </tr>
                                    <?php  $i = $i+1; }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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