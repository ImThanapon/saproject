<?php 

    define('DB_SERVER', 'localhost'); // Your hostname
    define('DB_USER', 'root'); // Database Username
    define('DB_PASS', ''); // Database Password
    define('DB_NAME', 'sa_project'); // Database Name
    
    class DB_con {
        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
        }
        public function getData() {
            $result = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM users 
            WHERE users.status = 'user'
            ORDER BY room_id;"
            );
            return $result ;
        }
        public function getDataInvoices() {
            $result = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM invoices 
            WHERE status_pay = 'not-paid'
            ORDER BY invoice_time;"
            );
            return $result ;
        }
        public function getDataReceipts() {
            $result = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM invoices 
            INNER JOIN receipts 
            ON  invoices.invoice_id = receipts.receipt_id 
            WHERE invoices.status_pay = 'paid'
            ORDER BY invoice_time;"
            );
            return $result ;
        }
        
        public function getBillReceipts($id) {
            $result = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM receipts 
            WHERE invoice_id = '$id';"
            );
            return $result ;
        }
        public function getBillInvoices($id) {
            $result = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM invoices 
            WHERE invoice_id = '$id';"
            );
            return $result ;
        }
        public function getDetail($room) {
            $detail = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM invoices 
            WHERE invoices.room_id ='$room'
            ORDER BY invoices.invoice_time;"
            );
            return $detail ;
        }
        


        public function insert_bill($room, $invoice_id, $path_img_bill, $method, $total_pay){
            $result_insert_bill = mysqli_query($this->dbcon,
            "UPDATE invoices
            SET status_pay = 'paid'             
            WHERE invoice_id = '$invoice_id'");

            $result_update_receipt = mysqli_query($this->dbcon,
            "UPDATE receipts
            SET total_received = '$total_pay',
            bill_image = '$path_img_bill',
            invoice_id = '$invoice_id',
            method = '$method'
            WHERE receipt_id = '$invoice_id'");

            if($result_insert_bill || $result_update_receipt ){
                return $result_insert_bill;
            }else{
                echo "<script>alert('เกิดข้อผิดพลาด ระหว่างส่งข้อมูลการแจ้งชำระเงิน !!');</script>";
            }   
        }

        public function usernameavailable($username) {
            $checkuser = mysqli_query($this->dbcon, "SELECT username FROM users WHERE username = '$username'");
            return $checkuser;
        }

        public function registration($name, $line, $phone, $email, $username, $password, $img_profile, $room, $check_in, $address, $id_card) {
            
            $reg_info = mysqli_query($this->dbcon, 
            "UPDATE users 
            SET name='$name',
              phone='$phone',
               line='$line',
                email='$email',
                 address='$address',
               id_card='$id_card',
                   username='$username',
                  password='$password', 
                  image='$img_profile',
                  check_in='$check_in'

                     WHERE room_id='$room'
           "
           );

            if($reg_info){
                return $reg_info;
            }else{
                echo "<script>alert('เกิดข้อผิดพลาด ระหว่างส่งข้อมูล !!');</script>";
            }   
        }   


        public function insert_invoice($room, $water_unit, $electric_unit, $rent_unit, $total, $invoice_day){
            $result_insert_invoice = mysqli_query($this->dbcon,
            "INSERT INTO invoices (room_id, water_unit, electric_unit, rent, total, invoice_time) VALUES('$room', '$water_unit', '$electric_unit', '$rent_unit', '$total', '$invoice_day' )");

            $result_insert_receipt = mysqli_query($this->dbcon,
            "INSERT INTO receipts (room_id, receipt_time) VALUES('$room', '0000-00-00')");

            if($result_insert_invoice || $result_insert_receipt ){
                return $result_insert_receipt;
            }else{
                echo "<script>alert('เกิดข้อผิดพลาด ระหว่างส่งข้อมูล !!');</script>";
            }   

        }

        public function signin($username, $password) {

            $signinquery = mysqli_query($this->dbcon, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
            return $signinquery;
        }


        public function update($id, $name, $id_card, $phone, $line, $email, $address, $room, $check_in){
            $update = mysqli_query($this->dbcon, 
            "UPDATE users 
            set 
            name = '$name',
            id_card = '$id_card' ,
            phone = '$phone',
            room_id = '$room',
            line = '$line',
            email = '$email' ,
            check_in = '$check_in',
            address = '$address'
            WHERE user_id = '$id' ");
            return $update;
        }

        public function edit_profile($id){
            $result = mysqli_query($this->dbcon, 
            "SELECT * 
            FROM users 
            WHERE user_id ='$id' ");
            return $result;
        }

        public function admin_signin($username, $password) {
            //$signinquery = mysqli_query($this->dbcon, "SELECT * FROM users INNER JOIN rooms ON users.user_id = rooms.user_id INNER JOIN invoices ON rooms.room_id = invoices.room_id INNER JOIN receipts ON receipts.invoice_id = invoices.invoice_id WHERE username = '$username' AND password = '$password'");
            $signinquery = mysqli_query($this->dbcon, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
            return $signinquery;
        }

    }
?>