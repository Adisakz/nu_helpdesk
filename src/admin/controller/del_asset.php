<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_repair'])) { 
  $id_asset = $_GET['id_repair'];
  $sql = "SELECT * FROM durable_articles WHERE asset_id = '$id_asset'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){   
    $del_sql = "DELETE  FROM durable_articles WHERE  asset_id = '$id_asset'";
    $del_result = mysqli_query($conn, $del_sql);
       if ($del_result) {   ?>
      <script>
      window.location.href = "../parcel?success=ok";
    
      </script>
      <?php }
    }
 
  mysqli_close($conn);
}
