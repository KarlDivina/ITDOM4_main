<?php 
    session_start();

    $_SESSION['FUNCTIONS'] = array(
        "F4" => "login_user",
        "F5" => "logout_user",
        "F6" => "register_user",
        "F7" => "check_user",
        "F8" => "check_",
    );

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
    <title>Karl D</title>
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
                                        checkAccess($CREDENTIALS);
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
                                        // echo ("
                                        //     <li class=\""."nav-item\"".">
                                        //         <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageUsersPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Users</a>
                                        //     </li>
                                        // ");
                                        // echo ("
                                        //     <li class=\""."nav-item\"".">
                                        //         <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageItemsPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Items</a>
                                        //     </li>
                                        // ");
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
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])){ //order is complete?
                } else {
                    logoutUser();
                }
            } else {
                printHome();
            }

        
        function printHome(){
            ?>
            <div class="row">
                <div class="col-4">
                    <div class="row card-home">
                        <div class="col-12 mt-2"></div>
                        <div class="col-12">
                            <section class="items">
                                <?php
                                    printSales();
                                ?>
                            </section>
                        </div>
                    </div>
                    <div class="row card-home">
                        <div class="col-12 mt-2"></div>
                        <div class="col-12">
                            <section class="items">
                                <?php
                                    printValue();
                                ?>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row card-home">
                        <div class="col-12 mt-2"></div>
                        <div class="col-12">
                            <section class="items">
                                <?php
                                    printUniqueSales();
                                ?>
                            </section>
                        </div>
                    </div>
                    <div class="row card-home">
                        <div class="col-12 mt-2"></div>
                        <div class="col-12">
                            <section class="items">
                                <?php
                                    printPendingSales();
                                ?>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row card-home">
                        <div class="col-12 mt-2"></div>
                        <div class="col-12">
                            <section class="items">
                                <?php
                                    printUsers();
                                ?>
                            </section>
                        </div>
                    </div>
                    <div class="row card-home">
                        <div class="col-12 mt-2"></div>
                        <div class="col-12">
                            <section class="items">
                                <?php
                                    printBestItem();
                                ?>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

            function printSales(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";
                $results_per_page = 5;
                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM orders;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    $total_orders = 0;
                    for($x = 0; $x < $result->num_rows; $x++){
                        while ($row = mysqli_fetch_assoc($result)){
                            $total_orders++;
                        }
                    }
                    echo("
                    <div style='text-align: center;'>
                        <h1> Total Sales: <h1>
                        <h2> $total_orders </h2>
                    </div>
                    ");
                }
                $conn->close();
            }

            function printUniqueSales(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";
                $results_per_page = 5;
                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM transactions;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    $total_orders = 0;
                    for($x = 0; $x < $result->num_rows; $x++){
                        while ($row = mysqli_fetch_assoc($result)){
                            $total_orders++;
                        }
                    }
                    echo("
                    <div style='text-align: center;'>
                        <h1> Unique Sales: <h1>
                        <h2> $total_orders </h2>
                    </div>
                    ");
                }
                $conn->close();
            }

            function printUsers(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";
                $results_per_page = 5;
                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM studentdetails;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    $total_orders = 0;
                    for($x = 0; $x < $result->num_rows; $x++){
                        while ($row = mysqli_fetch_assoc($result)){
                            $total_orders++;
                        }
                    }
                    echo("
                    <div style='text-align: center;'>
                        <h1> Total Users: <h1>
                        <h2> $total_orders </h2>
                    </div>
                    ");
                }
                $conn->close();
            }

            function printValue(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";
                $results_per_page = 5;
                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM orders;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    $total_orders = 0;
                    $total_value = 0;
                    for($x = 0; $x < $result->num_rows; $x++){
                        while ($row = mysqli_fetch_assoc($result)){
                            $total_value += $row['item_price'];
                        }
                    }
                    echo("
                    <div style='text-align: center;'>
                        <h1> Total Value Sold: <h1>
                        <h2> $$total_value </h2>
                    </div>
                    ");
                }
                $conn->close();
            }

            function printBestItem(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";
                $results_per_page = 5;
                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM orders GROUP BY item_id ORDER BY count(item_id) DESC LIMIT 1;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    $best_item = "";
                    for($x = 0; $x < $result->num_rows; $x++){
                        while ($row = mysqli_fetch_assoc($result)){
                            $best_item = $row['item_id'];
                        }
                    }
                    echo("
                    <div style='text-align: center;'>
                        <h1> Most Sold Item ID: <h1>
                        <h2> $best_item </h2>
                    </div>
                    ");
                }
                $conn->close();
            }

            function printPendingSales(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";
                $results_per_page = 5;
                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM cart;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    $total_orders = 0;
                    $total_value = 0;
                    for($x = 0; $x < $result->num_rows; $x++){
                        while ($row = mysqli_fetch_assoc($result)){
                            $total_orders++;
                        }
                    }
                    echo("
                    <div style='text-align: center;'>
                        <h1> Pending Sales: <h1>
                        <h2> $total_orders </h2>
                    </div>
                    ");
                }
                $conn->close();
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>