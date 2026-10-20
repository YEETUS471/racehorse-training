<?php
require '../config/db.php';
include '../includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM horses WHERE id = ?");
$stmt->execute([$id]);
$horse = $stmt->fetch();

if (!$horse) { die("Horse not found"); }

$courses = $pdo->prepare("SELECT * FROM training_courses WHERE horse_id = ? ORDER BY id DESC");
$courses->execute([$id]);
$courses = $courses->fetchAll();
?>
<div class="container">
    <h2><?= htmlspecialchars($horse['name']) ?> – Training Courses</h2>
    <p>Owner: <?= htmlspecialchars($horse['owner_name']) ?> | Breed: <?= htmlspecialchars($horse['breed']) ?></p>
    
    <a href="../courses/create.php?horse_id=<?= $id ?>" class="btn">+ Add Training Course</a>
    <a href="index.php">← Back to all horses</a>

    <table>
        <tr>
            <th>ID</th><th>Course Name</th><th>Trainer</th><th>Duration</th><th>Intensity</th><th>Start Date</th><th>Actions</th>
        </tr>
        <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['course_name']) ?></td>
            <td><?= htmlspecialchars($c['trainer']) ?></td>
            <td><?= $c['duration_days'] ?> days</td>
            <td><?= $c['intensity'] ?></td>
            <td><?= $c['start_date'] ?></td>
            <td>
                <a href="../courses/edit.php?id=<?= $c['id'] ?>">Edit</a> |
                <a href="../courses/delete.php?id=<?= $c['id'] ?>&horse_id=<?= $id ?>" onclick="return confirm('Delete this course?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>