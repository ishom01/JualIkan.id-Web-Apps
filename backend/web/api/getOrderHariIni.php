<?php
  include 'connect.php';

  date_default_timezone_set('Asia/Jakarta');
  $date = date('Y-m-d');


  if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT pesanan.*, user.*
              FROM `order` as pesanan, user_pengguna as user
              WHERE user.user_id = pesanan.order_user_id and pesanan.order_koperasi_location_id = $id and pesanan.order_date like '%{$date}%'";
  }else{
      $sql = "SELECT pesanan.*, user.*
              FROM `order` as pesanan, user_pengguna as user
              WHERE user.user_id = pesanan.order_user_id and pesanan.order_date like '%{$date}%'";
  }

  $queryResult = $connect->query($sql);
  $result = array();
  while($fetchData = $queryResult->fetch_assoc()){
    $marker = array();

    $marker[] = floatval($fetchData['order_location_lat']);
    $marker[] = floatval($fetchData['order_location_lng']);
    $dialog = array();
    $dialog[] = $fetchData['user_full_name'];
    $dialog[] = $fetchData['order_location_adress'];
    $result[] = [
        "marker" => $marker,
        "dialog" => $dialog,
        "status" => $fetchData['order_status'],        //order
    ];
  }
  echo json_encode($result);
  // echo json_encode($result);
 ?>
