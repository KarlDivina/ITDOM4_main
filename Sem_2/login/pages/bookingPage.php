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
    <title>Karl D | Booking</title>
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

    <?php
        function printBooking(){
            ?>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="row card-login">
                        <div class="col-12 mt-4"><h2>Book a Date</h2></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="bookingPage.php"
                                >
                                    <p>
                                        Name for Booking: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="booking_name"
                                            value="<?php echo $_SESSION['CREDENTIALS']['firstname']; ?>"
                                            required
                                        />
                                    </p>
                                    <p>
                                        Email: 
                                        <input
                                            type="email"
                                            class="form-control form-rounded"
                                            name="booking_email"
                                            value="<?php echo $_SESSION['CREDENTIALS']['email']; ?>"
                                            required
                                        />
                                    </p>
                                    <p>
                                        Mobile Number: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="booking_mobileNum"
                                            value="<?php echo $_SESSION['CREDENTIALS']['mobile']; ?>"
                                            required
                                        />
                                    </p>
                                    <p>
                                        Date: 
                                        <input
                                            type="date"
                                            class="form-control form-rounded"
                                            name="booking_date"
                                            
                                            required
                                        />
                                    </p>
                                    <p>
                                        Time: 
                                        <input
                                            id="booking_time"
                                            type="time"
                                            class="form-control form-rounded"
                                            name="booking_time"
                                            min="08:00"
                                            max="17:00"
                                            step="1800"
                                            required
                                        />
                                    </p>
                                    <p>
                                        <input 
                                            type="submit"
                                            name="add_booking"
                                            class="btn"
                                            value="Book this date"
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
            if (empty($_POST["add_booking"])){ 
                if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])){ 
                    printBooking();
                } else {
                    logoutUser();
                }
            } else {
                addBooking();
            } 
        } else {
            printBooking();
        }

        function addBooking(){
            $bookingName = $_POST['booking_name'];
            $bookingDate = $_POST['booking_date'];
            $bookingTime = $_POST['booking_time'];
            $bookingEmail = $_POST['booking_email'];
            $bookingMobile = $_POST['booking_mobileNum'];
            $studentNum = $_SESSION['CREDENTIALS']['number'];

            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "INSERT INTO booking 
            (student_num, booking_name, booking_date, booking_time, booking_email, booking_mobileNum) VALUES 
            ('$studentNum', '$bookingName', '$bookingDate', '$bookingTime', '$bookingEmail', '$bookingMobile')";
            $result = mysqli_query($conn, $sql);  
            ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM4/Sem_2/login/pages/homePage.php"> <?php          
        }

        function checkBooking($user, $pass){
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";

            $booked_dates = [];
            $booked_times = [];
            $booked_datetimes = [];

            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM booking"; 

            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
                echo("QUERY: " . $sql ."<br> query end <br>");
                echo("ERROR: " . $conn->error ."<br> error end <br>");
                echo("USERNAME: " . $user ."<br> user end <br>");
                echo("PASSWORD: " . $pass ."<br> pass end <br>");
            } else {
                while ($row = mysqli_fetch_assoc($result)){
                    array_push($booked_dates, $row['booking_date']);
                    array_push($booked_times, $row['booking_time']);
                    if (array_key_exists($row['booking_date'], $booked_datetimes)){
                        array_push($booked_datetimes[$row['booking_date']], $row['booking_time']);
                    } else {
                        array_push($booked_datetimes, $row['booking_date']);
                        array_push($booked_datetimes[$row['booking_date']], $row['booking_time']);
                    }
                }
                $conn->close();
            }
            return(True);
        }

        // function checkBooking($user, $pass){
        //     $servername="localhost";
        //     $username="root";
        //     $password="";
        //     $dbname="schooldb";

        //     $conn = new mysqli($servername, $username, $password, $dbname);
        //     $sql = "SELECT * FROM studentdetails WHERE username = '$user'"; 

        //     $result = mysqli_query($conn, $sql);
        //     if (!$result) {
        //         die("Query failed: " . mysqli_error($conn));
        //         echo("QUERY: " . $sql ."<br> query end <br>");
        //         echo("ERROR: " . $conn->error ."<br> error end <br>");
        //         echo("USERNAME: " . $user ."<br> user end <br>");
        //         echo("PASSWORD: " . $pass ."<br> pass end <br>");
        //     } else {
        //         while ($row = mysqli_fetch_assoc($result)){
        //             if($user == $row['username'] && $pass == $row['password']){
        //                 echo("LOGIN VALID");
        //                 $CREDENTIALS = array(
        //                     "number" => $row['StudentNumber'], 
        //                     "username" => $row['username'], 
        //                     "firstname" => $row['name_first'], 
        //                     "lastname" => $row['name_last'],
        //                     "picture" => $row['profilePicture'],
        //                     "access" => $row['access']
        //                 );
        //                 $_SESSION['CREDENTIALS'] = $CREDENTIALS;
        //                 $conn->close();
        //                 return(False);
        //             } else {
        //                 $conn->close();
        //                 return(True);
        //             }
        //         }
        //         $conn->close();
        //     }
        //     return(True);
        // }
            
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

        function logoutUser(){
            unset($_SESSION['CREDENTIALS']);
            unset($CREDENTIALS);
            
            reloadPage();
        }

        function reloadPage(){
            echo("<meta http-equiv='refresh' content='1'>");
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>