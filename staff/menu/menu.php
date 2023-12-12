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
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
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
            <a href="./form_rapair" class="nav-link" name="form_rapair">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                แจ้งซ่อม
              </p>
            </a>
          </li>  

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>