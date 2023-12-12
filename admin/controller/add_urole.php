<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['name-urole'])) {
  $name = $_GET['name-urole'];
  $sql = "SELECT * FROM urole WHERE name = '$name'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){?>
    <script>
    window.location.href = "../department?error=error";
  </script>
  <?php }
  else{
    $insert_sql = "INSERT INTO urole (name) VALUES ('$name')";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../department?success=ok";
    
      </script>
 <?php }
  }
 
  mysqli_close($conn);
}
