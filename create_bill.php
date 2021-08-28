<?php 
    session_start();
    if ($_SESSION['user_id'] == "") {
        header("location: login.php");
    } else {
        include_once('functions/functions.php'); 
        $userdata = new DB_con();
        
        $result_invoices = $userdata->getBillInvoices($_GET['id']);
        $row_invoices =  mysqli_fetch_assoc($result_invoices);
        
        $result_receipts = $userdata->getBillReceipts($_GET['id']);
        $row_receipts =  mysqli_fetch_assoc($result_receipts);

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
            <div class="row">
                <div class="col-5 text-right">
                    <img class="mb-2" src="img/logo.png" style="width:120px;">
                </div>
                <div class="col-7">
                    <h1 class="display-2">PermSub</h1>
                    <hr class="mt-0 mb-2" style="width:50%;">
                    <h3>ระบบจัดการหอพักเพิ่มทรัพย์</h3>
                </div>
            </div>
        </div>
    </nav>
    <div style="background-image: linear-gradient(to bottom right , #8470FF, #FFB6C1);background-repeat: no-repeat;">
        <div class="container">
            <div class="card shadow" style="margin:auto;;width:80%;">
                <div class="card-body">
                    <h2 class="text-center display-1">ใบเสร็จรับเงิน</h2>
                    <div class="card" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="text-right">
                                <h1>ห้อง <?php echo $row_invoices["room_id"]; ?></h1>
                            </div>
                            <div class="text-left">
                                <h4>วันที่ชำระเงิน : <u><?php echo $row_receipts["receipt_time"]; ?></u></h4>
                                <h4>วิธีชำระเงิน : <u><?php echo $row_receipts["method"]; ?></u></h4>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3>หน่วยน้ำประปา <u><?php echo $row_invoices["water_unit"]; ?></u> หน่วย</h3>
                                        <h3>หน่วยไฟฟ้า <u><?php echo $row_invoices["electric_unit"]; ?></u> หน่วย</h3>
                                        <h3>ค่าเช่าห้องพัก</h3>
                                    </div>
                                    <div class="col">
                                        <div class="row text-center">
                                            <div class="col">
                                                <h3><?php echo ($row_invoices["water_unit"]*17) ?> </h3>
                                                <h3><?php echo ($row_invoices["electric_unit"]*8) ?> </h3>
                                                <h3><?php echo $row_invoices["rent"]; ?></h3>
                                            </div>
                                            <div class="col">
                                                <h3>บาท</h3>
                                                <h3>บาท</h3>
                                                <h3>บาท</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <h2>รวมเป็นจำนวนเงิน</h2>
                                    </div>
                                    <div class="col">
                                        <div class="row text-center">
                                            <div class="col">
                                                <h2><?php echo $row_receipts["total_received"]; ?></h2>
                                            </div>
                                            <div class="col">
                                                <h2>บาท</h2>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>



                                <div class="text-center">
                                    <img src="img/name-bill.jpg" style="width:250px;">
                                    <h3>ผู้รับเงิน หอพักเพิ่มทรัพย์</h3>
                                </div>

                            </div>
                            <div class="text-right">


                            </div>

                            <hr>
                            <div style="margin:auto;text-align:center;">
                                <button class="btn btn-lg btn-primary" onClick="window.print()"><i
                                        class="bi bi-printer-fill"></i> พิมพ์ใบเสร็จรับเงิน</button>
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>









</body>

</html>

<?php 
}
?>