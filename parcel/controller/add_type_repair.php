<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['name-type-repair'])) {
  $name = $_GET['name-type-repair'];
  $sql = "SELECT * FROM type_repair WHERE name = '$name'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){?>
    <script>
    window.location.href = "../type_repair?error=error";
  </script>
  <?php }
  else{
    $insert_sql = "INSERT INTO type_repair (name) VALUES ('$name')";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../type_repair?success=ok";
    
      </script>
 <?php }
  }
 
  mysqli_close($conn);
}
