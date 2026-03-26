<?php
$host = "localhost";
$user = "YOUR_DB_USERNAME";
$pass = "YOUR_DB_PASSWORD";
$db   = "riverrun";

// Simple auth (optional)
$USER = "admin";
$PASS = "password";
if(!isset($_SERVER['PHP_AUTH_USER']) || 
   $_SERVER['PHP_AUTH_USER'] != $USER || 
   $_SERVER['PHP_AUTH_PW'] != $PASS){
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized';
    exit;
}

$conn = new mysqli($host,$user,$pass,$db);
if ($conn->connect_error) { die("Connection failed: ".$conn->connect_error); }

// CSV download
if(isset($_GET['download']) && $_GET['download']=='csv'){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=registrations.csv');
    $output = fopen('php://output','w');
    fputcsv($output,array('First Name','Last Name','Age','Sex','DOB','Event','Address','Email','Shirt','Registered At'));
    $res = $conn->query("SELECT * FROM registrations ORDER BY created_at DESC");
    while($row=$res->fetch_assoc()){ fputcsv($output,$row); }
    fclose($output); exit();
}

// Fetch for table
$result = $conn->query("SELECT * FROM registrations ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - FCA River Run</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f4;padding:20px;}
table{width:100%;border-collapse:collapse;margin-top:20px;background:white;}
th, td{padding:10px;border:1px solid #ddd;text-align:center;}
th{background:#2980b9;color:white;}
a.button{display:inline-block;padding:10px 15px;margin-top:15px;background:#27ae60;color:white;text-decoration:none;border-radius:5px;}
a.button:hover{background:#2c3e50;}
</style>
</head>
<body>

<h2>FCA River Run - Registrations</h2>
<a href="?download=csv" class="button">Download as Excel (CSV)</a>

<table>
<tr>
<th>First Name</th><th>Last Name</th><th>Age</th><th>Sex</th><th>DOB</th>
<th>Event</th><th>Address</th><th>Email</th><th>Shirt</th><th>Registered At</th>
</tr>

<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?php echo htmlspecialchars($row['first_name']); ?></td>
<td><?php echo htmlspecialchars($row['last_name']); ?></td>
<td><?php echo $row['age']; ?></td>
<td><?php echo htmlspecialchars($row['sex']); ?></td>
<td><?php echo $row['dob']; ?></td>
<td><?php echo htmlspecialchars($row['event']); ?></td>
<td><?php echo htmlspecialchars($row['address']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><?php echo htmlspecialchars($row['shirt']); ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
<?php $conn->close(); ?>
