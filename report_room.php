<?php

session_start();

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
include_once('functions/functions.php'); 
        $userdata = new DB_con();
        $result = $userdata->getData();
        $row =  mysqli_fetch_assoc($result);

ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Report</title>
</head>
<body style="background-color: antiquewhite;">
    <div class="container">
        <div class="card mt-5">
        <h2 class="card-header" style="text-align:center;">ข้อมูลผู้พักอาศัย</h2>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">รูปภาพ</th>
                                <th scope="col">ชื่อผู้พัก</th>
                                <th scope="col">ห้องเลขที่</th>
                                <th scope="col">เลขบัตรประชาชน</th>
                                <th scope="col">เบอร์โทรติดต่อ</th>
                                <th scope="col">วันที่เข้าพัก</th>

                            </tr>
                        </thead>

                        <tbody class="text-center">
                            <?php $i=1; foreach( $result as $row ) { ?>
                            <tr style="font-size: large;">
                                <th><?php echo $i ?></th>
                                <?php  
                                if($row['image']=="" ){ ?>
                                <th scope="row"><img src="img/preprofile.png" alt="" style="height:50px; width:50px;">
                                </th>
                                <?php }else{
                                    ?>
                                <th scope="row"><img src="<?php echo $row['image']; ?>" alt=""
                                        style="height:50px; width:50px;"></th>
                                <?php
                                } ?>

                                <?php if(empty($row['name'])){ ?>
                                <td><span class="badge rounded-pill bg-success"><?php echo 'ห้องว่าง'; ?></span></td>
                                <?php }else{ ?>
                                <td><?php echo $row['name']; ?></td>
                                <?php } ?>

                                <td><span class="badge rounded-pill bg-primary"><?php echo $row['room_id']; ?></span>
                                </td>
                                <?php
                                if(empty($row['id_card'])){ ?>
                                <td><?php echo ('-');?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['id_card'];?>
                                </td>
                                <?php } ?>
                                <?php
                                if(empty($row['phone'])){ ?>
                                <td><?php echo ('-');?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['phone'];?>
                                </td>
                                <?php } ?>

                                <?php if(($row['check_in'])=='0000-00-00'){ ?>
                                <td><?php echo ('-');?></td>
                                <?php }else{ ?>
                                <td><?php echo $row['check_in'];?> </td>
                                <?php } ?>
                                
                            </tr>
                            <?php  $i = $i+1; }?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php
                $data_bill = ob_get_contents();
                $mpdf->WriteHTML($data_bill);
                $mpdf->Output('report/report_room.pdf');
                ob_end_flush();
            ?>      
            <a href='report/report_room.pdf' class="btn btn-lg btn-primary">พิมพ์ใบรายงาน</a>
            
        </div>
    </div>

 
                                       
                            
    
</body>
</html>