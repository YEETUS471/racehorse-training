<?php
require '../config/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM horses WHERE id = ?");
$stmt->execute([$id]);
header("Location: index.php");
exit;