<?php
require_once __DIR__ . './mpdf/vendor/autoload.php';
require_once '../dbconfig.php';

///////////  แสดงชื่อหมวดหมู่พัสดุ
function name_parcel($id) {
    global $conn; // Assuming $conn is your database connection variable

    $sql_parcel = "SELECT name FROM type_parcel WHERE id = '$id' LIMIT 1";
    $result_parcel = mysqli_query($conn, $sql_parcel);

    if ($row_parcel = mysqli_fetch_assoc($result_parcel)) {
        $parcel = $row_parcel['name'];
        return $parcel;
    } else {
        $parcel = '';
        return $parcel;
    }
}


///////////  แสดงหน่วนับพัสดุ
function unit_parcel($id) {
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

$selectedIds = $_POST['selectedIds'];

// ตรวจสอบว่าค่าที่ส่งมาเป็น 'all' หรือไม่
if (in_array('all', $selectedIds)) {
    // ถ้าเป็น 'all' ให้แสดง SQL ทั้งหมด
    $sql = "SELECT *  FROM parcel_data";
} else {
    // ถ้าไม่ใช่ 'all' ให้ทำการแปลง array ของ selectedIds เป็น string เพื่อให้ใช้ได้ใน SQL
    $selectedIdsString = implode(',', $selectedIds);

    $sql = "SELECT *  FROM parcel_data WHERE id_parcel IN ($selectedIdsString)";
}

$result = mysqli_query($conn, $sql);

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
    'margin-left' => 0,
    'margin-right' => 0,
    'margin-top' => 0,
    'margin-bottom' => 0,
]);

$data = '
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        font-size: 18px; /* ปรับขนาดตัวอักษรตามต้องการ */
    }
</style>
<table class="table table-striped projects">
    <thead>
        <tr>

            <th class="text-center">
                หมวดหมู่พัสดุ
            </th>
            <th class="text-center">
                ชื่อพัสดุ
            </th>
            <th class="text-center">
                หน่วยนับ
            </th>
            <th class="text-center">
                Qr-code
            </th>
        </tr>
    </thead>
    <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $data .= '
        <tr>
            <td class="text-center">' . name_parcel($row['type']) . '</td>
            <td class="text-center">' . $row['name_parcel'] . '</td>
            <td class="text-center">' . unit_parcel($row['unit_num']) . '</td>
            <td class="text-center"><img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='. $row['id_qr'] .'" alt="" style="100%"></td>
        </tr>';
}

$data .= '
    </tbody>
</table>
</div>';

$mpdf->WriteHTML($data);

$mpdf->Output('GeneratePDF.pdf', \Mpdf\Output\Destination::INLINE);
?>
