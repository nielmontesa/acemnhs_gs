<?php
// Fetch data
$sql = "SELECT id, first_name, last_name, email, department_id FROM teachers";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'name' => $row['first_name'] . ' ' . $row['last_name'],
            'email' => $row['email'],
            'department' => $row['department_id'], // Adjust if department name needs to be fetched
        ];
    }
}

// Create the PDF
$pdf = new PDF();
$pdf->AddPage();

// Add table header
$pdf->TableHeader();

// Add data
$pdf->TableBody($data);

// Output the PDF
$pdf->Output();
?>
