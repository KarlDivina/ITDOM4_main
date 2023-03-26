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
    <title>Karl D | Manage Items</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./login.css">
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
                                        echo ("
                                            <li class=\""."nav-item\"".">
                                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageUsersPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Users</a>
                                            </li>
                                        ");
                                        echo ("
                                            <li class=\""."nav-item\"".">
                                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageItemsPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Items</a>
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
    <section class="items row" style="margin: 0 30%;">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])){ //order is complete?
                } else {
                    logoutUser();
                }
            } else {
                printItems();
            }

            function printItems(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";

                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM items;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    echo("<table>
                    <tr>
                        <th scope='col' style='padding-right: 15vw;'></th>
                        <th scope='col' style='padding-right: 15vw;'></th>
                        <th scope='col' style='padding-right: 15vw;'></th>
                    </tr>");
                        for($x = 0; $x < $result->num_rows; $x++){
                            while ($row = mysqli_fetch_assoc($result)){
                                echo("<tr>
                                    <th scope='row'>  
                                        <form
                                            method=\"post\"
                                            action=\"itemPage.php\"
                                        >
                                                <input type='hidden' name=\"manage_item\" value=\"".$row['ItemCode']."\"/>
                                                <input type='image' class=\"profilePicture\" src=\"".$row['Image']."\" style=\"width: 10vw; height: 15vw; border-style: none; border-radius: 50px;\"/>
                                        </form> 
                                    </th>
                                    <td> ".$row['Name']." </td>
                                    <td> $".$row['Price']." </td>
                                </tr>");
                        }
                    }
                }
                echo("</table>");
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
                    if($userAccess == "SUPER"){
                    } else if($userAccess == "ADMIN"){
                        echo ("
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."manageUsersPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Manage Users</a>
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