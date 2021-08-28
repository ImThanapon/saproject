<?php 
    session_start();
    if ($_SESSION['user_id'] == "") {
        header("location: login.php");
    } else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        // $result = $userdata->getData();
        // $row =  mysqli_fetch_assoc($result);
        
        $result = $userdata->getDetail($_SESSION['room']);
        $row_bill =  mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<body class="font-set">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="text-start">
                <div class="row">
                    <div class="col">
                        <img class="mb-3" src="img/logo.png" style="width:120px;">
                    </div>
                    <div class="col">
                        <h1 class="display-1">PermSub</h1>
                        <hr class="mt-0 mb-0">
                        <h3>ระบบจัดการหอพักเพิ่มทรัพย์</h3>
                    </div>

                </div>

            </div>
            <div style="text-align: right;">
                <div class="row">

                    <div class="mt-4 col-7">
                        <h4>ห้องพัก : <?php echo $_SESSION['room']; ?></h4>
                        <h6>ชื่อ : <?php echo $_SESSION['name']; ?></h6>
                        <span>สถานะ : <div class="spinner-grow spinner-grow-sm text-success" role="status"></div><span
                                color="success"> ปกติ </span></span>
                    </div>
                    <div class="mt-3 col-5">
                        <img style="height: 130 px; width:130px; " src='<?php echo $_SESSION['img_profile'];?>'
                            class="img-fluid border border-dark border-5 rounded-circle" alt="profile-img">
                    </div>
                </div>
                <hr>
                <a href="admin.php" class="btn btn-primary rounded-pill">หน้าหลัก</a>
                <!-- <a href="payment.php" class="btn btn-warning rounded-pill">แจ้งชำระเงิน</a> -->
                <!-- <a href="welcome_admin.php" class="btn btn-info rounded-pill">จัดการห้องพัก</a> -->
                <button type="button" class="btn btn-danger rounded-pill" data-toggle="modal"
                    data-target="#logoutModal">Logout</button>
            </div>
        </div>
    </nav>
    <div class="bg-set">

        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="card my-4  shadow-set" style="border-radius: 20px;">
                        <div class="text-center card-header">
                            <h2>ห้อง : <?php echo $_SESSION['room']; ?></h2>
                            <h5>ข้อมูลผู้เข้าพัก</h5>
                        </div>
                        <div class="card-body">
                            <img src="<?php echo $_SESSION['img_profile'];?>" class="img-thumbnail img-fluid"
                                alt="profile-img">
                            <div class="mt-3 mb-3 mr-1 ml-1 mb-1">
                                <h5 class="card-title">ชื่อ-สกุล : <?php echo $_SESSION['name']; ?></h5>
                                <h5 class="card-title">วันเข้าพัก : <?php echo $_SESSION['check_in']; ?></h5>
                                <h6 class="card-text">เลขประจำตัว :
                                    <?php echo substr($_SESSION['id_card'], 0, 1);?>-<?php echo substr($_SESSION['id_card'], 1, 4);?>-XXXXX-<?php echo substr($_SESSION['id_card'], -3);?>
                                </h6>
                                <h6 class="card-text">เบอร์โทรศัพท์ :
                                    <?php echo substr($_SESSION['phone'], 0, 3);?>-XXX-<?php echo substr($_SESSION['phone'], 6, 10);?>
                                </h6>
                                <h5 class="card-text">Line : <span
                                        class="badge bg-success"><?php echo $_SESSION['line']; ?></h6>
                            </div>
                            <button type="button" class="mt-5 btn btn-block btn-danger rounded-pill" data-toggle="modal"
                                data-target="#logoutModal">ออกจากระบบ / Logout</button>
                            <div class="modal fade" id="logoutModal" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">ออกจากระบบ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>คุณต้องการออกจากระบบใช่หรือไม่</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="logout.php" class="btn btn-danger">Logout</a>
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-9">
                    <div class="card my-4 shadow-set" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php 
                                            if( empty($row_bill) ){
                                                ?>
                                <h3>รอการตรวจสอบจากผู้ดูแลระบบ</h3>
                                <?php
                                            }else{
                                                ?>
                                <table class="table table-striped" style="font-size: large;">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">ลำดับ</th>
                                            <th scope="col">วันที่ออกใบเสร็จ</th>
                                            <th scope="col">หน่วยประปา</th>
                                            <th scope="col">หน่วยไฟฟ้า</th>
                                            <th scope="col">ยอดชำระเงิน</th>
                                            <th scope="col">สถานะ</th>
                                            <th scope="col">จัดการ</th>

                                        </tr>
                                    </thead>

                                    <tbody class="text-center">


                                        <?php $i=1; foreach( $result as $row_bill ) { ?>
                                        <tr style="font-size: large;">
                                            <th><?php echo $i ?></th>
                                            <td><?php echo $row_bill['invoice_time']; ?></td>
                                            <td><?php echo $row_bill['water_unit']; ?></td>
                                            <td><?php echo $row_bill['electric_unit']; ?></td>
                                            <td><span
                                                    class="badge rounded-pill bg-danger"><?php echo $row_bill['total']; ?></span>
                                            </td>
                                            <?php if(($row_bill['status_pay'])=='not-paid'){ ?>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-warning text-dark">ค้างชำระเงิน</span>
                                            </td>
                                            <?php }else{ ?>
                                            <td>
                                                <span class="badge rounded-pill bg-success">ชำระเงินแล้ว</span>
                                            </td>
                                            <?php } ?>

                                            <?php if(($row_bill['status_pay'])=='not-paid'){ ?>
                                            <td>
                                                <a href="payment.php?id=<?php echo $row_bill['invoice_id'];?>&total=<?php echo $row_bill['total']; ?>"
                                                    class="btn btn-info"><i class="bi bi-wallet2"></i> คลิกชำระเงิน</a>
                                            </td>
                                            <?php }else{ ?>
                                            <td>
                                                <a href="create_bill.php?id=<?php echo $row_bill['invoice_id'];?>"
                                                    class="btn btn-warning"><i class="bi bi-arrow-down-circle"></i>
                                                    ดาวน์โหลดบิล</a>

                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <?php  $i = $i+1; }?>


                                    </tbody>
                                </table>
                                <?php
                                            }
                                ?>

                            </div>
                        </div>
                    </div>


                    <!-- <div class="card mt-4" style="height: 300px;">
                                <div id="carouselExampleIndicators" class="carousel slide pt-1 pb-1 pr-1 pl-1 " data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner" style="height: 289px;">
                                        <div class="carousel-item active">
                                        <img class="d-block w-100" src="img/img-show-01.png" alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                        <img class="d-block w-100" src="img/img-show-02.png" alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                        <img class="d-block w-100" src="img/img-show-03.png" alt="Third slide">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                        </div> -->


                </div>
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

<?php 
}
?>