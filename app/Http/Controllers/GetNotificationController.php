<?php



class GetNotificationController

    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function getNotification(){
        echo "<pre>";
        var_dump(json_encode(file_get_contents('php://input'),TRUE));exit();
        $return_code = 200;


        $conn = mysqli_connect('42.112.28.129', 'root', 'Topica@123##', 'shop') or die ('Không thể kết nối tới database');
        $data = json_encode(file_get_contents('php://input'),TRUE);


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
    }

}
