<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_asset'])) { 
  $id_asset = $_GET['id_asset'];
  $sql = "SELECT * FROM durable_articles WHERE asset_id = '$id_asset'";
  $sql1 = "SELECT * FROM durable_check WHERE asset_id = '$id_asset'";
  $result = mysqli_query($conn, $sql);
  $result1 = mysqli_query($conn, $sql1);
  if (mysqli_num_rows($result) > 0){ 
    $del_sql = "DELETE  FROM durable_articles WHERE  asset_id = '$id_asset'";
    $del_sql1 = "DELETE  FROM durable_check WHERE  asset_id = '$id_asset'";


    $del_result = mysqli_query($conn, $del_sql);
    $del_result1 = mysqli_query($conn, $del_sql1);
    if ($del_result) {   ?>
      <script>
      window.location.href = "../parcel?success=ok";
    
      </script>
      <?php }
    }
 
  mysqli_close($conn);
}