<?php



// Allow requests from any origin
header("Access-Control-Allow-Origin: *");
// Allow specified headers
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Allow specified methods
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// If the request method is OPTIONS, send back a 200 OK status
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = file_get_contents('php://input');
    $json = json_decode($file);
    if(isset($json->image)) {
        $base64_string = str_replace('data:image/jpeg;base64,', '', $json->image);
        $decoded_image = base64_decode($base64_string);
        $filename = 'captured_image_' . uniqid() . '.jpeg';
        $upload_path = "../iii/".$filename;
        $file2 = fopen($upload_path, 'wb');
        fwrite($file2, $decoded_image);
        fclose($file2);
    }
    http_response_code(200);
    echo json_encode("Done");
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
}
?>
