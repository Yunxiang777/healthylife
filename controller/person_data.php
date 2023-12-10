<?php
require_once __DIR__ . '/../model/update_member_data.php';
$Update_member_data = new Update_member_data();

//處理頭像更新，並且更新資料庫
if (isset($_FILES["photo"])) {
    //圖片上傳
    $profile_message = upload_profile();
    print_r($profile_message);
    if ($profile_message['file_name']) {
        //資料庫更新
        $result = $Update_member_data->update_image($profile_message);
        if ($result) {
            echo true;
            exit();
        } else {
            echo false;
            exit();
        }
    } else {
        echo false;
        exit();
    }
}

// 定義欄位規則
$fieldRules = [
    'name' => '姓名',
    'age' => '年齡',
    'address' => '住址',
    'height' => '身高',
    'weight' => '體重',
    'gender' => '性別',
    'profession' => '職業',
    'phone' => '手機',
];

//判定輸入內容不能為空值
if (error_message($fieldRules)) {
    print_r(error_message($fieldRules));
    exit();
}

// 判定特定欄位是否為正確數字格式
validate_numeric_format('age');
validate_numeric_format('height');
validate_numeric_format('weight');
validate_numeric_format('phone');

//處裡表單的資料更新
if ($_POST['update_member_data']) {
    $result = $Update_member_data->update_data($_POST);
    if (!$result) {
        echo "資料處裡失敗";
        exit();
    }
}

/**
 * 檢查使用者 POST 資料是否不為空，並生成相應的錯誤訊息。
 *
 * @param array $fieldRules 關聯陣列，包含各個欄位的規則，格式為 ['欄位名稱' => '欄位標籤', ...]
 * @return array 關聯陣列，包含錯誤訊息，格式為 ['欄位名稱' => '錯誤訊息', ...]。如果沒有錯誤，則返回空陣列。
 */
function error_message($fieldRules)
{
    // 初始化錯誤訊息陣列
    $errorMessages = [];

    // 檢查每個欄位是否為空
    foreach ($fieldRules as $field => $label) {
        if (empty($_POST[$field])) {
            $errorMessages[$field] = $label . '欄位不能為空';
        }
    }

    return $errorMessages;
}

/**
 * 驗證指定欄位的數字格式，並生成相應的錯誤訊息。
 *
 * @param string $field 欄位名稱
 * @return void 如果輸入的數值不是有效的數字格式，則生成錯誤訊息並終止腳本執行。
 */
function validate_numeric_format($field)
{
    if (!is_numeric($_POST[$field])) {
        $errorMessages = [
            $field => '請輸入正確數字格式',
        ];
        print_r($errorMessages);
        exit();
    }
}

/**
 * 個人大頭貼上傳到指定目錄
 *
 * @return array 會員id與大頭貼檔名
 */
function upload_profile()
{
    $member_id = $_POST["member_id"];

    // 指定上傳目錄
    $uploadDir = __DIR__ . '/../upload/profile/';

    // 檔案名稱為 member_id 加上檔案原始擴展名
    $fileName = $member_id . '_profile.' . pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
    $uploadFile = $uploadDir . $fileName;

    // 如果目錄內已存在相同檔名的檔案，先刪除原有的檔案
    if (file_exists($uploadFile)) {
        unlink($uploadFile);
    }

    // 移動上傳的檔案到指定目錄
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadFile)) {
        $profile_message = array(
            'file_name' => $fileName,
            'member_id' => $member_id
        );
        return $profile_message;
    } else {
        return false;
    }
}
