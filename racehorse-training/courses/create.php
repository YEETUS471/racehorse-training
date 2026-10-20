<?php
require '../config/db.php';
include '../includes/header.php';

$horse_id = $_GET['horse_id'] ?? 0;

// Check if horse exists
$stmt = $pdo->prepare("SELECT name FROM horses WHERE id = ?");
$stmt->execute([$horse_id]);
$horse = $stmt->fetch();
if (!$horse) {
    die("Horse not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO training_courses 
        (horse_id, course_name, trainer, duration_days, intensity, start_date) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['horse_id'],
        $_POST['course_name'],
        $_POST['trainer'],
        $_POST['duration_days'],
        $_POST['intensity'],
        $_POST['start_date']
    ]);
    header("Location: ../horses/view.php?id=" . $_POST['horse_id']);
    exit;
}
?>

<style>
    .create-layout {
        display: flex;
        gap: 30px;
        margin-top: 20px;
    }
    .course-sidebar {
        width: 280px;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        border: 1px solid #ddd;
    }
    .course-sidebar h3 {
        margin-top: 0;
        font-size: 1.1rem;
        color: #333;
    }
    .course-option {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .course-option:hover {
        border-color: #4CAF50;
        background: #f0fff0;
        transform: translateX(4px);
    }
    .course-option strong {
        display: block;
        color: #2c3e50;
    }
    .course-option small {
        color: #666;
    }
    .form-area {
        flex: 1;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
    }
</style>

<div class="container">
    <h2>Add Training Course for: <em><?= htmlspecialchars($horse['name']) ?></em></h2>
    <a href="../horses/view.php?id=<?= $horse_id ?>">← Back to horse</a>

    <div class="create-layout">
        <!-- SIDE SELECTION PANEL -->
        <div class="course-sidebar">
            <h3>Quick Select Courses</h3>
            <p style="font-size:0.9rem;color:#666;">Click a course to fill the form →</p>

            <div class="course-option" onclick="selectCourse('Speed Training', 'Track Coach', 7, 'High')">
                <strong>Speed Training</strong>
                <small>Focus on acceleration & top speed</small>
            </div>

            <div class="course-option" onclick="selectCourse('Stamina Drill', 'Endurance Coach', 10, 'High')">
                <strong>Stamina Drill</strong>
                <small>Long-distance endurance work</small>
            </div>

            <div class="course-option" onclick="selectCourse('Power Training', 'Strength Coach', 5, 'Medium')">
                <strong>Power Training</strong>
                <small>Muscle & explosive power</small>
            </div>

            <div class="course-option" onclick="selectCourse('Guts Training', 'Mental Coach', 4, 'Medium')">
                <strong>Guts Training</strong>
                <small>Willpower & late-race push</small>
            </div>

            <div class="course-option" onclick="selectCourse('Wit Training', 'Strategy Coach', 6, 'Low')">
                <strong>Wit Training</strong>
                <small>Race IQ & positioning</small>
            </div>

            <div class="course-option" onclick="selectCourse('Recovery / Rest Day', 'Physio', 2, 'Low')">
                <strong>Recovery / Rest Day</strong>
                <small>Light recovery session</small>
            </div>

            <div class="course-option" onclick="selectCourse('Race Simulation', 'Main Trainer', 3, 'High')">
                <strong>Race Simulation</strong>
                <small>Full race practice</small>
            </div>
        </div>

        <!-- FORM AREA -->
        <div class="form-area">
            <h3>Course Details</h3>
            <form method="post" id="courseForm">
                <input type="hidden" name="horse_id" value="<?= $horse_id ?>">

                <label>Course Name</label>
                <input type="text" name="course_name" id="course_name" required placeholder="Click a course on the left or type your own">

                <label>Trainer</label>
                <input type="text" name="trainer" id="trainer" placeholder="e.g. Track Coach">

                <label>Duration (days)</label>
                <input type="number" name="duration_days" id="duration_days" min="1" value="5">

                <label>Intensity</label>
                <select name="intensity" id="intensity">
                    <option value="Low">Low</option>
                    <option value="Medium" selected>Medium</option>
                    <option value="High">High</option>
                </select>

                <label>Start Date</label>
                <input type="date" name="start_date" value="<?= date('Y-m-d') ?>">

                <br><br>
                <button type="submit">Add This Course</button>
            </form>
        </div>
    </div>
</div>

<script>
function selectCourse(name, trainer, days, intensity) {
    document.getElementById('course_name').value = name;
    document.getElementById('trainer').value = trainer;
    document.getElementById('duration_days').value = days;
    document.getElementById('intensity').value = intensity;

    // Optional: small visual feedback
    document.querySelectorAll('.course-option').forEach(el => el.style.borderColor = '#e0e0e0');
    event.currentTarget.style.borderColor = '#4CAF50';
}
</script>

<?php include '../includes/footer.php'; ?>