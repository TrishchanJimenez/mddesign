<?php
require_once "../db_connection.php";
require "../phpmailer/src/PHPMailer.php";
require "../phpmailer/src/SMTP.php";
require "../phpmailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
    exit;
}

// Validate input
$inquiryId = $_POST['inquiry_id'] ?? null;
$replyMessage = $_POST['reply_message'] ?? null;

if (!$inquiryId || !$replyMessage) {
    http_response_code(400); // Bad Request
    echo json_encode(["success" => false, "error" => "Inquiry ID and reply message are required."]);
    exit;
}

// Fetch the customer's email and name
$query = "SELECT users.email, CONCAT(users.first_name, ' ', users.last_name) AS customer_name 
          FROM inquiries 
          JOIN users ON inquiries.user_id = users.id 
          WHERE inquiries.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $inquiryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    $customerEmail = $customer['email'];
    $customerName = $customer['customer_name'];

    // Send the reply email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'aiko.careerai@gmail.com'; // Replace with your email
        $mail->Password = 'vtdi memf nqdo yxbx'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('email@gmail.com', 'Metro District Designs');
        $mail->addAddress($customerEmail, $customerName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Reply to Your Inquiry (ID: $inquiryId)";
        $mail->Body = "<p>Dear $customerName,</p><p>$replyMessage</p><p>Best regards,<br>Metro District Designs</p>";

        $mail->send();
        echo json_encode(["success" => true, "message" => "Reply sent successfully."]);
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        http_response_code(500); // Internal Server Error
        echo json_encode(["success" => false, "error" => "Failed to send reply."]);
    }
} else {
    http_response_code(404); // Not Found
    echo json_encode(["success" => false, "error" => "Inquiry not found."]);
}

$stmt->close();
?>