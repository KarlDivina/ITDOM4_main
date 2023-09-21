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
    <title>Karl D | Cart</title>
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
        function printCart(){
            ?>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="row card-cart">
                        <div class="col-12 mt-2"><h2></h2></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="cartPage.php"
                                >
                                    <?php
                                        printItems();
                                    ?>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
            <?php
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST["check_out"])){ 
                if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])){ 
                    printCart();
                } else {
                    logoutUser();
                }
            } else {
                checkOut();
            } 
        } else {
            printCart();
        }

        function checkOut(){
            $total_price = 0;
            $total_quantity = 0;
            $itemCode = $_POST['check_out'];
            $studentNum = $_SESSION['CREDENTIALS']['number'];

            $items = array();

            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";

            $total_price = 0;
            $conn = new mysqli($servername, $username, $password, $dbname);
            // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
            $sql = "SELECT * FROM cart JOIN items ON cart.item_id = items.ItemCode WHERE user_id = $studentNum ;"; 

            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
                echo("QUERY: " . $sql ."<br> query end <br>");
                echo("ERROR: " . $conn->error ."<br> error end <br>");
            } else {
                for($x = 0; $x < $result->num_rows; $x++){
                    while ($row = mysqli_fetch_assoc($result)){
                        $total_price += $row['Price'];
                        $total_quantity += 1;
                        $temp_items = array(
                            "item_id" => $row['item_id'],
                            "item_price" => $row['Price'],
                            "item_quantity" => $row['quantity']
                        );
                        array_push($items, $temp_items);
                    }
                }
                
            }
            $conn->close();

            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "INSERT INTO transactions 
            (user_id, item_quantity, total_price) VALUES 
            ('$studentNum', '$total_quantity', '$total_price')";
            $result = mysqli_query($conn, $sql);  
            $conn->close();

            $transaction_id = 0;
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT transaction_id FROM transactions ORDER BY transaction_id DESC LIMIT 1;";
            $result = mysqli_query($conn, $sql);  
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
                echo("QUERY: " . $sql ."<br> query end <br>");
                echo("ERROR: " . $conn->error ."<br> error end <br>");
            } else {
                for($x = 0; $x < $result->num_rows; $x++){
                    while ($row = mysqli_fetch_assoc($result)){
                        $transaction_id = $row['transaction_id'];
                    }
                }
                
            }
            $conn->close();

            $conn = new mysqli($servername, $username, $password, $dbname);
            for($x = 0; $x < count($items); $x++){
                $item_id = $items[$x]['item_id'];
                $item_price = (double)$items[$x]['item_price'];
                $item_quantity = (int)$items[$x]['item_quantity'];
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                $sql = "INSERT INTO orders 
                (transaction_id, item_id, quantity, item_price, total_price) VALUES 
                ('$transaction_id', 
                '$item_id', 
                '$item_quantity', 
                '$item_price', 
                '$total_price')";
                $result = mysqli_query($conn, $sql);  
                $conn->close();
                ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM4/Sem_2/login/pages/homePage.php"> <?php  
            }     

            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "DELETE FROM cart WHERE user_id = $studentNum;"; 
            $result = mysqli_query($conn, $sql);  
            $conn->close();
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

        function printItems(){
            $total_price = 0;
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";
            $results_per_page = 5;
            $studentNum = $_SESSION['CREDENTIALS']['number'];
            $conn = new mysqli($servername, $username, $password, $dbname);
            // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
            $sql = "SELECT * FROM transactions WHERE user_id = $studentNum ;"; 

            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
                echo("QUERY: " . $sql ."<br> query end <br>");
                echo("ERROR: " . $conn->error ."<br> error end <br>");
            } else {
                echo("<table>
                <tr>
                    <th scope='col' style='padding-left: 5vw; padding-right: 5vw;'>Transaction ID</th>
                    <th scope='col' style='padding-left: 5vw; padding-right: 5vw;'>Item Quantity</th>
                    <th scope='col' style='padding-left: 5vw; padding-right: 5vw;'>Total Price</th>
                </tr>");
                $total_price = 0;
                for($x = 0; $x < $result->num_rows; $x++){
                    while ($row = mysqli_fetch_assoc($result)){
                        $item_price = (double)$row['total_price'];
                        $total_price += $item_price;
                        echo("
                            <tr>
                                <th scope='row' style='padding-left: 5vw; padding-right: 5vw    ;'> ".$row['transaction_id']." </th>
                                <td style='padding-left: 5vw; padding-right: 5vw;'> ".$row['item_quantity']." </td>
                                <td style='padding-left: 5vw; padding-right: 5vw;'> $".$row['total_price']." </td>
                            </tr>
                        ");
                    }
                }
                
                echo("
                    <tr>
                        <th scope='row'>
                        </th>
                        <td> 
                            <p style='font-size: 20px; font-style: bold; margin-bottom: -1vh; margin-top: 2vh;'> Total Price: </p>
                            <p style='font-size: 50px; font-style: bold;'> $".$total_price." <p> 
                        </td>
                    </tr>
                ");
            }
            echo("</table>");
            $conn->close();
        }
            
        function checkAccess($CREDENTIALS){
            if(isset($CREDENTIALS['access'])){
                $userAccess = $CREDENTIALS['access'];
                if($userAccess == "USER"){
                    echo ("
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