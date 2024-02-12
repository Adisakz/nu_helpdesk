<?php
require_once __DIR__ . './mpdf/vendor/autoload.php';
require_once '../dbconfig.php';

///////////  แสดงชื่อด้วยบัตร ปชช id_person 
function name_person($id) {
    global $conn; // Assuming $conn is your database connection variable
  
    $sql_person = "SELECT name_title,first_name,last_name FROM account WHERE id_person = '$id' LIMIT 1";
    $result_person = mysqli_query($conn, $sql_person);
  
    if ($row_person = mysqli_fetch_assoc($result_person)) {
        $person_name = $row_person['name_title'] . $row_person['first_name'].' ' . $row_person['last_name'];
        return $person_name;
    } else {
        $person_name = '.........................';
        return $person_name;
    }
}

////////////  แสดงหน่วยนับพัสดุ
function name_unit($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_unit = "SELECT name FROM unit_parcel WHERE id = '$id' LIMIT 1";
    $result_unit = mysqli_query($conn, $sql_unit);

    if ($row_unit = mysqli_fetch_assoc($result_unit)) {
        $unit = $row_unit['name'];
        return $unit;
    } else {
        $unit = '';
        return $unit;
    }
}

///////////  แสดงหน่วยนับพัสดุ
function unit_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_unit = "SELECT unit_num FROM parcel_data WHERE id_parcel = '$id' LIMIT 1";
    $result_unit = mysqli_query($conn, $sql_unit);

    if ($row_unit = mysqli_fetch_assoc($result_unit)) {
        $unit = name_unit($row_unit['unit_num']);
        return $unit;
    } else {
        $unit = '';
        return $unit;
    }
}

///////////  แสดงชื่อพัสดุ
function name_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name_parcel FROM parcel_data WHERE id_parcel = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name_parcel'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
}

function thaiMonth($month) {
    $months = array(
        '01' => 'มกราคม',
        '02' => 'กุมภาพันธ์',
        '03' => 'มีนาคม',
        '04' => 'เมษายน',
        '05' => 'พฤษภาคม',
        '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม',
        '08' => 'สิงหาคม',
        '09' => 'กันยายน',
        '10' => 'ตุลาคม',
        '11' => 'พฤศจิกายน',
        '12' => 'ธันวาคม'
    );

    return $months[$month];
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$sql = "SELECT * FROM report_req_parcel WHERE close BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59' AND status = 4";
$result = mysqli_query($conn, $sql);
   
    if (mysqli_num_rows($result) > 0) {
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf (
            [
                'fontDir' => array_merge($fontDirs, [
                    __DIR__ . '/font',
                ]), 
                'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabunNew.ttf'
                    ]
                ],
                'default_font' =>'thsarabun'
            ]
        );
        while ($row = mysqli_fetch_assoc($result)) {
            $id_report = $row['id'];
            $date_in = $row['date_in'];
            $department = $row['dapartment_id'];
            $signature_req = $row['signature_req'];
            $id_req = $row['id_req'];
            $signature_parcel = !empty($row['signature_parcel']) ? $row['signature_parcel'] : '';
            $id_parcel = !empty($row['id_parcel']) ? $row['id_parcel'] : '';
            $signature_parcel_head = !empty($row['signature_parcel_head']) ? $row['signature_parcel_head'] : '';
            $id_parcel_head = !empty($row['id_parcel_head']) ? $row['id_parcel_head'] : '';
            $signature_sueccess = !empty($row['signature_success']) ? $row['signature_success'] : '';
            $name_sueccess = !empty($row['name_sueccess']) ? $row['name_sueccess'] : '';
            $comment_cancel = !empty($row['comment_cancel']) ? 'เหตุผลที่ยกเลิก (' . $row['comment_cancel'] . ')' : '';



            $mpdf->AddPageByArray([
                'margin-left' => 20,
                'margin-right' => 20,
                'margin-top' => 20,
                'margin-bottom' => 20,
            ]);

                $data = '
                <div class="main" style=" height: 100%;width:100%;">
                    <div class="top" style=" font-size: 20px; text-align: center; ">
                    <p style="text-align: right;" >ใบเบิกเลขที่....................</p>
                        <h4 style="margin: 1px 0;">ใบเบิกพัสดุภายใน</h4>
                        <h4 style="margin: 1px 0;">คณะพยาบาลศาสตร์ มหาวิทยาลัยขอนแก่น</h4>
                        <p style="margin: 1px 0;">' . date('d', strtotime($date_in)) . ' ' . thaiMonth(date('m', strtotime($date_in))) . ' ' . (date('Y', strtotime($date_in)) + 543) . '</p>
                        <p style="margin-top: 4px">' . name_department($department) . '</p>

                    <table style="border-collapse: collapse; border: 1px solid black; font-size: 20px; margin: 0 auto;">
                        <thead>
                            <tr >
                                <th style="border: 1px solid black; text-align: center;font-weight: normal;">ลำดับที่</th>
                                <th width="400px" style="border: 1px solid black;font-weight: normal;">รายการ</th>
                                <th style="border: 1px solid black; text-align: center;font-weight: normal;">จำนวนที่ต้องการเบิก/หน่วยนับ</th>
                                <th style="border: 1px solid black; text-align: center;font-weight: normal;">รวมเป็นเงิน</th>
                            </tr>
                        </thead>
                        <tbody>';

                $sql_req = "SELECT * FROM list_parcel_req WHERE report_req_id = '$id_report'";
                $result_req = mysqli_query($conn, $sql_req);
                $countNum = 1;

                while ($row = mysqli_fetch_assoc($result_req)) {
                    $data .= '<tr>
                                <td style="border: 1px solid black; text-align: center;">' . $countNum . '</td>
                                <td style="border: 1px solid black;"> ' . name_parcel($row['id_parcel']) . '</td>
                                <td style="border: 1px solid black; text-align: center;">' . $row['qty'] . ' ' . unit_parcel($row['id_parcel']) . '</td>
                                <td style="border: 1px solid black; text-align: center;"></td>
                            </tr>';
                    $countNum++;
                }

                $data .= '</tbody></table></div>

                <div class="bottom" style="text-align: center; margin-top: 20px;">
                    <table style="border-collapse: collapse; border: 1px solid black;font-size: 20px; margin: 0 auto;width:100%;">
                        <tr >       
                        <td style="border: 1px solid black;  padding-top: 20px;">
                            <p style="text-align: left;">ผู้เบิกพัสดุ: <span style="font-weight: normal;">หัวหน้างาน/หัวหน้าหน่วย/หัวหน้าสาขา</span></p>
                            <center>
                                
                                <img src="../image_signature/'. $signature_req.'" alt="signature_parcel_head" width="100px" height="100px" style="margin-bottom: -30px; ">
                                <p>ลงชื่อ ...........................................</p>
                                <p>( '.name_person($id_req).' )</p>
                            </center>
                        </td>
                        <td style="border: 1px solid black;  padding-top: 20px;">
                            <p style="text-align: left;">ผู้อนุมัติจ่ายพัสดุ: <span style="font-weight: normal;">หัวหน้าเจ้าหน้าที่/หัวหน้าพัสดุ</span></p>
                            <center>
                                
                                <img src="../image_signature/'. $signature_parcel_head.'" alt="signature_parcel_head" width="100px" height="100px" style="margin-bottom: -30px; ">
                                <p>ลงชื่อ ...........................................</p>
                                <p>( '.name_person($id_parcel_head).' )</p>
                            </center>
                        </td>
                        </tr>

                        <tr>
                        <td style="border: 1px solid black;  padding-top: 20px;">
                        <p style="text-align: left;">ผู้รับพัสดุ: <span style="font-weight: normal;">ธุรการ/จ.บริหาร/พนักงาน/ผู้ดูแล</span></p>
                        <center>
                            
                            <img src="../image_signature/'. $signature_sueccess.'" alt="signature_parcel_head" width="100px" height="100px" style="margin-bottom: -30px; ">
                            <p>ลงชื่อ ...........................................</p>
                    
                        </center>
                    </td><td style="border: 1px solid black;  padding-top: 20px;">
                    <p style="text-align: left;">ผู้จ่ายพัสดุ : <span style="font-weight: normal;">พัสดุ</span></p>
                    <center>
                        
                        <img src="../image_signature/'. $signature_parcel.'" alt="signature_parcel_head" width="100px" height="100px" style="margin-bottom: -30px; ">
                        <p>ลงชื่อ ...........................................</p>
                        <p>( '.name_person($id_parcel).' )</p>
                    </center>
                </td>
                        </tr>

                    </table>
                </div></div>';
           $mpdf->WriteHTML($data);     
        }
            
    $mpdf->Output('GeneratePDFReq.pdf', \Mpdf\Output\Destination::INLINE);        
    }else{
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf (
            [
                'fontDir' => array_merge($fontDirs, [
                    __DIR__ . '/font',
                ]), 
                'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabunNew.ttf'
                    ]
                ],
                'default_font' =>'thsarabun'
            ]
        );
        $mpdf->AddPageByArray([
            'margin-left' => 20,
            'margin-right' => 20,
            'margin-top' => 20,
            'margin-bottom' => 20,
        ]);
        $data = '<div style="width:100%;text-align:center; font-size:20px;" >ไม่พบข้อมูล</div>';
        $mpdf->WriteHTML($data);  
        $mpdf->Output('GeneratePDFReq.pdf', \Mpdf\Output\Destination::INLINE);  
    }
}
?>
