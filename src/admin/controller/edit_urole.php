<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id_urole'])) { 
  $id_urole = $_GET['id_urole'];
  $name = $_GET['name'];
  $sql = "SELECT * FROM urole WHERE name = '$name'";
  $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){?>
  <script>
  window.location.href = "../department?ed-error=error";
</script>
<?php }
else{
  $insert_sql = "UPDATE urole SET name = '$name' WHERE id_urole = $id_urole ";
  $insert_result = mysqli_query($conn, $insert_sql);
  if ($insert_result) {   ?>
    <script>
    window.location.href = "../department?ed-success=ok";
  
    </script>
<?php }
}

mysqli_close($conn);
}

