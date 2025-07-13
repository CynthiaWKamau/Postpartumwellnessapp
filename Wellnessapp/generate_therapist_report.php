<?php
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

include 'db_connection.php';

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Therapist Report - Postpartum Mothers', 0, 1, 'C');
    }
}


// Create PDF
$pdf = new MYPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Fetch postpartum mothers
$sql = "SELECT id, fullname, email FROM users WHERE role = 'postpartum mother'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $user_id = $user['id'];

        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, $user['fullname'] . " ({$user['email']})", 0, 1);

        // Journals
        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 8, 'Journals:', 0, 1);
        $journal_sql = "SELECT entry, date_logged FROM journal_entries WHERE user_id = '$user_id' ORDER BY date_logged DESC";
        $journals = $conn->query($journal_sql);
        if ($journals && $journals->num_rows > 0) {
            while ($j = $journals->fetch_assoc()) {
                $pdf->MultiCell(0, 6, "{$j['date_logged']}: {$j['entry']}", 0, 'L');
            }
        } else {
            $pdf->MultiCell(0, 6, "No journal entries.", 0, 'L');
        }

        // Mood Tracker
        $pdf->Ln(1);
        $pdf->Cell(0, 8, 'Mood Tracker:', 0, 1);
        $mood_sql = "SELECT mood, influencing_factors, notes, date_logged FROM moodtracker WHERE user_id = '$user_id' ORDER BY date_logged DESC";
        $moods = $conn->query($mood_sql);
        if ($moods && $moods->num_rows > 0) {
            while ($m = $moods->fetch_assoc()) {
                $pdf->MultiCell(0, 6, "{$m['date_logged']}: Mood - {$m['mood']} | Factors - {$m['influencing_factors']}\nNotes: {$m['notes']}", 0, 'L');
            }
        } else {
            $pdf->MultiCell(0, 6, "No mood entries.", 0, 'L');
        }

        // Separator
        $pdf->Ln(2);
        $pdf->Cell(0, 0, '', 'T');
        $pdf->Ln(3);
    }
} else {
    $pdf->Cell(0, 10, 'No postpartum mothers found.', 0, 1);
}

// Output PDF
$pdf->Output('therapist_report.pdf', 'I'); // 'I' = inline view, 'D' = force download
