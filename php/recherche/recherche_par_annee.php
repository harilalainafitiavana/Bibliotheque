<?php
session_start();

$path = '../../';

$query = $_GET['year'];

require_once '../config.php';
require_once '../functions.php';

$filieres = get_filieres_names($conn);
$livres = search_book_by_year($conn, $query);

$conn = null;

require '../partials/book.php';
?>