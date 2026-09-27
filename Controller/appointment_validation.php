<?php
require_once '../Model/db_connect.php';

$appointmentList = $pdo->query(
    "SELECT id, patient_name, doctor_name, appointment_date AS date, appointment_time AS time, status
     FROM appointments
     ORDER BY appointment_date DESC, id DESC"
)->fetchAll();
?>