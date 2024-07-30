<?php
session_start();

$path = '../../';

$query = '%' . $_GET['query'] . '%';

require_once '../config.php';
require_once '../functions.php';

$filieres = get_filieres_names($conn);
$livres = search_book($conn, $query);

$conn = null;

require '../partials/book.php';
?>
