<?php
//detects where errors are
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Update path if needed
include 'db_connection.php';

date_default_timezone_set('Africa/Nairobi');

echo "Script started<br>";

// Fetch appointments for tomorrow
$tomorrow = (new DateTime())->modify('+1 day')->format('Y-m-d');
$query = "SELECT fullname, email, appointment_date, appointment_time FROM book_appointment WHERE appointment_date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $tomorrow);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No appointments for tomorrow.<br>";
}

while ($row = $result->fetch_assoc()) {
    echo "Preparing to send to: {$row['email']}<br>";
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ck697315@gmail.com'; // your Gmail
        $mail->Password   = 'nxhejtxupexkwegm'; // app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('ck697315@gmail.com', 'Lunacaremailer');
        $mail->addAddress($row['email'], $row['fullname']);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->Subject = '🧠 Therapy Appointment Reminder – Luna Care';
        $mail->Body    = "
            Hello {$row['fullname']},<br><br>
            This is a friendly reminder for your upcoming therapy appointment:<br>
            📅 <strong>Date:</strong> {$row['appointment_date']}<br>
            ⏰ <strong>Time:</strong> {$row['appointment_time']}<br><br>
            With care,<br><strong>Luna Care Team 💖</strong>
        ";

        $mail->send();
        echo "✅ Email sent to {$row['email']}<br>";
    } catch (Exception $e) {
        echo "❌ Email failed to {$row['email']}: {$mail->ErrorInfo}<br>";
    }
}
