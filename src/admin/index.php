<?php 
session_start();
require_once '../dbconfig.php';

function thaiMonth($month) {
  $months = array(
      '01' => 'ม.ค.',
      '02' => 'ก.พ.',
      '03' => 'มี.ค.',
      '04' => 'เม.ย.',
      '05' => 'พ.ค.',
      '06' => 'มิ.ย.',
      '07' => 'ก.ค.',
      '08' => 'ส.ค.',
      '09' => 'ก.ย.',
      '10' => 'ต.ค.',
      '11' => 'พ.ย.',
      '12' => 'ธ.ค.'
  );

  return $months[$month];
}

//แสดงจำนวนบัญชีทั้งหมด
$sql = "SELECT COUNT(*) AS userCount FROM account";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$userCount = $row['userCount'];
mysqli_free_result($result);


//แสดงจำนวนการแจ้งซ่อม
$sqlOrders = "SELECT COUNT(*) AS orderCount FROM repair_report_pd05";
$resultOrders = mysqli_query($conn, $sqlOrders);

// Check for errors
if (!$resultOrders) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the result as an associative array
$rowOrders = mysqli_fetch_assoc($resultOrders);

// Get the order count
$orderCount = $rowOrders['orderCount'];

// Close the result set
mysqli_free_result($resultOrders);

///////////  แสดงชื่อด้วยบัตร ปชช id_person 
function name_person($id) {
  global $conn; // Assuming $conn is your database connection variable

  $sql_person = "SELECT name_title,first_name,last_name FROM account WHERE id_person = '$id' LIMIT 1";
  $result_person = mysqli_query($conn, $sql_person);

  if ($row_person = mysqli_fetch_assoc($result_person)) {
    $person_name = $row_person['name_title'] . $row_person['first_name'].' ' . $row_person['last_name'];
      return $person_name;
  } else {
    $person_name = '';
      return$person_name;
  }
}


///////////  แสดงชื่อหน่วยงาน
function name_department($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_department = "SELECT name FROM department WHERE id_department = '$id' LIMIT 1";
    $result_department = mysqli_query($conn, $sql_department);

    if ($row_department = mysqli_fetch_assoc($result_department)) {
        $department_durable = $row_department['name'];
        return $department_durable;
    } else {
        $department_durable = '';
        return $department_durable;
    }
}


function getStatusText($status) {
  if ($status == 0) {
      $style = 'style="background-color: #ffc107; border-color: #FFC107; box-shadow: 0px 0px 4px 1px #FFC107; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
      return '<button ' . $style . '  class="text-white">รอซ่อม</button>';
  }  else if ($status == 1){
    $style = 'style="background-color: #fd7e14; border-color: #fd7e14; box-shadow: 0px 0px 4px 1px #fd7e14; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">กำลังซ่อม</button>';
}
  else if ($status == 2){
    $style = 'style="background-color: #dc3545; border-color: #dc3545; box-shadow: 0px 0px 4px 1px #dc3545; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">ยกเลิกการซ่อม</button>';
  }
  else if ($status == 3){
    $style = 'style="background-color: #28a745; border-color: #28a745; box-shadow: 0px 0px 4px 1px #28a745; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
    return '<button ' . $style . '  class="text-white">ซ่อมเสร็จ</button>';
  }
  else if ($status == 4){
    $style = 'style="background-color: #007bff; border-color: #007bff; box-shadow: 0px 0px 4px 1px #007bff; padding: 4px 8px; border-radius: 4px; color: #000;border:none;"';
  
    return '<button ' . $style . '  class="text-white">รออนุมัติ</button>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Help Desk | Admin</title>
  <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../image/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
 
  <!-- /.navbar -->
  <?php include './navber/navber.php' ;?>
  <!-- /.navbar -->
<!-- /.menu -->
  <?php include './menu/menu.php' ;?>
  <!-- /.menu -->
  <script>
    // ในกรณีที่ต้องการรอให้หน้าเว็บโหลดเสร็จก่อน
    document.addEventListener('DOMContentLoaded', function() {
        // เลือก element และเปลี่ยน class
        document.querySelector('a[name="dashboard"]').classList.add('nav-link', 'active');
    });
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo $orderCount; ?></h3>
                    <p>รายการแจ้งซ่อมทั้งหมด</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="repair_me" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?php echo $userCount; ?></h3>
                    <p>Account ทั้งหมด</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="account" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  รายการแจ้งซ่อม
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"style="position: relative; height: 300px;">
                    <div class="table-responsive">
                      <table class="table table-striped projects">
                      <thead>
                      <tr>
                        <th class="text-center">ประเภท</th>
                        <th class="text-center">หน่วยงาน/แผนก</th>
                        <th class="text-center">ทรัพย์สินที่ต้องการซ่อม</th>
                        <th class="text-center">เลขครุภัณฑ์</th>
                        <th class="text-center">สภาพการชำรุด</th>
                        <th class="text-center">วันที่</th>
                        <th class="text-center" width="150px">สถานะ</th>
                    </tr>
                      </thead>
                      <tbody>
                      <?php
                          $sqlrepair = "SELECT * FROM repair_report_pd05";
                          $resultrepair = mysqli_query($conn, $sqlrepair);

                          if ($resultrepair) {
                              // Loop through the results
                              while ($rowrepair = mysqli_fetch_assoc($resultrepair)) {
                                  echo '<tr>';
                                  echo '<td class="text-center">' . $rowrepair['type_repair'] . '</td>';
                                  echo '<td class="text-center">' . name_department($rowrepair['department_id']) . '</td>';
                                  echo '<td class="text-center">' . $rowrepair['asset_name'] . '</td>';
                                  echo '<td class="text-center">' . $rowrepair['asset_id'] . '</td>';
                                  echo '<td class="text-center">' . $rowrepair['asset_detail'] . '</td>';
                                  echo '<td class="text-center">' . date('d', strtotime($rowrepair['date_report_in'])) . ' ' . thaiMonth(date('m', strtotime($rowrepair['date_report_in']))) . ' ' . (date('Y', strtotime($rowrepair['date_report_in'])) + 543) . ' || ' . date('H:i', strtotime($rowrepair['date_report_in'])) . '</td>';
                                  echo '<td class="text-center">' . getStatusText($rowrepair['status']) . '</td>';
                                  echo '</tr>';
                              }
                              // Free result set
                              mysqli_free_result($resultrepair);
                          } else {
                              echo "Error: " . $sqlrepair . "<br>" . mysqli_error($conn);
                          }

                          // Close the connection
                          mysqli_close($conn);
                          ?>
                      </tbody>
                   </table>
                  </div>
                </div>
       
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>

                <div class="card-tools">
                  <span title="3 New Messages" class="badge badge-primary">3</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Alexander Pierce</span>
                      <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      Is this template really for free? That's unbelievable!
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->

                  <!-- Message to the right -->
                  <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">Sarah Bullock</span>
                      <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      You better believe it!
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->

                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">Alexander Pierce</span>
                      <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      Working with AdminLTE on a great new app! Wanna join?
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->

                  <!-- Message to the right -->
                  <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">Sarah Bullock</span>
                      <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      I would love to.
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->

                </div>
                <!--/.direct-chat-messages-->

                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                  <ul class="contacts-list">
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="dist/img/user1-128x128.jpg" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Count Dracula
                            <small class="contacts-list-date float-right">2/28/2015</small>
                          </span>
                          <span class="contacts-list-msg">How have you been? I was...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="dist/img/user7-128x128.jpg" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Sarah Doe
                            <small class="contacts-list-date float-right">2/23/2015</small>
                          </span>
                          <span class="contacts-list-msg">I will be waiting for...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="dist/img/user3-128x128.jpg" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nadia Jolie
                            <small class="contacts-list-date float-right">2/20/2015</small>
                          </span>
                          <span class="contacts-list-msg">I'll call you back at...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="dist/img/user5-128x128.jpg" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nora S. Vans
                            <small class="contacts-list-date float-right">2/10/2015</small>
                          </span>
                          <span class="contacts-list-msg">Where is your new...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="dist/img/user6-128x128.jpg" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            John K.
                            <small class="contacts-list-date float-right">1/27/2015</small>
                          </span>
                          <span class="contacts-list-msg">Can I take a look at...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img class="contacts-list-img" src="dist/img/user8-128x128.jpg" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Kenneth M.
                            <small class="contacts-list-date float-right">1/4/2015</small>
                          </span>
                          <span class="contacts-list-msg">Never mind I found...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                  </ul>
                  <!-- /.contacts-list -->
                </div>
                <!-- /.direct-chat-pane -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->

            <!-- TO DO List -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  To Do List
                </h3>

                <div class="card-tools">
                  <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                  <li>
                    <!-- drag handle -->
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo1" id="todoCheck1">
                      <label for="todoCheck1"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text">Design a nice theme</span>
                    <!-- Emphasis label -->
                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                      <label for="todoCheck2"></label>
                    </div>
                    <span class="text">Make the theme responsive</span>
                    <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo3" id="todoCheck3">
                      <label for="todoCheck3"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo4" id="todoCheck4">
                      <label for="todoCheck4"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo5" id="todoCheck5">
                      <label for="todoCheck5"></label>
                    </div>
                    <span class="text">Check your messages and notifications</span>
                    <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo6" id="todoCheck6">
                      <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Sales Graph
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">Mail-Orders</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">In-Store</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <!-- /.navbar -->
   <?php include './footer/footer.php' ;?>
  <!-- /.navbar -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
</body>
</body>
</html>
