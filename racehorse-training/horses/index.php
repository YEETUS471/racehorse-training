<?php
require '../config/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM horses ORDER BY id DESC");
$horses = $stmt->fetchAll();
?>
<div class="container">
    <h2>All Racehorses (Parent Entity)</h2>
    <a href="create.php" class="btn">+ Register New Horse</a>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Owner</th><th>Breed</th><th>Age</th><th>Actions</th>
        </tr>
        <?php foreach ($horses as $h): ?>
        <tr>
            <td><?= $h['id'] ?></td>
            <td><?= htmlspecialchars($h['name']) ?></td>
            <td><?= htmlspecialchars($h['owner_name']) ?></td>
            <td><?= htmlspecialchars($h['breed']) ?></td>
            <td><?= $h['age'] ?></td>
            <td>
                <a href="view.php?id=<?= $h['id'] ?>">View Courses</a> |
                <a href="edit.php?id=<?= $h['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $h['id'] ?>" onclick="return confirm('Delete this horse and all its courses?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>