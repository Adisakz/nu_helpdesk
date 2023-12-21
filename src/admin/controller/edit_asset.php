<?php 
session_start();
require_once '../../dbconfig.php';


function resizeImage($tmp_name, $img_name, $img_size, $dir, $max_dimension) {
  list($width, $height) = getimagesize($tmp_name);

  // คำนวณขนาดที่ถูกต้องเพื่อรักษาสัดส่วน
  if ($width > $height) {
      $new_width = $max_dimension;
      $new_height = floor($height * ($max_dimension / $width));
  } else {
      $new_width = floor($width * ($max_dimension / $height));
      $new_height = $max_dimension;
  }

  $tmp_img = imagecreatetruecolor($new_width, $new_height);

  $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
  $img_ex_lc = strtolower($img_ex);

  switch ($img_ex_lc) {
      case 'jpg':
      case 'jpeg':
          $source = imagecreatefromjpeg($tmp_name);
          break;
      case 'png':
          $source = imagecreatefrompng($tmp_name);
          break;
      default:
          echo "สกุลไม่ถูกต้อง";
          exit();
  }

  imagecopyresampled($tmp_img, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

  $resized_img_name = uniqid("RESIZED_IMG-", true) . '.' . $img_ex_lc;
  $resized_path = $dir . $resized_img_name;

  switch ($img_ex_lc) {
      case 'jpg':
      case 'jpeg':
          imagejpeg($tmp_img, $resized_path);
          break;
      case 'png':
          imagepng($tmp_img, $resized_path);
          break;
  }

  imagedestroy($source);
  imagedestroy($tmp_img);

  return $resized_img_name;
}


if(isset($_REQUEST['submit'])) { 
  $assetId = $_POST['id'];
  $assetIdNew = $_POST['asset-id-new'];
  $nameAsset = $_POST['name-asset'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $building = $_POST['building'];
  $roomNumber = $_POST['room-number'];
  $year = $_POST['year'];
  $year = ($year != '') ? intval($year) - 543 : NULL;
  $price = $_POST['price'];
  $image = $_FILES['image-asset']['name'];
  $price = ($price !== '') ? $price : 0;

  $image = isset($_FILES["image-asset"]) ? $_FILES["image-asset"] : null;
    if ($image && $image["error"] == UPLOAD_ERR_OK) {
        // มีการอัปโหลดรูป
        $img_name = $_FILES["image-asset"]["name"];
        $img_size = $_FILES["image-asset"]["size"];
        $tmp_name = $_FILES["image-asset"]["tmp_name"];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png");
    
        // เช็คว่าสกุลของไฟล์อยู่ในรายการที่อนุญาตหรือไม่
        if (in_array($img_ex_lc, $allowed_exs)) {
            if ($img_size > 125000) {
                // ทำการ resize และบันทึกภาพ
                $resized_img_name = resizeImage($tmp_name, $img_name, $img_size, '../../image_asset/', 600);
                if ($year !== NULL) {
                    $sql = "UPDATE durable_articles SET name='$nameAsset', asset_id='$assetIdNew', brand='$brand', model='$model', building='$building', room_number='$roomNumber',image_asset='$resized_img_name', year=$year, price='$price' WHERE id_durable = $assetId";
                } else {
                    $sql = "UPDATE durable_articles SET name='$nameAsset', asset_id='$assetIdNew', brand='$brand', model='$model', building='$building', room_number='$roomNumber',image_asset='$resized_img_name', price='$price' WHERE id_durable = $assetId";
                }
                  $insert_result = mysqli_query($conn, $sql);
                  if ($insert_result) {   echo '<script>window.location.href = "../view_asset?id=' . urlencode($assetIdNew) . '&id_durable=' . $assetId . '";</script>';
                    exit();
                  }
            } else {
                // ทำการบันทึกไฟล์ที่ไม่ต้อง resize
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $dir = '../../image_asset/' . $new_img_name;
                move_uploaded_file($tmp_name, $dir);
    
                if ($year !== NULL) {
                    $sql = "UPDATE durable_articles SET name='$nameAsset', asset_id='$assetIdNew', brand='$brand', model='$model', building='$building', room_number='$roomNumber',image_asset='$new_img_name', year=$year, price='$price' WHERE id_durable = $assetId";
                } else {
                    $sql = "UPDATE durable_articles SET name='$nameAsset', asset_id='$assetIdNew', brand='$brand', model='$model', building='$building', room_number='$roomNumber',image_asset='$new_img_name', price='$price' WHERE id_durable = $assetId";
                }
                  $insert_result = mysqli_query($conn, $sql);
                  if ($insert_result) {   echo '<script>window.location.href = "../view_asset?id=' . urlencode($assetIdNew) . '&id_durable=' . $assetId . '";</script>';
                    exit();
                  }
            }
        } else {
            echo "สกุลไม่ถูกต้อง";
            header("location: ../parcel?error=error");
        }
    } else {
      if ($year !== NULL) {
        $sql = "UPDATE durable_articles SET name='$nameAsset', asset_id='$assetIdNew', brand='$brand', model='$model', building='$building', room_number='$roomNumber', year=$year, price='$price' WHERE id_durable = $assetId";
    } else {
        $sql = "UPDATE durable_articles SET name='$nameAsset', asset_id='$assetIdNew', brand='$brand', model='$model', building='$building', room_number='$roomNumber', price='$price' WHERE id_durable = $assetId";
    }
      $insert_result = mysqli_query($conn, $sql);
      if ($insert_result) {   echo '<script>window.location.href = "../view_asset?id=' . urlencode($assetIdNew) . '&id_durable=' . $assetId . '";</script>';
        exit();
      }
 
}
}
