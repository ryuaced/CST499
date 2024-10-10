<?php
session_start();
require_once 'master.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user profile data
$userData = $dbHandler->executeSelectQuery("SELECT * FROM tblUser WHERE id = ?", [$userId])[0];

// Update profile information if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Update the user's profile
    $updateProfileQuery = "UPDATE tblUser SET firstName = ?, lastName = ?, address = ?, phone = ? WHERE id = ?";
    $dbHandler->executeQuery($updateProfileQuery, [$firstName, $lastName, $address, $phone, $userId]);

    // Refresh profile data
    $userData = $dbHandler->executeSelectQuery("SELECT * FROM tblUser WHERE id = ?", [$userId])[0];
    echo "<p>Profile updated successfully!</p>";
}

// Handle unenrolling from a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_course'])) {
    $courseId = $_POST['course_id'];

    // Remove the course from enrollments
    $removeCourseQuery = "DELETE FROM enrollments WHERE student_id = ? AND course_id = ?";
    $dbHandler->executeQuery($removeCourseQuery, [$userId, $courseId]);

    // Redirect to refresh the page and reflect changes
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch enrolled courses
$enrolledCourses = $dbHandler->executeSelectQuery("
    SELECT c.id as course_id, c.name, c.description, e.enrolled_at 
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    WHERE e.student_id = ?
", [$userId]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Your Profile</h2>

    <!-- Update Profile Form -->
    <form method="POST">
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" name="firstName" value="<?= htmlspecialchars($userData['firstName'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" name="lastName" value="<?= htmlspecialchars($userData['lastName'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($userData['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($userData['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>

    <hr>

    <h3>Your Enrolled Courses</h3>
    <?php if (count($enrolledCourses) > 0): ?>
        <ul>
            <?php foreach ($enrolledCourses as $course): ?>
                <li>
                    <strong><?= htmlspecialchars($course['name']) ?>:</strong>
                    <?= htmlspecialchars($course['description']) ?> (Enrolled on <?= htmlspecialchars($course['enrolled_at']) ?>)
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['course_id']) ?>">
                        <button type="submit" name="remove_course" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You are not enrolled in any courses yet.</p>
    <?php endif; ?>

    <hr>
    <h3>Interested in signing up for courses?</h3>
</div>

<?php

if (isset($_POST['enroll'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_SESSION['user_id'];

    // Check if the course is full
    $courseCapacityQuery = "SELECT capacity, (SELECT COUNT(*) FROM enrollments WHERE course_id = ?) as enrolled FROM courses WHERE id = ?";
    $courseInfo = $dbHandler->executeSelectQuery($courseCapacityQuery, [$course_id, $course_id]);

    if ($courseInfo[0]['enrolled'] >= $courseInfo[0]['capacity']) {
        // Course is full, add to waitlist
        $waitlistQuery = "INSERT INTO waitlist (student_id, course_id) VALUES (?, ?)";
        $dbHandler->executeQuery($waitlistQuery, [$student_id, $course_id]);
        echo "Course is full. You have been added to the waitlist.";
    } else {
        // Enroll student
        $enrollQuery = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
        $dbHandler->executeQuery($enrollQuery, [$student_id, $course_id]);
        echo "You have been successfully enrolled in the course.";
    }

    // Redirect to refresh the page and reflect changes
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Display available courses
$courses = $dbHandler->executeSelectQuery("SELECT * FROM courses");
?>

<div class="container">
    <h2>Available Courses</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Capacity</th>
                <th>Enroll</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $enrolledCourseIds = array_column($enrolledCourses, 'course_id');

            foreach ($courses as $course): 
                $isEnrolled = in_array($course['id'], $enrolledCourseIds); 
            ?>
            <tr>
                <td><?= htmlspecialchars($course['name']); ?></td>
                <td><?= htmlspecialchars($course['capacity']); ?></td>
                <td>
                    <?php if ($isEnrolled): ?>
                        <button class="btn btn-secondary" disabled>Already Enrolled</button>
                    <?php else: ?>
                        <form method="POST">
                            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']); ?>">
                            <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
</body>
</html>
