<?php

include_once 'templates/header.php';

?>
<style>
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
        
        <h2>Schedule Form</h2>

        <?php
        // Include the database connection file
        include 'includes/db_connection.php';

        // Display the edit form if "Edit" button is clicked
        if (isset($_GET['edit'])) {
            // Reopen the database connection for edit form
            $db = new mysqli($servername, $username, $password, $database);

          

            $editId = $_GET['edit'];
            $editResult = $db->query("SELECT * FROM schedule WHERE schedule_id=$editId");

            if ($editResult !== false && $editResult->num_rows == 1) {
                $editRow = $editResult->fetch_assoc();
                ?>
                <!-- Edit form -->
                <h2>Edit Schedule</h2>
                <form action="includes/schedule_process.php" method="post">
                    <input type="hidden" name="schedule_id" value="<?php echo $editRow['schedule_id']; ?>">
                    <label for="schedule_time">Schedule Time:</label>
                    <input type="time" name="schedule_time" value="<?php echo $editRow['schedule_time']; ?>" required>
                    <label for="schedule_date">Schedule Date:</label>
                    <input type="date" name="schedule_date" value="<?php echo $editRow['schedule_date']; ?>" required>
                    <label for="status">Status:</label>
                    <select name="status" required>
                        <option value="vacant" <?php echo ($editRow['status'] == 'vacant') ? 'selected' : ''; ?>>Vacant</option>
                        <option value="occupied" <?php echo ($editRow['status'] == 'occupied') ? 'selected' : ''; ?>>Occupied</option>
                    </select>
                    <button type="submit" name="edit">Update</button>
                </form>
                <?php

              
                $db->close();
                exit(); 
            }

           
            $db->close();
        } else {
           
            ?>
           
            <form action="includes/schedule_process.php" method="post">
                <label for="schedule_time">Schedule Time:</label>
                <input type="time" name="schedule_time" required>
                <label for="schedule_date">Schedule Date:</label>
                <input type="date" name="schedule_date" required>

                <div style="display: flex; align-items: center; margin-top: 10px;">
                <div style="display: flex; align-items: center; margin-top: 10px;">
    <button type="submit" name="add" style="width: 100px; height: 30px; display: flex; align-items: center; justify-content: center; background-color: #4CAF50; color: white; text-decoration: none; border: none; border-radius: 4px; cursor: pointer;">Add</button>
    <a href="appointment.php" class="button" style="width: 100px; height: 30px; display: flex; align-items: center; justify-content: center; background-color: #4CAF50; color: white; text-decoration: none; border: none; border-radius: 4px; cursor: pointer;">Back</a>
</div>

</div>

            </form>
            <?php
        }
        ?>

        <!-- Display added schedules -->
        <h2>Schedules</h2>

        <?php
        // Reopen the database connection for the schedule list
        $db = new mysqli($servername, $username, $password, $database);

       
        // Fetch and display schedule data from the database
        $result = $db->query("SELECT * FROM schedule");

        if ($result !== false && $result->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Schedule Time</th>';
            echo '<th>Schedule Date</th>';
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo "<td>{$row['schedule_time']}</td>";
                echo "<td>{$row['schedule_date']}</td>";
                echo "<td>{$row['status']}</td>";
                echo '<td>';
                echo "<a href='schedule_form.php?edit={$row['schedule_id']}' class='button edit'>Edit</a>";
                echo " | ";
                echo "<a href='includes/schedule_process.php?delete={$row['schedule_id']}' class='button delete'>Delete</a>";
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No schedules found.</p>';
        }

        if ($result !== false) {
            $result->free(); // Free the result set
        }

        // Close the schedule list database connection
        $db->close();
        ?>
    </div>
 <?php

include_once 'templates/fooder.php';

?>