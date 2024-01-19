<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['name-unit-parcel'])) {
  $name = $_GET['name-unit-parcel'];
  $sql = "SELECT * FROM unit_parcel WHERE name = '$name'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0){?>
    <script>
    window.location.href = "../type_parcel?error=error";
  </script>
  <?php }
  else{
    $insert_sql = "INSERT INTO unit_parcel (name) VALUES ('$name')";
    $insert_result = mysqli_query($conn, $insert_sql);
    if ($insert_result) {   ?>
      <script>
      window.location.href = "../type_parcel?success=ok";
    
      </script>
 <?php }
  }
 
  mysqli_close($conn);
}
