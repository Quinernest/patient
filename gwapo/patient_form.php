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

<?php
    // Include the database connection file
    include 'includes/db_connection.php';

    // Initialize variables for the edit form
    $editMode = false;
    $editId = '';
    $editName = '';
    $editEmail = '';

    // Check if edit button is clicked
    if (isset($_GET['edit'])) {
        $editId = $_GET['edit'];
        $editMode = true;

        // Fetch data of the selected patient for editing
        $result = $db->query("SELECT * FROM patients WHERE patient_id = $editId");

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $editName = $row['name'];
            $editEmail = $row['email'];
        }
    }

    // Process form submission for adding new patient
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];

        $stmt = $db->prepare("INSERT INTO patients (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the patient form
        header("Location: patient_form.php");
        exit();
    }

    // Process form submission for editing existing patient
    if (isset($_POST['edit'])) {
        $id = $_POST['patient_id']; // Change 'id' to 'patient_id'
        $name = $_POST['name'];
        $email = $_POST['email'];

        $stmt = $db->prepare("UPDATE patients SET name=?, email=? WHERE patient_id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the patient form
        header("Location: patient_form.php");
        exit();
    }

    // Fetch and display patient data from the database
    $result = $db->query("SELECT * FROM patients");

    ?>

        <div class="container">
            <?php if (!$editMode): ?>
                <h2>Patient Form</h2>
                <!-- Form to add new patient -->
                <form action="patient_form.php" method="post">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>

                    <!-- Add button and Back link in the same form -->
                    <button type="submit" name="add" style="width: 100px; height: 30px; background-color: #4CAF50; color: white; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">Add</button>
<a href="appointment.php" class="button" style="width: 100px; height: 30px; background-color: #4CAF50; color: white; text-decoration: none; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;">Back</a>


                </form>

            <?php endif; ?>

            <?php if ($editMode): ?>
                <!-- Form to edit existing patient -->
                <h2>Edit Patient</h2>
                <form action="patient_form.php" method="post">
                    <input type="hidden" name="patient_id" value="<?php echo $editId; ?>"> <!-- Change 'id' to 'patient_id' -->
                    <label for="name">Name:</label>
                    <input type="text" name="name" value="<?php echo $editName; ?>" required>
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $editEmail; ?>" required>
                    <button type="submit" name="edit">Edit</button>
                </form>
            <?php endif; ?>

            <!-- Display added patients -->
            <h2>Patients</h2>

            <?php
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Email</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td><a href='patient_form.php?edit={$row['patient_id']}' class='button edit'>Edit</a> | <a href='includes/patient_process.php?delete={$row['patient_id']}' class='button delete'>Delete</a>";
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No patients found.</p>';
            }

            $result->free(); // Free the result set
            ?>
        
        </div>
  

    <?php
    $db->close();
    ?>

    <?php

include_once 'templates/fooder.php';

?>
