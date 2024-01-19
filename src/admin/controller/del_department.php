<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_department'])) { 
  $id_department = $_GET['id_department'];
  $sql = "SELECT * FROM department WHERE id_department = $id_department";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){ 
    $insert_sql = "DELETE  FROM department WHERE  id_department = $id_department ";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../department?del-success=ok";
    
      </script>
      <?php }
    }
  else{
      ?>
      <script>
      window.location.href = "../department?del-error=error";
      </script>
      <?php 
    }
 
  mysqli_close($conn);
}
