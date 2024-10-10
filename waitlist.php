<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require 'master.php'; // Includes DatabaseHandler

    // Fetch waitlist
    $waitlistedStudents = $dbHandler->executeSelectQuery("SELECT * FROM waitlist INNER JOIN students ON waitlist.student_id = students.id");

    // Example: Notify the first waitlisted student (logic can be expanded)
    if ($_POST['notify']) {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $dbHandler->executeQuery("DELETE FROM waitlist WHERE student_id = ? AND course_id = ?", [$student_id, $course_id]);
        echo "Student has been notified.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Waitlist Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Waitlisted Students</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Course</th>
                <th>Notify</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($waitlistedStudents as $student): ?>
            <tr>
                <td><?= $student['name']; ?></td>
                <td><?= $student['course_id']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">
                        <input type="hidden" name="course_id" value="<?= $student['course_id']; ?>">
                        <button type="submit" name="notify" class="btn btn-primary">Notify</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
