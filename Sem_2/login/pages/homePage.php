<?php 
    session_start();

    $_SESSION['FUNCTIONS'] = array(
        "F4" => "login_user",
        "F5" => "logout_user",
        "F6" => "register_user",
        "F7" => "check_user",
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
                if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])){ //order is complete?
                } else {
                    logoutUser();
                }
            } else {
                printUsers();
            }

            function printUsers(){
                $servername="localhost";
                $username="root";
                $password="";
                $dbname="schooldb";

                $conn = new mysqli($servername, $username, $password, $dbname);
                // $sql = "SELECT * FROM studentdetails Orders LIMIT 2, 4;"; 
                $sql = "SELECT * FROM studentdetails;"; 

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                    echo("QUERY: " . $sql ."<br> query end <br>");
                    echo("ERROR: " . $conn->error ."<br> error end <br>");
                } else {
                    echo("<table>
                    <tr>
                        <th scope='col'>  Profile Picture</th>
                        <th scope='col'>  Student Number </th>
                        <th scope='col'>  Name </th>
                        <th scope='col'>  Course </th>
                    </tr>");
                        for($x = 0; $x < $result->num_rows; $x++){
                            while ($row = mysqli_fetch_assoc($result)){
                                echo("<tr>
                                    <th scope='row'>  
                                        <form
                                            method=\"post\"
                                            action=\"profilePage.php\"
                                        >
                                                <input type='hidden' name=\"check_user\" value=\"".$row['StudentNumber']."\"/>
                                                <input type='image' class=\"profilePicture\" src=\"".$row['profilePicture']."\" style=\"width: 5vw; height: 5vw; border-style: none; border-radius: 50px;\"/>
                                        </form> 
                                    </th>
                                    <td> ".$row['StudentNumber']." </td>
                                    <td> ".$row['Name']." </td>
                                    <td> ".$row['Course']." </td>
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
                            <form
                                method=\""."post\""."
                                action=\""."homePage.php\""."
                            >
                                <li class=\""."nav-item\"".">
                                    <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." name=\""."logout_user\""." value=\""."Sign out\""." style=\""."color: white; margin-right: 5px;\""."/>
                                </li>
                            </form>
                        ");
                        echo ("
                            <li class=\""."nav-item\"".">
                                <a class=\""."nav-link disabled active\""." aria-current=\""."page\""." style=\""."color: white;\""."> Welcome, ". $CREDENTIALS['firstname'] ."</a>
                            </li>
                            <li class=\""."nav-item\"".">
                                <img class=\"profilePicture\" src=\"".$CREDENTIALS['picture']."\"/>"."
                            </li>
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
                                    <input type='image' class=\""."profilePicture\""." src=\"".$CREDENTIALS['picture']."\" style=\""."width: 5vw; border-style: none; border-radius: 50px;\""."/>"."
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