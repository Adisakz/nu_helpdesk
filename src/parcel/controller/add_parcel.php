<?php 
session_start();
require_once '../../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // รับข้อมูลจากแบบฟอร์ม
  $parcelType = $_POST['parcelType'];
  $parcelName = $_POST['parcelName'];
  $parcelModel = $_POST['parcelModel'];
  $parcelBrand = $_POST['parcelBrand'];
  $unit = $_POST['unit'];

// แสดงค่าที่รับมา
/*echo ': ' . $parcelType . '<br>';
echo 'ชื่อพัสดุ: ' . $parcelName . '<br>';
echo 'รุ่น: ' . $parcelModel . '<br>';
echo 'ยี่ห้อ: ' . $parcelBrand . '<br>';
echo 'หน่วยนับ: ' . $unit . '<br>';

}*/
  $sql = "SELECT * FROM parcel_data WHERE name_parcel = '$parcelName'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){?>
    <script>
    window.location.href = "../add_parcel?error=error";
  </script>
  <?php }
  else{
    $insert_sql = "INSERT INTO parcel_data (type,name_parcel,model,brand,unit_num) VALUES ('$parcelType','$parcelName','$parcelModel','$parcelBrand','$unit')";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../add_parcel?success=ok";
    
      </script>
 <?php }
  }
 
  mysqli_close($conn);
}
