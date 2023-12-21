<?php 
session_start();
require_once '../../dbconfig.php';

if(isset($_REQUEST['id'])) { 
  $id = $_GET['id'];
  $name = $_GET['name'];
  $sql = "SELECT * FROM type_parcel WHERE name = '$name'";
  $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){?>
  <script>
  window.location.href = "../type_parcel?ed-error=error";
</script>
<?php }
else{
  $insert_sql = "UPDATE type_parcel SET name = '$name' WHERE id = $id ";
  $insert_result = mysqli_query($conn, $insert_sql);
  if ($insert_result) {   ?>
    <script>
    window.location.href = "../type_parcel?ed-success=ok";
  
    </script>
<?php }
}

mysqli_close($conn);
}

