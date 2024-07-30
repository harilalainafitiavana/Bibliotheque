<?php
session_start();

$path = '';

require_once 'php/config.php';
require_once 'php/functions.php';

$filieres = get_filieres_names($conn);
$livres = get_all_books($conn);

require 'php/partials/book.php';
?>
