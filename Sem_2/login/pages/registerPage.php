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

        $servername="localhost";
        $username="root";
        $password="";
        $dbname="schooldb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // if($conn->connect_error){
        //     die("Connection failed: " . $conn->connect_error);
        // } else {
        //     $sql = "SELECT * FROM `studentdetails`;";
        //     if($conn->query($sql) === TRUE){
        //         $result = $conn->query($sql);
        //         if ($result->num_rows > 0) {

        //             // $CREDENTIALS = array_values($result);
        //             // output data of each row
        //             while($row = $result->fetch_assoc()) {
        //                 $index = count($CREDENTIALS);
        //                 array_push($CREDENTIALS, [
        //                     "index" => $index,
        //                     "name_full" => $row["Name"],
        //                     "name_first" => $row["name_first"],
        //                     "name_last" => $row["name_last"],
        //                     "student_num" => $row["StudentNumber"],
        //                     "email" => $row["Email_Address"],
        //                     "birthday" => $row["Bday"],
        //                     "course" => $row["Course"],
        //                     "contact_num" => $row["Contact_Number"],
        //                     "username" => $row["username"],
        //                     "password" => $row["password"],
        //                     "access" => $row["access"],
        //                 ]);
        //             }
        //         } else {
        //             echo "0 results";
        //         }
        //     } else {
        //         echo("Error: " . $sql . "<br>" . $conn->error);
        //     }

        //     $conn->close();
        // }

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

                $studentDetails = array(
                    "name_first" => $providedFirstName,
                    "name_last" => $providedEmail,
                    "name_full" => $providedFullName,
                    "student_num" => $providedStudentNumber,
                    "email" => $providedEmail,
                    "birthday" => $providedBirthday,
                    "course" => $providedCourse,
                    "contact_num" => $providedContactNumber,
                    "username" => $providedUsername,
                    "password" => $providedPassword,
                    "access" => "MEMBER",
                );

                if(!$error = checkDetails($providedFirstName, $providedLastName, $providedUsername, $providedPassword)){
                    if($error = checkUser($CREDENTIALS, $providedUsername)){
                        // echo("user is valid");
                        $index = count($CREDENTIALS);
                        // INSERT HERE

                        if($conn->connect_error){
                            die("Connection failed: " . $conn->connect_error);
                        } else {
                            $sql = "INSERT INTO studentdetails(StudentNumber, Name, Bday, Course, Contact_Number, Email_Address, username, password, name_first, name_last, access) VALUES (
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
                                'MEMBER'
                            );";
                            if($conn->query($sql) === TRUE){
                                // echo("New record created successfully");
                            } else {
                                echo("Error: " . $sql . "<br>" . $conn->error);
                            }

                            $conn->close();
                        }
                        // array_push($CREDENTIALS, [
                        //         "index" => $index,
                        //         "name_full" => $providedFullName,
                        //         "name_first" => $providedFirstName,
                        //         "name_last" => $providedLastName,
                        //         "username" => $providedUsername,
                        //         "password" => $providedPassword,
                        //         "access" => "MEMBER",
                        //         ]  
                        // );
                        $_SESSION['CREDENTIALS'] = $CREDENTIALS;
                        echo("User registered succesfully!");
                        if(!$error = checkUser($_SESSION['CREDENTIALS'], $providedUsername)){
                            // LOGIN HERE
                            if(!$error = loginUser($providedUsername, $providedPassword)){
                                echo("user logged in");
                                $_SESSION['CREDENTIALS'] = $CREDENTIALS;
                                ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM2/Sem_2/login/pages/homePage.php"> <?php
                            } else {
                                printError();
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

        function checkUser($CREDENTIALS, $username){
            foreach ($CREDENTIALS as $user => $userDetails){
                if(in_array($username, $CREDENTIALS[$user], false)){
                    $_SESSION["USER_DETAILS"] = $userDetails;
                    return(False);
                } 
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