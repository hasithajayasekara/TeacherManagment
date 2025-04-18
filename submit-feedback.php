<?php
$host = 'localhost';
$db = 'teacherbase';
$user = 'root';       // your MySQL username
$pass = '';           // your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$studentName = $_POST['studentName'];
$teacher = $_POST['teacher'];
$clarity = $_POST['clarity'];
$interaction = $_POST['interaction'];
$satisfaction = $_POST['satisfaction'];
$punctuality = $_POST['punctuality'];
$knowledge = $_POST['knowledge'];
$teachingAids = $_POST['teachingAids'];
$availability = $_POST['availability'];
$motivation = $_POST['motivation'];
$comments = $_POST['comments'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (studentName, teacher, clarity, interaction, satisfaction, punctuality, knowledge, teachingAids, availability, motivation, comments)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssiiiiiiiss", $studentName, $teacher, $clarity, $interaction, $satisfaction, $punctuality, $knowledge, $teachingAids, $availability, $motivation, $comments);

if ($stmt->execute()) {
  echo "<h2 style='text-align:center;color:green;'>Feedback submitted successfully!</h2>";
} else {
  echo "<h2 style='text-align:center;color:red;'>Error: " . $stmt->error . "</h2>";
}

$stmt->close();
$conn->close();
?>
