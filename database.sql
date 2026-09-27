CREATE DATABASE IF NOT EXISTS hospital_appointment_system
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE hospital_appointment_system;

CREATE TABLE IF NOT EXISTS patients (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS doctors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS appointments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_name VARCHAR(100) NOT NULL,
    doctor_name VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(20) NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_appointments_date (appointment_date),
    INDEX idx_appointments_status (status)
) ENGINE=InnoDB;

INSERT IGNORE INTO patients (id, name, phone, dob, gender, email, password) VALUES
    (1, 'Palash', '01246631416', '2026-08-12', 'male', 'palash@gmail.com', 'palash'),
    (2, 'Mehedi', '01246631417', '2026-08-13', 'male', 'mehedi@gmail.com', 'mehedi123'),
    (3, 'Mahabub Sourov', '01737239924', '2004-01-05', 'male', 'mahabubsourov555@gmail.com', '12345');

INSERT IGNORE INTO admins (id, name, email, username, password) VALUES
    (1, 'Mushfiq', 'mushfiq@gmail.com', 'mushfiq', 'mushfiq123'),
    (2, 'Mahabub', 'mahabubsourov555@gmail.com', 'mahabub', 'mahabub12345');

INSERT IGNORE INTO doctors (id, name, specialization, email, username, password, phone) VALUES
    (1, 'Dr. Ayesha Rahman', 'Cardiologist', 'ayesha.rahman@gmail.com', 'ayesha.rahman', '12345', '01711000001'),
    (2, 'Dr. Kamal Hossain', 'Dermatologist', 'kamal.hossain@gmail.com', 'kamal.hossain', '12345', '01711000002'),
    (3, 'Dr. Nusrat Jahan', 'Pediatrician', 'nusrat.jahan@gmail.com', 'nusrat.jahan', '12345', '01711000003'),
    (4, 'Dr. Rafiul Islam', 'Orthopedic Surgeon', 'rafiul.islam@gmail.com', 'rafiul.islam', '12345', '01711000004'),
    (5, 'Dr. Farhana Akter', 'Neurologist', 'farhana.akter@gmail.com', 'farhana.akter', '12345', '01711000005'),
    (6, 'Dr. Sourov', 'General Physician', 'sourov@gmail.com', 'sourov', '12345', '01711000006');

INSERT IGNORE INTO appointments (id, patient_name, doctor_name, appointment_date, appointment_time, status) VALUES
    (1, 'Tanvir Ahmed', 'Dr. Ayesha Rahman', '2026-08-25', '10:00 AM', 'Confirmed'),
    (2, 'Sadia Islam', 'Dr. Kamal Hossain', '2026-08-26', '11:30 AM', 'Pending'),
    (3, 'Mahin Chowdhury', 'Dr. Nusrat Jahan', '2026-08-27', '09:15 AM', 'Completed'),
    (4, 'Nabila Haque', 'Dr. Rafiul Islam', '2026-08-28', '02:00 PM', 'Cancelled'),
    (5, 'Imran Kabir', 'Dr. Farhana Akter', '2026-08-29', '04:45 PM', 'Confirmed');