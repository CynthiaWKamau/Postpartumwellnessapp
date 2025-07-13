<?php
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php'; // Adjust path as needed
include 'db_connection.php';

class AdminPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Admin Report - All Users', 0, 1, 'C');
    }
}

// Create PDF
$pdf = new AdminPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Fetch all users
$sql = "SELECT fullname, email, role, created_at FROM users ORDER BY role, fullname";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, "{$user['fullname']} ({$user['email']})", 0, 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(0, 6, "Role: {$user['role']}\nJoined: {$user['created_at']}", 0, 'L');
        $pdf->Ln(1);
        $pdf->Cell(0, 0, '', 'T');
        $pdf->Ln(3);
    }
} else {
    $pdf->Cell(0, 10, 'No users found.', 0, 1);
}

// Output PDF
$pdf->Output('admin_report.pdf', 'I'); // View in browser
