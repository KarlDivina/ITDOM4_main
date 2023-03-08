<?php 
    session_start(); 
    // session_destroy();

    // INSERT
    // $sql = "INSERT INTO `studentdetails`(`StudentNumber`, `Name`, `Bday`, `Course`, `Contact_Number`, `Email_Address`) VALUES ( 2014200123, \'Karl Divina\', \'2000-12-23\', \'BSIT\', 09682772407, \'divinakarlangelo@gmail.com\');";

    // SELECT by StudentNumber
    // $sql = "SELECT * FROM `studentdetails` WHERE StudentNumber = \'2014200123\';";

    // SELECT by Email_Address
    // $sql = "SELECT * FROM `studentdetails` WHERE Email_Address = \'divinakarlangelo@gmail.com\';";

    // REGEX?!
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karl D : Register</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
</head>
<body class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg" style="background-color: pink;">
            <div class="container-fluid d-flex justify-content-center">
                <a class="navbar-brand" href="homePage.php">
                    <img src="../assets/logo.png" alt="">
                </a>
            </div>
            </nav>
        </div>
    </div>

    <?php
        $CREDENTIALS = $_SESSION['CREDENTIALS'];

        function printRegister(){
            ?>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="row card-login">
                        <div class="col-12 mt-4"><h2>Register</h2></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="registerPage.php"
                                    enctype="multipart/form-data"
                                >
                                    <p>
                                        First Name: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="name_first"
                                        />
                                    </p>
                                    <p>
                                        Last Name: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="name_last"
                                        />
                                    </p>
                                    <p>
                                        Student Number: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="student_num"
                                        />
                                    </p>
                                    <p>
                                        Email Address: 
                                        <input
                                            type="email"
                                            class="form-control form-rounded"
                                            name="email"
                                        />
                                    </p>
                                    <p>
                                        Date of Birth: 
                                        <input
                                            type="date"
                                            class="form-control form-rounded"
                                            name="birthday"
                                        />
                                    </p>
                                    <p>
                                        Course: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="course"
                                        />
                                    </p>
                                    <p>
                                        Contact Number: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="contact_num"
                                        />
                                    </p>
                                    <p>
                                        Profile Picture: 
                                        <input 
                                            type="file" 
                                            class="form-control form-rounded"
                                            name="image" 
                                        />
                                    </p>
                                    <p>
                                        Username: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="username"
                                        />
                                    </p>
                                    <p>
                                        Password: 
                                        <input
                                            type="password"
                                            class="form-control form-rounded"
                                            name="password"
                                        />
                                    </p>
                                    <p>
                                        <input 
                                            type="submit"
                                            name="register_user"
                                            class="btn"
                                            value="Register"
                                            style="color: white; background-color: #80b444"
                                        />
                                    </p>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
            <?php
        }

        function printError(){
            ?>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="row card-login">
                        <div class="col-12 mt-4"><h3 style="color: red;">Invalid Details</h3></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="registerPage.php"
                                >
                                    <p>
                                        First Name: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="name_first"
                                            placeholder="<?php echo $_SESSION['ERR_FNAME']?>"
                                            value="<?php if(!empty($_POST['name_first'])){
                                                echo($_POST['name_first']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        Last Name: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="name_last"
                                            placeholder="<?php echo $_SESSION['ERR_LNAME']?>"
                                            value="<?php if(!empty($_POST['name_last'])){
                                                echo($_POST['name_last']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        Student Number: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="student_num"
                                        />
                                    </p>
                                    <p>
                                        Email Address: 
                                        <input
                                            type="email"
                                            class="form-control form-rounded"
                                            name="email"
                                        />
                                    </p>
                                    <p>
                                        Date of Birth: 
                                        <input
                                            type="date"
                                            class="form-control form-rounded"
                                            name="birthday"
                                        />
                                    </p>
                                    <p>
                                        Course: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="course"
                                        />
                                    </p>
                                    <p>
                                        Contact Number: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="contact_num"
                                        />
                                    </p>
                                    <p>
                                        Username: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="username"
                                            placeholder="<?php echo $_SESSION['ERR_UNAME']?>"
                                            value="<?php if(!empty($_POST['username'])){
                                                echo($_POST['username']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        Password: 
                                        <input
                                            type="password"
                                            class="form-control form-rounded"
                                            name="password"
                                            placeholder="<?php echo $_SESSION['ERR_PASS']?>"
                                        />
                                    </p>
                                    <p>
                                        <input 
                                            type="submit"
                                            name="register_user"
                                            class="btn"
                                            value="Register"
                                            style="color: white; background-color: #80b444"
                                        />
                                    </p>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
            <?php
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST[$_SESSION['FUNCTIONS']["F6"]])){ //register user
                printRegister();
            } else {
                //fit guideline
                // pass must be x alphanumeric chars long including at least one special char | check + display
                $providedFirstName = $_POST['name_first'];
                $providedLastName = $_POST['name_last'];
                $providedFullName = $providedFirstName . " " . $providedLastName;
                $providedStudentNumber = $_POST['student_num'];
                $providedEmail = $_POST['email'];
                $providedBirthday = $_POST['birthday'];
                $providedCourse = $_POST['course'];
                $providedContactNumber = $_POST['contact_num'];
                $providedUsername = $_POST['username'];
                $providedPassword = $_POST['password'];

                if(!$error = checkDetails($providedFirstName, $providedLastName, $providedUsername, $providedPassword)){
                    if($error = checkUser($CREDENTIALS, $providedUsername)){
                        // echo("user is valid");
                        $index = count($CREDENTIALS);
                        $servername="localhost";
                        $username="root";
                        $password="";
                        $dbname="schooldb";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if($conn->connect_error){
                            die("Connection failed: " . $conn->connect_error);
                        } else {
                            $target_dir = "../assets/";
                            $target_file = $target_dir . basename($_FILES["image"]["name"]);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if($check == false && 
                            $_FILES["image"]["size"] > 500000 && 
                            $imageFileType != "jpg" && 
                            $imageFileType != "png" && 
                            $imageFileType != "jpeg" && 
                            $imageFileType != "gif") {
                                $uploadOk = 0;
                            } else {
                                // echo "File is an image - " . $check["mime"] . ".";
                                $uploadOk = 1;
                            }
                            if ($uploadOk == 0) {
                                echo "Sorry, your file was not uploaded.";
                            } else {
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    $providedImage = ("../assets/".$_FILES["image"]["name"]);
                                    $sql = "INSERT INTO studentdetails(
                                    StudentNumber, 
                                    Name, 
                                    Bday, 
                                    Course, 
                                    Contact_Number, 
                                    Email_Address, 
                                    username, 
                                    password, 
                                    name_first, 
                                    name_last, 
                                    access, 
                                    profilePicture
                                    ) VALUES (
                                        '$providedStudentNumber', 
                                        '$providedFullName', 
                                        '$providedBirthday', 
                                        '$providedCourse', 
                                        '$providedContactNumber', 
                                        '$providedEmail',
                                        '$providedUsername',
                                        '$providedPassword',
                                        '$providedFirstName',
                                        '$providedLastName',
                                        'MEMBER',
                                        '$providedImage'
                                    );";
                                    if($conn->query($sql) === TRUE){
                                        $conn->close();
                                        // record inserted
                                        // echo("User registered succesfully!");
                                        // $_SESSION["USERNAME"] = $providedUsername;
                                        // $_SESSION["FNAME"] = $providedFirstName;
                                        // $_SESSION["LNAME"] = $providedLastName;
                                        $CREDS = array(
                                            "number" => "$providedStudentNumber", 
                                            "username" => "$providedUsername", 
                                            "firstname" => "$providedFirstName", 
                                            "lastname" => "$providedLastName",
                                            "picture" => "$providedImage",
                                            "access" => "MEMBER"
                                        );
                                        if(!$error = checkUser($CREDS, $providedPassword)){
                                            // echo("user logged in");
                                            $_SESSION['CREDENTIALS'] = $CREDS;
                                            ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM4/Sem_2/login/pages/homePage.php"> <?php
                                        }
                                    } else {
                                        echo("Error: " . $sql . "<br>" . $conn->error);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    printError();
                }
            }
        } else {
            printRegister();
        } 

        function checkDetails($first, $last, $user, $pass){
            $errCount = 0;

            $_SESSION['ERR_FNAME'] = $first;
            $_SESSION['ERR_LNAME'] = $last;
            $_SESSION['ERR_UNAME'] = $user;
            $_SESSION['ERR_PASS'] = $pass;

            if(empty($first)){
                $_SESSION['ERR_FNAME'] = "First name is required!";
                $errCount += 1;
            } if(empty($last)){
                $_SESSION['ERR_LNAME'] = "Last name is required!";
                $errCount += 1;
            } if(empty($user)){
                $_SESSION['ERR_UNAME'] = "Username is required!";
                $errCount += 1;
            } if(empty($pass)){
                $_SESSION['ERR_PASS'] = "Password is required!";
                $errCount += 1;
            }

            if($errCount > 0){
                return(True);
            } else {
                return(False);
            }
            return(True);
        }

        function checkUser($CREDS, $pass){
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            $number = $CREDS['number'];

            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            } else {
                $sql = "SELECT * FROM studentdetails WHERE StudentNumber=$number;";
                if($conn->query($sql) === TRUE){
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            if($CREDS['username'] == $row['username'] && $pass == $row['password']){
                                $conn->close();
                                return(False);
                            }
                        }
                    } else {
                        $conn->close();
                        return(True);
                    }
                } else {
                    echo("Error: " . $sql . "<br>" . $conn->error);
                }
                $conn->close();
            }
            return(True);
        }

        function loginUser($providedUser, $providedPass){
            $USERNAME = $_POST['username'];
            $PASSWORD = $_POST['password'];

            if(strcmp($USERNAME, $providedUser) == 0){
                if (strcmp($PASSWORD, $providedPass) == 0){
                    $ACCESS = $_SESSION["USER_DETAILS"]["access"];
                    $FULLNAME = $_SESSION["USER_DETAILS"]["name_full"];
                    $_SESSION['ACCESS'] = $ACCESS;
                    $_SESSION['FULLNAME'] = $FULLNAME;
                    return(False);
                } else {
                    return(True);
                }
            } else {
                return(True);
            }  
            return(True);
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
</body>
</html>