<?php
include '../Controller/patient_validation.php';
require_once '../Model/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["makeApp"])) {
    $doctorName = trim($_POST["doctor"] ?? "");
    $appointmentDate = trim($_POST["appointmentDate"] ?? "");
    $bookingPatientName = trim($_POST["patientName"] ?? "");

    if ($doctorName !== "" && $appointmentDate !== "" && $bookingPatientName !== "") {
        $insert = $pdo->prepare(
            "INSERT INTO appointments (patient_name, doctor_name, appointment_date, appointment_time, status)
             VALUES (:patient_name, :doctor_name, :appointment_date, :appointment_time, 'Pending')"
        );
        $insert->execute([
            "patient_name" => $bookingPatientName,
            "doctor_name" => $doctorName,
            "appointment_date" => $appointmentDate,
            "appointment_time" => "To be confirmed",
        ]);
    }
}

header("Location: my_appointment.php?booked=1");
exit;
?>