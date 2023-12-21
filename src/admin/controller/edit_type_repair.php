<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_type_repair'])) { 
  $id_type_repair = $_GET['id_type_repair'];
  $name = $_GET['name'];
  $sql = "SELECT * FROM type_repair WHERE name = '$name'";
  $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){?>
  <script>
  window.location.href = "../type_repair?ed-error=error";
</script>
<?php }
else{
  $insert_sql = "UPDATE type_repair SET name = '$name' WHERE id_type_repair = $id_type_repair ";
  $insert_result = mysqli_query($conn, $insert_sql);
  if ($insert_result) {   ?>
    <script>
    window.location.href = "../type_repair?ed-success=ok";
  
    </script>
<?php }
}

mysqli_close($conn);
}

