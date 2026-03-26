<?php
$host = "localhost";
$user = "YOUR_DB_USERNAME";
$pass = "YOUR_DB_PASSWORD";
$db   = "riverrun";

$conn = new mysqli($host,$user,$pass,$db);
if ($conn->connect_error) { die("Connection failed: ".$conn->connect_error); }

$stmt = $conn->prepare("INSERT INTO registrations
(first_name,last_name,age,sex,dob,event,address,email,shirt)
VALUES (?,?,?,?,?,?,?,?,?)");

$stmt->bind_param("ssissssss",
  $_POST['first_name'],
  $_POST['last_name'],
  $_POST['age'],
  $_POST['sex'],
  $_POST['dob'],
  $_POST['event'],
  $_POST['address'],
  $_POST['email'],
  $_POST['shirt']
);

$stmt->execute();

echo "<h2>Registration Successful!</h2>
<p>Thank you for registering for the FCA River Run.</p>
<a href='index.html'>Return to Home</a>";

$stmt->close();
$conn->close();
?>
