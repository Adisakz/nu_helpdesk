<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once '../dbconfig.php';

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
  
  function thaiMonth($date) {
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

    $dateTime = date_create($date);
    $formattedDate = date_format($dateTime, 'd').' '.$months[date_format($dateTime, 'm')].' '.(date_format($dateTime, 'Y')+543);

    return $formattedDate;
}




$id=$_GET['id'];
$sql = "SELECT *  FROM repair_report_pd05 WHERE id_repair = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$department_id =name_department($row['department_id']);
$date_report_in =$row['date_report_in'];
$reasons =$row['reasons'];
$asset_name =$row['asset_name'];
$asset_id =$row['asset_id'];
$asset_detail =$row['asset_detail'];
$amount =$row['amount'];
$last_amount =$row['last_amount'];
$recomment =$row['recomment'];
$report_signature =$row['report_signature'];
$report_name =$row['report_name'];
$signature_tech =$row['signature_tech'];
$tech_id =name_person($row['tech_id']);
$date_tech_confirm =thaiMonth($row['date_tech_confirm']);
$inspector_name1 =$row['inspector_name1'];
$inspector_name2 =$row['inspector_name2'];
$inspector_name3 =$row['inspector_name3'];
$id_head =name_person($row['id_head']);
$signature_head =$row['signature_head'];

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData =$defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf (
    [
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/font',
        ]), 
        'fontdata' =>$fontData + [
            'thsarabun' => [
                'R' => 'THSarabunNew.ttf'
            ]
        ],
        'default_font' =>'thsarabun',
        'format' => [101.6, 152.4]
    ]
);
//$mpdf->showWatermarkImage = true; 
//$mpdf->SetWatermarkImage('./form_pd05.png');
$mpdf->AddPageByArray([
    'margin-left' => 0,
    'margin-right' => 0,
    'margin-top' => 0,
    'margin-bottom' => 0,
    ]);

  
$data = '
<div class="body" >
    <div class="content" >
        <p class="date-report-in" >'.(!empty($date_report_in) ? thaiMonth($date_report_in) : '').'</p>
        <p class="department" >'.(!empty($department_id) ? $department_id : '').'</p>
        <p class="reasons" >'.(!empty($reasons) ? $reasons : '').'</p>
        <p class="asset_name" >'.(!empty($asset_name) ? $asset_name : '').'</p>  
        <p class="asset_id" >'.(!empty($asset_id) ? $asset_id : '').'</p>
        <p class="asset_detail" >'.(!empty($asset_detail) ? $asset_detail : '').'</p>
        <p class="amount" >'.(!empty($amount) ? $amount : '0').'</p>
        <p class="last_amount" >'.(!empty($last_amount) ? $last_amount : '0').'</p>
        <p class="recomment" >'.(!empty($recomment) ? $recomment : '').'</p>
        <div  class="report_signature">
        <img src="../image_signature/'.(!empty($report_signature) ? $report_signature : '').'" width="100%">
        </div> 
        <p class="report_name" >'.(!empty($report_name) ? $report_name : '').'</p>
        <div  class="signature_tech">
        <img src="../image_signature/'.(!empty($signature_tech) ? $signature_tech : '').'" width="100%">
        </div> 
        <p class="tech_id" >'.(!empty($tech_id) ? $tech_id : '').'</p>
        <p class="date_tech_confirm" >'.(!empty($date_tech_confirm) ? $date_tech_confirm : '').'</p>
        <p class="inspector_name1" >'.(!empty($inspector_name1) ? $inspector_name1 : '').'</p>
        <p class="inspector_name2" >'.(!empty($inspector_name2) ? $inspector_name2 : '').'</p>
        <p class="inspector_name3" >'.(!empty($inspector_name3) ? $inspector_name3 : '').'</p>
        <div  class="signature_head">
        <img src="../image_signature/'.(!empty($signature_head) ? $signature_head : '').'" width="100%">
        </div> 
        <p class="id_head" >'.(!empty($id_head) ? $id_head : '').'</p>
    </div>  
</div>
<style>
.body {
    background-image: url("./form_pd05.png");
    background-size: cover;
    background-repeat: no-repeat;
    width: 100%;
    height: 100vh;
}

.content{
    font-size:  9px;
    width: 100%;
    height: 100vh;
}
.date-report-in{
    padding-left:200px;
    padding-top:71px;
}
.department{
    padding-left:97px;
    padding-top:8px;
}
.reasons{
    position: relative;
    padding-left:170px;
    padding-top:-10px;
}
.asset_name{
    width: 80px;
    position: relative;
    margin: left 40px;
    padding-left:4px;
    padding-top:24px;
}
.asset_id{
    width: 57px;
    position: relative;
    margin: left 130px;
    padding-left:0px;
    margin-top:  -26px;
    text-align: center;
}
.asset_detail{
    width: 80px;
    
    position: relative;
    margin: left 198px;
    margin-top:  -12px;
    padding-left:0px;
}
.amount{
    width: 25px;
    position: relative;
    margin: left 290px;
    margin-top:  -29px;
    padding-left:3px;
    text-align: center;

}
.last_amount{
    width: 30px;
    position: relative;
    margin: left 322px;
    margin-top:  -14px;
    padding-left:3px;
    text-align: center;
}
.recomment{
    width: 215px;
    position: relative;
    margin: left 140px;
    margin-top:  32.5px;
    text-align: center;
}
.report_signature{
    width: 50px;
    position: relative;
    margin: left 260px;
    margin-top:  7px;
}
.report_name{
    width: 80px;
    position: relative;
    margin: left 240px;
    margin-top:  -15px;
    padding-left:3px;
    text-align: center;
}
.signature_tech{
    width: 35px;
    position: relative;
    margin: left 48px;
    margin-top:  -33px;
}
.tech_id{
    width: 70px;
    position: relative;
    margin: left 26px;
    margin-top:  -10px;
    padding-left:3px;
    text-align: center;
}
.date_tech_confirm{
    width: 70px;
    position: relative;
    margin: left 26px;
    margin-top:  -6px;
    padding-left:3px;
    text-align: center;
}
.inspector_name1{
    width: 100px;
    position: relative;
    margin: left 43px;
    margin-top:  8px;
    text-align: center;
}
.inspector_name2{
    width: 100px;
    position: relative;
    margin: left 150px;
    margin-top:  -13px;
    text-align: center;
}
.inspector_name3{
    width: 100px;
    position: relative;
    margin: left 250px;
    margin-top:  -13px;
    text-align: center;
}
.id_head{
    width: 90px;
    position: relative;
    margin: left 60px;
    margin-top:  66px;
    text-align: center;
}
.signature_head{
    width: 35px;
    border:2px solid red;
    position: relative;
    margin: left 60px;
    margin-top:  58px;
}

</style>';

$mpdf->WriteHTML($data);


$mpdf->Output('GeneratePDF.pdf', \Mpdf\Output\Destination::INLINE);