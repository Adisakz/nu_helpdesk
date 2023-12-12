<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_repair'])) { 
  $id_repair = $_GET['id_repair'];
  $sql = "SELECT * FROM repair_report_pd05 WHERE id_repair = $id_repair";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){ 
    $insert_sql = "DELETE  FROM repair_report_pd05 WHERE  id_repair = $id_repair ";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../repair_me?success=ok";
    
      </script>
      <?php }
    }
  else{
      ?>
      <script>
      window.location.href = "../repair_me?error=error";
      </script>
      <?php 
    }
 
  mysqli_close($conn);
}
