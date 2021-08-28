<?php 
    session_start();
    if ($_SESSION['user_id'] == "") {
        header("location: login.php");
    } else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        if (isset($_POST['submit'])) {

            $method = $_POST['banks'];
            $total_pay = $_GET['total'];
    
            $ext = end(explode(".",$_FILES['upload']['name']));
            $filename = md5(uniqid()).".".$ext;
            $bill = "member/img_bill/".$filename;
            echo $_FILES['upload']['tmp_name'];
            move_uploaded_file($_FILES['upload']['tmp_name'],$bill);
            $path_img_bill =  $bill;
            
    
                $sql = $userdata->insert_bill($_SESSION['room'], $_GET['id'],$path_img_bill, $method, $total_pay);
                if ($sql) {
                    // echo $sql;
                    echo "<script>alert('แจ้งชำระเงินสำเร็จ ทางหอพักจะออกใบเสร็จรับเงินให้ท่านโดยเร็วที่สุด');</script>";
                    echo "<script>window.location.href='welcome.php'</script>";
                } else {
                    echo "<script>alert('แจ้งชำระเงินไม่สำเร็จ กรุณาทำรายการอีกครั้ง !! ');</script>";
                    //echo "<script>window.location.href='signin.php'</script>";
                }

        }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#show_img_bill').attr('src', e.target.result);
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
                <div class="modal fade" id="logoutModal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">ออกจากระบบ</h4>
                            </div>
                            <div class="modal-body" style="text-align:center">
                                <p>คุณต้องการออกจากระบบใช่หรือไม่</p>
                            </div>
                            <div class="modal-footer">
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class=" pb-3 bg-index">
        <div class="row" style="padding-top:20px;">
            <div class="col-6">
                <div class="form-payment" style="margin-left:47%;">
                    <div class="card">
                        <div class="card-header" style="text-align:center;">

                            <h2 style="padding-top:10px">Payment Form</h2>
                            <h4>แบบฟอร์มแจ้งการชำระเงิน</h4>
                            <p>กรุณาใส่ข้อมูลในช่องที่มีเครื่องหมายดอกจัน ( * ) </p>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype=multipart/form-data>

                                <div class="card">
                                    <div class="card-header">
                                        <h5><strong>ส่วนที่ 1 : ข้อมูลผู้พักอาศัย</strong></h5>
                                    </div>
                                </div>



                                <div class="mt-3">
                                    <label for="fullname" class="form-label">ผู้ชำระเงิน</label>
                                    <input type="text" class="form-control" id="username" name="fullname"
                                        value="<?php echo $_SESSION['name'];?>" disabled="disabled">
                                </div>
                                <div class="mt-3">
                                    <label for="fullname" class="form-label">หมายเลขห้องพัก</label>
                                    <input type="text" class="form-control" id="number_room" name="number_room"
                                        value="<?php echo $_SESSION['room'];?>" disabled="disabled">
                                </div>
                                <hr>


                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5><strong>ส่วนที่ 2 : ข้อมูลการชำระเงิน</strong></h5>
                                    </div>
                                </div>

                                <div div class="mt-3">
                                    <label for="username" class="form-label">บัญชีปลายทาง</label>
                                    <select class="form-select" id="banks" name="banks">
                                        <option value="ไทยพานิชย์ 321-444120-8">ไทยพานิชย์ 321-444120-8</option>
                                        <option value="กสิกร 586-236817-9">กสิกร 586-236817-9</option>
                                        <option value="กรุงไทย 741-047065-8">กรุงไทย 741-047065-8</option>
                                        <option value="พร้อมเพย์ 061-980-7818">พร้อมเพย์ 061-980-7818</option>
                                    </select>

                                </div>
                                <div class="mt-3 mb-3">
                                    <label for="text" class="form-label">ยอดชำระเงิน ( * จำเป็น )</label>
                                    <input type="number" class="form-control" id="pay" name="pay"
                                        value="<?php echo $_GET['total'];?>" disabled="disabled">
                                </div>
                                <label>แนบไฟล์รูปภาพ</label>
                                <div class="text-center " style="margin:auto;width:300px;">
                                    <br>
                                    <img class="mb-3 border" id="show_img_bill" src="img/prebill.png"
                                        style="height: 150px;"><br>
                                    <label for="upload" class="form-label">คำแนะนำ : ไฟล์รูปภาพใบเสร็จโอนเงิน
                                        นามสกุลไฟล์ .png .jpg</label><br>
                                    <input type="file" class="mb-3 form-control text-right" id="upload" name="upload"
                                        onchange="readURL(this);" required>
                                </div>
                                <input type="reset" class="btn btn-block btn-danger" value="ล้างข้อมูล / Reset">


                                <button type="submit" name="submit" id="submit"
                                    class="btn btn-block btn-success">กดเพื่อส่ง / Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 ">
                <div class="form-payment">
                    <div class="card">
                        <div class="card-header" style="text-align:center;">

                            <h2 style="padding-top:10px">Payment channel</h2>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><strong>บัญชีธนาคาร</strong></h5>
                                    </div>
                                </div>

                                <div class="row mt-3 mb-3" style="text-align:center;">
                                    <div class="col-4">
                                        <img src="img/SCB.png" alt="Girl in a jacket" width="70" height="70"><br>
                                        <span>ไทยพานิชย์</span><br>
                                        <span>321-444120-8</span><br>
                                        <span>ธนพล วิเศษสังข์</span>
                                    </div>
                                    <div class="col-4">
                                        <img src="img/kbank.png" alt="Girl in a jacket" width="70" height="70"><br>
                                        <span>กสิกร</span><br>
                                        <span>586-236817-9</span><br>
                                        <span>กนกพร ศรีชัยนาท</span>
                                    </div>
                                    <div class="col-4">
                                        <img src="img/krungthai.png" alt="Girl in a jacket" width="70" height="70"><br>
                                        <span>กรุงไทย</span><br>
                                        <span>741-047065-8</span><br>
                                        <span>ธนพล วิเศษสังข์</span>
                                    </div>
                                </div>



                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5><strong>สแกน QR CODE / Prompay พร้อมเพย์</strong></h5>
                                    </div>
                                </div>
                                <div style="text-align:center;">
                                    <img src="img/qrcode.png" alt="Girl in a jacket" width="200" height="200">
                                    <hr>
                                    <h4>พร้อมเพย์ : 061-980-7818</h4>
                                    <h5>ชื่อบัญชี : นายธนพล วิเศษสังข์</h5>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>




    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
</body>
<footer style="text-align: center; padding-top:15px;">
    <span>Copyright &copy; 2021-2022 <a
            href="https://www.facebook.com/me/">Nack.OSC</a><br>เว็บเพจนี้เป็นส่วนหนึ่งของรายวิชา
        การวิเคราะห์และออกแบบระบบสารสนเทศ Information System Analysis and Design รหัสวิชา 02739323</span>
    <p>จัดทำโดย นายธนพล วิเศษสังข์ รหัสนิสิต 6121600233 เลขที่ 3</p>
</footer>

</html>
<?php 
}
?>