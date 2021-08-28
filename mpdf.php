<?php

session_start();
$water_price = 17 * $_SESSION['water_unit'];
$electric_price = 8 * $_SESSION['electric_unit'];

require_once __DIR__ . '/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI'=> 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun'
]);


ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>invoices_<?php echo $_SESSION['room'] ?></title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                <div>
                    <img src="img/logo.png" style="width:50px;">
                    <br>
                    <h1>หอพักเพิ่มทรัพย์</h1>
                    <hr>
                    <h1>ใบแจ้งหนี้ <?php echo $_SESSION['room'];?></h1>     
                    <h2>เลขที่ใบแจ้งหนี้ : <?php echo ($_SESSION['invoice_id']);?></h2>   
                    <h2>ค่าน้ำ : <?php echo ($water_price);?> บาท (<?php echo $_SESSION['water_unit']; ?> หน่วย)</h2>
                    <h2>ค่าไฟ : <?php echo ($electric_price); ?> บาท (<?php echo $_SESSION['electric_unit']; ?> หน่วย)</h2>
                    <h2>ค่าห้องพัก : <?php echo $_SESSION['rent'];?> บาท </h2>
                    <hr>
                    ยอดที่ต้องชำระ
                    <h3 class="card-text text-center"><?php echo $_SESSION['total']; ?> บาท</h3>
                    <p class="card-title"><i data-feather="clock" class="mr-2"></i>ชำระก่อนวันที่ 5 ของเดือน</p>
                    <hr> 
                    <h3>ช่องทางชำระเงิน</h3>
                                
                    <div class="row">
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
                    <hr>
                    <img src="img/qrcode.png" alt="Girl in a jacket" width="150">
                    <h2>พร้อมเพย์ : 061-980-7818</h2>
                    <h3>ชื่อบัญชี : นายธนพล วิเศษสังข์</h3>
                    <hr>
                </div>                             
                
               
                <?php
                $data_bill = ob_get_contents();
                $mpdf->WriteHTML($data_bill);
                $mpdf->Output('invoices/invoice.pdf');
                ob_end_flush();
                ?>                     
                <a href='invoices/invoice.pdf' class="btn btn-block btn-primary"></i>พิมพ์ใบแจ้งหนี้</a>
            </div>
        </div>
    </div>

 
                                       
                            
    
</body>
</html>