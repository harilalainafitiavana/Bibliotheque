<?php
require_once '../config.php';

$id = $_GET['id'];

$sql = 'DELETE FROM utilisateurs WHERE id = :id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: utilisateurs');
