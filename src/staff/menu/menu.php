<!-- Main Sidebar Container -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<style>
    .user-panel {
    display: flex;
    align-items: center;
  }

  .info1 {
    margin-left: auto;
    margin-right: 10px; /* ปรับขนาดของวรรคตามที่คุณต้องการ */
  }
  img.img-circle1 {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 50%;  /* เพิ่มบรรทัดนี้เพื่อทำให้รูปภาพเป็นวงกลม */
}
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="../image_profile/no-image.png" class="img-circle1 elevation-2 " alt="User Image" style="border-radius: 50%;">
        </div>
        <div class="info">
          <a href="#" class="d-block"> <?php echo $first_name .' '.$last_name?>
        </div>
        <div class="info1" >
          <a href="../logout" class="logout" >
        <i class="fas fa-sign-out-alt" style="font-size:20px;"></i>
         </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="./index" class="nav-link" name="dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./repair_me" class="nav-link" name="list-me">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                รายการแจ้งซ่อม
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./search_asset" class="nav-link" name="search_asset">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                แจ้งซ่อม
              </p>
            </a>
          </li>  
          <li class="nav-item" name="user-manual">
                    <a href="#" class="nav-link" name="user-manual1">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            คู่มือการใช้งาน
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../user_manual/repair.pdf" class="nav-link" name="user-manual-repair">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    การแจ้งซ่อม
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>