<?php 
// echo "<pre>";
// var_dump(json_encode(file_get_contents('php://input'),TRUE));exit();
// $data = json_encode(file_get_contents('php://input'),TRUE);

// $return_code = 200;


// $conn = mysqli_connect('42.112.28.129', 'root', 'Topica@123##', 'shop') or die ('Không thể kết nối tới database');
$date = time();
$data = file_get_contents('php://input');
$text = print_r($data,true);
$file = fopen("/var/www/html/cryptolending/public/history_notification/text_".$date.".txt", 'w');
fwrite($file, $text);
exit();
$id = $data['order']['id'];
$status = $data['order']['id'];
$amount = $data['order']['total_btc']['cents'];
$user = $data['order']['custom'];

$sql = "INSERT INTO `sales` (`username`,`sales_id,`price_in_btc`) VALUES ('$user', '$id' ,'$amount')";
$result = mysqli_query($conn, $sql);

// Nếu thực thi không được thì thông báo truy vấn bị sai
if (!$result){
    die ('Câu truy vấn bị sai');
}

 ?>