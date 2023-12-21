<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_type_repair'])) { 
  $id_type_repair = $_GET['id_type_repair'];
  $sql = "SELECT * FROM type_repair WHERE id_type_repair = $id_type_repair";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){ 
    $insert_sql = "DELETE  FROM type_repair WHERE  id_type_repair = $id_type_repair";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../type_repair?del-success=ok";
    
      </script>
      <?php }
    }
 
  mysqli_close($conn);
}
