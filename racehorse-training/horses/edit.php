<?php
require '../config/db.php';
include '../includes/header.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM training_courses WHERE id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    die("Course not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE training_courses 
        SET course_name=?, trainer=?, duration_days=?, intensity=?, start_date=? 
        WHERE id=?");
    $stmt->execute([
        $_POST['course_name'],
        $_POST['trainer'],
        $_POST['duration_days'],
        $_POST['intensity'],
        $_POST['start_date'],
        $id
    ]);
    header("Location: ../horses/view.php?id=" . $course['horse_id']);
    exit;
}
?>

<div class="container">
    <h2>Edit Training Course</h2>
    <form method="post">
        <label>Course Name</label>
        <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required>

        <label>Trainer</label>
        <input type="text" name="trainer" value="<?= htmlspecialchars($course['trainer']) ?>">

        <label>Duration (days)</label>
        <input type="number" name="duration_days" value="<?= $course['duration_days'] ?>" min="1">

        <label>Intensity</label>
        <select name="intensity">
            <option value="Low"     <?= $course['intensity'] === 'Low' ? 'selected' : '' ?>>Low</option>
            <option value="Medium"  <?= $course['intensity'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="High"    <?= $course['intensity'] === 'High' ? 'selected' : '' ?>>High</option>
        </select>

        <label>Start Date</label>
        <input type="date" name="start_date" value="<?= $course['start_date'] ?>">

        <br><br>
        <button type="submit">Update Course</button>
        <a href="../horses/view.php?id=<?= $course['horse_id'] ?>">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>