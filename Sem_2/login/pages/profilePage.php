<?php 
    session_start();

    if (!isset($_SESSION['CREDENTIALS'])){
        $_SESSION['CREDENTIALS'] = array();
    } else {
        $CREDENTIALS = $_SESSION['CREDENTIALS'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karl D | Profile</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
</head>
<body class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg" style="background-color: pink;">
                <div class="container-fluid">
                    <div class="d-flex">
                        <a class="navbar-brand p-3" href="homePage.php">
                            <img src="../assets/logo.png" alt="">
                        </a>
                    </div>

                    <div class="d-flex ms-auto order-5">   
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-light" aria-current="page" href="homePage.php" style="color: white; margin-right: 5px;">Home</a>
                                </li>
                                <?php
                                    if(!empty($_SESSION['CREDENTIALS'])){
                                        checkAccess($_SESSION['CREDENTIALS']);
                                    } else {
                                        echo ("
                                            <li class=\""."nav-item\"".">
                                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."loginPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Log in</a>
                                            </li>
                                        ");
                                        echo ("
                                            <li class=\""."nav-item\"".">
                                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."registerPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Register</a>
                                            </li>
                                        ");
                                    }
                                ?>
                            </ul>
                        </div>

                        <div class="navbar-header">
                            <button 
                                class="navbar-toggler" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#navbarNav" 
                                aria-controls="navbarNav" 
                                aria-expanded="false" 
                                aria-label="Toggle navigation"
                            >
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <section class="items">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                if (empty($_POST["update_user"])){ 
                    if (empty($_POST["manage_user"])){ 
                        if (empty($_POST["check_user"])){ 
                            if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])){ 
                            } else {
                                logoutUser();
                            }
                        } else {
                            checkUser();
                        }
                    } else {
                        manageUser();
                    }
                } else {
                    updateUser();
                }
            } 

            function updateUser(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $number = $_POST["update_user"];
                $newNumber = $_POST['student_number'];
                $newName = $_POST['student_name'];
                $newCourse = $_POST['student_course'];
                $newEmail = $_POST['student_email'];
                $newContact = $_POST['student_contact'];
                $sql = "UPDATE studentdetails SET StudentNumber = '$number', Name = '$newName', Course = '$newCourse', Email_Address = '$newEmail', Contact_Number = '$newContact' WHERE StudentNumber = '$number'";

                if (mysqli_query($conn, $sql)) {
                    ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM4/Sem_2/login/pages/manageUsersPage.php"> <?php
                } else {
                    manageUser();
                }
            }

            function manageUser(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $number = $_POST["manage_user"];
                $sql = "SELECT * FROM studentdetails WHERE StudentNumber = '$number'"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                    echo("NUMBER: " . $number ."<br> pass end <br>");
                } else {
                    echo("<table style='margin: 1em 30%; background-color: pink; border-style: none; border-radius: 25px; '>");
                    while ($row = mysqli_fetch_assoc($result)){
                        echo("<form
                            method='post'
                            action='profilePage.php'
                        >");
                        echo("<tr>");
                            echo("<td> <img class=\""."profilePicture\""." src=\"".$row['profilePicture']."\" style=\""."width: 20vw; padding-top: 2vh; border-style: none; border-radius: 25px; margin-left: 45%; \""."/> </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw; padding-top: 2vh;'> <h5> Student Number: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'>  
                                <h4> ".$row['StudentNumber']." </h4>
                            </td> ");
                            // echo("<td style='padding-right: 2vw; padding-top: 2vh;'> <h5>
                            //     <input
                            //         type='text'
                            //         name='student_num'
                            //         value='".$row['StudentNumber']."'
                            //     /> </h5>
                            // </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Full Name: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'> <h5>
                                <input
                                    type='text'
                                    name='student_name'
                                    value='".$row['Name']."'
                                /> </h5>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Course: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'> <h5>
                                <input
                                    type='text'
                                    name='student_course'
                                    value='".$row['Course']."'
                                /> </h5>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Email: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'> <h5>
                                <input
                                    type='email'
                                    name='student_email'
                                    value='".$row['Email_Address']."'
                                /> </h5>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Contact Number: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'> <h5> 
                                <input
                                    type='text'
                                    name='student_contact'
                                    value='".$row['Contact_Number']."'
                                /> </h5>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td> 
                            <input 
                                type='hidden'
                                name='update_user'
                                value='".$row['StudentNumber']."'
                            />
                            <input 
                                type='submit'
                                class='btn btn-info'
                                value='Update User Details'
                                style='color: white; width: 20vw; margin-left: 45%; margin-bottom: 2vh;'/> 
                            </td>");
                        echo("</tr>");
                        echo("</form>");
                        $conn->close();
                    }
                    echo("</table>");
                }
            }

            function checkUser(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $number = $_POST["check_user"];
                $sql = "SELECT * FROM studentdetails WHERE StudentNumber = '$number'"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                    echo("NUMBER: " . $number ."<br> pass end <br>");
                } else {
                    echo("<table style='margin: 1em 30%; background-color: pink; border-style: none; border-radius: 25px; '>");
                    while ($row = mysqli_fetch_assoc($result)){
                        echo("<tr>");
                            echo("<td> <img class=\""."profilePicture\""." src=\"".$row['profilePicture']."\" style=\""."width: 20vw; padding-top: 2vh; border-style: none; border-radius: 25px; margin-left: 43%; \""."/> </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Student Number: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'>  
                                <h4> ".$row['StudentNumber']." </h4>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Full Name: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'>  
                                <h4> ".$row['Name']." </h4>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Course: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'>  
                                <h4> ".$row['Course']." </h4>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Email: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'>  
                                <h4> ".$row['Email_Address']." </h4>
                            </td> ");
                        echo("</tr>");
                        echo("<tr>");
                            echo("<td style='padding-left: 2vw;'> <h5> Contact Number: </h5> </td> ");
                            echo("<td style='padding-right: 2vw;'>  
                                <h4> ".$row['Contact_Number']." </h4>
                            </td> ");
                        echo("</tr>");
                        $conn->close();
                    }
                    echo("</table>");
                }
            }

            function logoutUser(){
                unset($_SESSION['CREDENTIALS']);
                unset($CREDENTIALS);
                
                reloadPage();
            }
            
            function checkAccess($CREDENTIALS){
                if(isset($CREDENTIALS['access'])){
                    $userAccess = $CREDENTIALS['access'];
                    if($userAccess == "USER"){
                        echo ("
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."cartPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Check Out</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."orderHistoryPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Order History</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."bookingPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Book a Date</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."bookedDatetimesPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Booked Dates</a>
                            </li>
                            <form
                                method=\""."post\""."
                                action=\""."homePage.php\""."
                            >
                                <li class=\""."nav-item\"".">
                                    <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." name=\""."logout_user\""." value=\""."Sign out\""." style=\""."color: white; margin-right: 5px;\""."/>
                                </li>
                            </form>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link disabled active\""." aria-current=\""."page\""." style=\""."color: white;\""."> Welcome, ". $CREDENTIALS['firstname'] ."</a>
                            <form
                                method=\""."post\""."
                                action=\""."profilePage.php\""."
                            >
                                </li>
                                    <input type='hidden' name=\""."check_user\""." value=\"".$CREDENTIALS['number']."\""."/>
                                    <input type='image' class=\""."profilePicture\""." src=\"".$CREDENTIALS['picture']."\" style=\""."width: 5vw; height: 5vw; border-style: none; border-radius: 30px;\""."/>"."
                                </li>
                            </form>
                        ");
                    } else if($userAccess == "ADMIN"){
                        echo ("
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."cartPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Check Out</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."orderHistoryPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Order History</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."dashboardPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Dashboard</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."bookingPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Book a Date</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."bookedDatetimesPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Booked Dates</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageUsersPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Users</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageItemsPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Items</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."addItemPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Add Item</a>
                            </li>
                            <form
                                method=\""."post\""."
                                action=\""."homePage.php\""."
                            >
                                <li class=\""."nav-item\"".">
                                    <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." name=\""."logout_user\""." value=\""."Sign out\""." style=\""."color: white; margin-right: 5px;\""."/>
                                </li>
                            </form>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link disabled active\""." aria-current=\""."page\""." style=\""."color: white;\""."> Welcome, ". $CREDENTIALS['firstname'] ."</a>
                            <form
                                method=\""."post\""."
                                action=\""."profilePage.php\""."
                            >
                                </li>
                                    <input type='hidden' name=\""."check_user\""." value=\"".$CREDENTIALS['number']."\""."/>
                                    <input type='image' class=\""."profilePicture\""." src=\"".$CREDENTIALS['picture']."\" style=\""."width: 5vw; height: 5vw; border-style: none; border-radius: 30px;\""."/>"."
                                </li>
                            </form>
                        ");
                    } else if($userAccess == "MEMBER"){
                        echo ("
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."cartPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Check Out</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."orderHistoryPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Order History</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageItemsPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Items</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."bookingPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Book a Date</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."bookedDatetimesPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Booked Dates</a>
                            </li>
                            <form
                                method=\""."post\""."
                                action=\""."homePage.php\""."
                            >
                                <li class=\""."nav-item\"".">
                                    <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." name=\""."logout_user\""." value=\""."Sign out\""." style=\""."color: white; margin-right: 5px;\""."/>
                                </li>
                            </form>
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link disabled active\""." aria-current=\""."page\""." style=\""."color: white;\""."> Welcome, ". $CREDENTIALS['firstname'] ."</a>
                            <form
                                method=\""."post\""."
                                action=\""."profilePage.php\""."
                            >
                                </li>
                                    <input type='hidden' name=\""."check_user\""." value=\"".$CREDENTIALS['number']."\""."/>
                                    <input type='image' class=\""."profilePicture\""." src=\"".$CREDENTIALS['picture']."\" style=\""."width: 5vw; height: 5vw; border-style: none; border-radius: 30px;\""."/>"."
                                </li>
                            </form>
                        ");
                    }
                }
            }

            function reloadPage(){
                echo("<meta http-equiv='refresh' content='1'>");
            }


        ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>