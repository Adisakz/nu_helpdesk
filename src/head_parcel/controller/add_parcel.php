<?php 
session_start();
require_once '../../dbconfig.php';


// สร้างตัวแปรสำหรับตัวอักษรที่สุ่มมา 10 ตัว
$randomString = '';
$length = 10; // จำนวนตัวอักษรที่ต้องการสุ่ม
for ($i = 0; $i < $length; $i++) {
    $randomChar = chr(rand(65, 90)); // สุ่มตัวอักษรในช่วง A-Z (รหัส ASCII 65-90)
    $randomString .= $randomChar;
}

// สร้างตัวแปรสำหรับตัวเลขที่สุ่มมา
$randomNumber = mt_rand(1000000, 9999999); // สุ่มตัวเลขในช่วง 1000-9999

// แสดงผลลัพธ์
/*echo "ตัวอักษรสุ่ม: $randomString<br>";
echo "ตัวเลขสุ่ม: $randomNumber<br>";*/
$fullname = $randomString.''.$randomNumber;

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
echo 'หน่วยนับ: ' . $unit . '<br>';*/


  $sql = "SELECT * FROM parcel_data WHERE name_parcel = '$parcelName'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){?>
    <script>
    window.location.href = "../add_parcel?error=error";
  </script>
  <?php }
  else{
    $insert_sql = "INSERT INTO parcel_data (type,name_parcel,model,brand,unit_num,id_qr) VALUES ('$parcelType','$parcelName','$parcelModel','$parcelBrand','$unit','$fullname')";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../add_parcel?success=ok";
    
      </script>
 <?php }
  }
 
  mysqli_close($conn);
}
?>