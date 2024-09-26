<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

if (isset($_GET['product_name'])) {
    $productName = trim($_GET['product_name']);
    
    // Получение ИКПУ
    $searchUrl = "https://tasnif.soliq.uz/api/cls-api/mxik/search-subposition?search_text=" . urlencode($productName) . "&page=0&size=15&lang=ru";
    
    $searchResponse = file_get_contents($searchUrl);
    $searchData = json_decode($searchResponse, true);

    if (isset($searchData['data'][0])) {
        $mxikCode = $searchData['data'][0]['mxikCode'];

        // Получение кода упаковки
        $packageUrl = "https://tasnif.soliq.uz/api/cls-api/mxik/get/by-mxik?mxikCode=" . urlencode($mxikCode) . "&lang=ru";
        
        $packageResponse = file_get_contents($packageUrl);
        $packageData = json_decode($packageResponse, true);

        if (isset($packageData['packages'][0])) {
            $packageCode = $packageData['packages'][0]['code'];
            echo json_encode(['mxikCode' => $mxikCode, 'packageCode' => $packageCode]);
        } else {
            echo json_encode(['error' => true, 'message' => 'Код упаковки не найден.']);
        }
    } else {
        echo json_encode(['error' => true, 'message' => 'Товар не найден.']);
    }
} else {
    echo json_encode(['error' => true, 'message' => 'Некорректный запрос.']);
}
?>