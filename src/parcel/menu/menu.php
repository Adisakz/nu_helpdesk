<!-- Main Sidebar Container -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<style>
.user-panel {
    display: flex;
    align-items: center;
}

.info1 {
    margin-left: auto;
    margin-right: 10px;
    /* ปรับขนาดของวรรคตามที่คุณต้องการ */
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
            <div class="info1">
                <a href="../logout" class="logout">
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
                    <a href="./parcel" class="nav-link" name="asset">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            ครุภัณฑ์
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
                    <a href="./repair" class="nav-link" name="check-repair">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            ตรวจสอบการแจ้งซ่อม
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./type_repair" class="nav-link" name="type-repair">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            จัดการหมวดหมู่ครุภัณฑ์
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
                <li class="nav-item" name="parcel">
                    <a href="#" class="nav-link" name="parcel-head">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            พัสดุ
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./type_parcel" class="nav-link" name="type-parcel">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    จัดการหมวดหมู่พัสดุ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./add_parcel" class="nav-link" name="add_parcel">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มพัสดุ</p>
                            </a>
                        </li>
                         
                        <li class="nav-item" name="stock">
                            <a href="#" class="nav-link" name="stock">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Stock
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="./form_add_cut_qty" class="nav-link" name="stock-add-cut">
                                        <i class="nav-icon fas fa-file-invoice"></i>
                                        <p>
                                        สต๊อก-เบิก
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./search_parcel" class="nav-link" name="qr-code">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Qr-code</p>
                                    </a>
                                </li>
                    
                            </ul>
                        </li>
                </li>
            </ul>
            </li>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>