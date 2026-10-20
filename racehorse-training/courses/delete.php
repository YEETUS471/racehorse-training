<?php
require '../config/db.php';

$id = $_GET['id'] ?? 0;
$horse_id = $_GET['horse_id'] ?? 0;

$stmt = $pdo->prepare("DELETE FROM training_courses WHERE id = ?");
$stmt->execute([$id]);

header("Location: ../horses/view.php?id=" . $horse_id);
exit;