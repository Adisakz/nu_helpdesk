<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id'])) { 
  $id = $_GET['id'];
  $sql = "SELECT * FROM parcel_data WHERE id_parcel = $id";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){ 
    $insert_sql = "DELETE  FROM parcel_data WHERE id_parcel = $id";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../add_parcel?del-success=ok";
    
      </script>
      <?php }
    }
  else{
      ?>
      <script>
      window.location.href = "../add_parcel?del-error=error";
      </script>
      <?php 
    }
 
  mysqli_close($conn);
}
