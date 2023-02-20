<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL</title>
</head>
<body>
    <?php

    $servername="localhost";
    $username="root";
    $password="";
    $dbname="myDB";

    // $conn = new mysqli($servername, $username, $password);
    $conn = new mysqli($servername, $username, $password, $dbname);
    // server name, user name, password, database, port, socket

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Connection
        // echo("Connected Succesfully!");

        // Create Database
        // $sql = "CREATE DATABASE myDB";

        // if($conn->query($sql) === TRUE){
        //     echo("Database created successfully");
        // } else {
        //     echo("Error creating database." . $conn->error);
        // }

        // $conn->close();

        // Create Table
        // $sql = "CREATE TABLE MyGuests (
        //     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     firstname VARCHAR(30) NOT NULL,
        //     lastname VARCHAR(30) NOT NULL,
        //     email VARCHAR(50),
        //     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        // )";

        // if($conn->query($sql) === TRUE){
        //     echo("Table MyGuests created successfully");
        // } else {
        //     echo("Error creating table." . $conn->error);
        // }

        // $conn->close();

        // Insert into Table
        // $sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Juan', 'Dela Cruz', 'JuanDC@gmail.com')";

        // if($conn->query($sql) === TRUE){
        //     echo("New record created successfully");
        // } else {
        //     echo("Error: " . $sql . "<br>" . $conn->error);
        // }

        // $conn->close();

        // Get ID of latest entry
        $sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Diego', 'Diaz', 'ddiaz@yahoo.com')";

        if($conn->query($sql) === TRUE){
            $last_id = $conn->insert_id;
            echo("New record created successfully. Last inserted ID is: " . $last_id);
        } else {
            echo("Error: " . $sql . "<br>" . $conn->error);
        }

        $conn->close();
    }
    ?>
</body>

</html>
