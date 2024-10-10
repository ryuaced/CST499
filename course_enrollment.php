<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require 'master.php'; // Includes DatabaseHandler

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
    }

    // Display available courses
    $courses = $dbHandler->executeSelectQuery("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Enrollment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

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
            <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= $course['name']; ?></td>
                <td><?= $course['capacity']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
                        <button type="submit" name="enroll" class="btn btn-primary">Enroll</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
</body>
</html>
