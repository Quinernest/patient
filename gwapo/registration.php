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
      </style>

<?php
include 'includes/db_connection.php';

try {
    $conn = connectDB(); // Établir une connexion à la base de données

    //$sql = "SELECT name FROM `users`";
    //$sql = "SELECT date,status FROM `sdate`";
   // Votre requête SQL
   $sql = "SELECT appointment.A_id, users.name, sdate.date, sdate.status 
    FROM appointment
            INNER JOIN users ON appointment.Users_id = users.Users_id
            INNER JOIN sdate ON appointment.s_ID = sdate.s_ID";

    // Exécuter la requête
    $result = $conn->query($sql);

    echo "<table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Calendrier</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>";

    foreach ($result as $row) {
        echo "<tr>
                <td>{$row['A_id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['date']}</td>
                <td>{$row['status']}</td>
                <td><a href='update.php?id={$row['A_id']}' class='edit-button'>Mettre à jour</a></td>
            </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
} finally {
    if ($conn) {
        $conn = null;
    }
}
?>


<div class="button-container">
    <a href="appointment.php" class="add-button">Add Appointment</a>
</div>


<?php
 include_once 'templates/fooder.php';
 
?>
