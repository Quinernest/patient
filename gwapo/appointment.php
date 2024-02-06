<?php 
include_once 'templates/header.php'; 
?>

<style>
        table {
           align-items: center;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .add-button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-button {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .container {
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
}

form {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
}

input {
  width: 97%;
  padding: 8px;
  margin-bottom: 12px;
}

button {
  padding: 10px;
  background-color: #9f9eb4;
  color: #fff;
  border: none;
  cursor: pointer;
}

.button {
  display: inline-block;
  padding: 10px;
  text-decoration: none;
  background-color: #041404;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: 10px;
}


button:hover {
  background-color: #45a049;
}

select{
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  margin-bottom: 10px;
  box-sizing: border-box;
}


table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 50px;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #17ac12;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 8px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.button.edit {
  background-color: #21f34f;
}

.button.delete {
  background-color: #fa1303;
}

      </style>

<div class="container">

    <h2 >Health Care Appointment</h2>

    <!-- Buttons to Access Forms -->
    <a href="patient_form.php" class="button">Add Patients</a>
    <a href="schedule_form.php" class="button">Add Schedules</a>
    <a href="appointment_form.php" class="button">Add Appointments</a>

    <!-- Display Appointments Table -->
    <h2>Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Schedule Date</th>
                <th>Schedule Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the database connection file
            include 'includes/db_connection.php';

            // Fetch appointments
            $sqlAppointments = "SELECT appointments.id, patients.name AS patient_name, schedule.schedule_date, schedule.schedule_time, appointments.status FROM appointments
            INNER JOIN patients ON appointments.patient_id = patients.patient_id
            INNER JOIN schedule ON appointments.schedule_id = schedule.schedule_id";

            $resultAppointments = $db->query($sqlAppointments);

            if ($resultAppointments === FALSE) {
                die("Error executing the query: " . $db->error);
            }

            if ($resultAppointments->num_rows > 0) {
                while ($row = $resultAppointments->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['patient_name']}</td>";
                    echo "<td>{$row['schedule_date']}</td>";
                    echo "<td>{$row['schedule_time']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No appointments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
 include_once 'templates/fooder.php';
 
?>