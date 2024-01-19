<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_person'])) { 
  $id_person = $_GET['id_person'];
  $sql = "SELECT * FROM account WHERE id_person = $id_person";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){ 
    $insert_sql = "DELETE  FROM account WHERE  id_person = $id_person ";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../account?success=ok";
    
      </script>
      <?php }
    }
  else{
      ?>
      <script>
      window.location.href = "../account?error=error";
      </script>
      <?php 
    }
 
  mysqli_close($conn);
}
