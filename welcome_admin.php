<?php 

    session_start();

    if ($_SESSION['user_id'] == "" || $_SESSION['status'] == "user" ) {
        header("location: welcome.php");
    }  else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        $result = $userdata->getData();
        $row =  mysqli_fetch_assoc($result);
        


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

        <div class="mt-3 card">


            <div class="mr-2" style="text-align:right;">
                <a href="report_room.php" type="submit" name="submit" id="submit" class="mt-3 btn btn-danger">
                    <i class="bi bi-printer"></i> สร้างรายงาน
                </a>
            </div>



            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <h2 style="text-align:center;">ข้อมูลห้องพัก</h2>
                            <hr>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รูปภาพ</th>
                                <th scope="col">ชื่อผู้พัก</th>
                                <th scope="col">ห้องเลขที่</th>
                                <th scope="col">เลขบัตรประชาชน</th>
                                <th scope="col">เบอร์โทรติดต่อ</th>
                                <th scope="col">วันที่เข้าพัก</th>
                                <th scope="col">จัดการ</th>

                            </tr>
                        </thead>

                        <tbody class="text-center">
                            <?php $i=1; foreach( $result as $res ) { ?>
                                <tr style="font-size: large;">
                                    <td><?php echo $i ?></td>
                                    <?php  
                                    if($res['image']=="" ){ ?>
                                    <td scope="row"><img src="img/preprofile.png" alt="" style="height:50px; width:50px;"></td>
                                    <?php }else{
                                        ?>
                                    <td scope="row"><img src="<?php echo $res['image']; ?>" alt=""
                                            style="height:50px; width:50px;"></td>
                                    <?php
                                    } ?>

                                    <?php if(empty($res['name'])){ ?>
                                    <td><span class="badge rounded-pill bg-success"><?php echo 'ห้องว่าง'; ?></span></td>
                                    <?php }else{ ?>
                                    <td><?php echo $res['name']; ?></td>
                                    <?php } ?>

                                    <td><span class="badge rounded-pill bg-primary"><?php echo $res['room_id']; ?></span>
                                    </td>
                                    <?php
                                    if(empty($res['id_card'])){ ?>
                                    <td><?php echo ('-');?></td>
                                    <?php }else{ ?>
                                    <td><?php echo substr($res['id_card'], 0, 1);?>-<?php echo substr($res['id_card'], 1, 4);?>-XXXXX-<?php echo substr($row['id_card'], -3);?>
                                    </td>
                                    <?php } ?>
                                    <?php
                                    if(empty($res['phone'])){ ?>
                                    <td><?php echo ('-');?></td>
                                    <?php }else{ ?>
                                    <td><?php echo substr($res['phone'], 0, 3);?>-XXX-<?php echo substr($res['phone'], 6, 10);?>
                                    </td>
                                    <?php } ?>

                                    <?php if(($res['check_in'])=='0000-00-00'){ ?>
                                    <td><?php echo ('-');?></td>
                                    <?php }else{ ?>
                                    <td><?php echo $res['check_in'];?> </td>
                                    <?php } ?>




                                    <td>
                                        <?php
                                        if(($res['check_in'])=='0000-00-00'){
                                            ?>
                                        <a href="register.php?room_id=<?php echo $res['room_id']; ?>"
                                            class="btn btn-primary">เพิ่มผู้พักอาศัย</a>
                                        <?php
                                        }else{
                                            ?>
                                        <a href="edit_page.php?id=<?php echo $res['user_id']; ?>"
                                            class="btn btn-warning">แก้ไข</a>
                                        <a href="delete_user.php?id=<?php echo $res['user_id']; ?>"
                                                            class="btn btn-danger">ลบ</a>
                                        <?php
                                        }
                                        ?>
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