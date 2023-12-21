<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_urole'])) { 
  $id_urole = $_GET['id_urole'];
  $sql = "SELECT * FROM urole WHERE id_urole = $id_urole";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){ 
    $insert_sql = "DELETE  FROM urole WHERE  id_urole = $id_urole ";
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
