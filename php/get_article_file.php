<?php
$article_id = $_GET['id'];
$file_path = "uploads/articles/$article_id.pdf";

if (file_exists($file_path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    readfile($file_path);
    exit;
} else {
    http_response_code(404);
    echo 'Fichier non trouvé.';
}
?>