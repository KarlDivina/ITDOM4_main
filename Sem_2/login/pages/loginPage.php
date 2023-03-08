<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karl D : Login</title>
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
        function printLogin(){
            ?>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="row card-login">
                        <div class="col-12 mt-4"><h2>Log In</h2></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="loginPage.php"
                                >
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
                                            name="login_user"
                                            class="btn"
                                            value="Login"
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
                        <div class="col-12 mt-4"><h2 style="color: red;">Invalid Credentials</h2></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="loginPage.php"
                                >
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
                                            name="login_user"
                                            class="btn btn-warning"
                                            value="Login"
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
            if (empty($_POST[$_SESSION['FUNCTIONS']["F4"]])){ //login user
                printLogin();
            } else {
                $providedUsername = $_POST['username'];
                $providedPassword = $_POST['password'];

                if(!$error = checkUser($providedUsername, $providedPassword)){
                    ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM4/Sem_2/login/pages/homePage.php"> <?php
                } else {
                    printError();
                }
            }
        } else {
            printLogin();
        } 

        function checkUser($user, $pass){
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";

            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM studentdetails WHERE username = '$user'"; 

            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
                echo("QUERY: " . $sql ."<br> query end <br>");
                echo("ERROR: " . $conn->error ."<br> error end <br>");
                echo("USERNAME: " . $user ."<br> user end <br>");
                echo("PASSWORD: " . $pass ."<br> pass end <br>");
            } else {
                while ($row = mysqli_fetch_assoc($result)){
                    if($user == $row['username'] && $pass == $row['password']){
                        echo("LOGIN VALID");
                        $CREDENTIALS = array(
                            "number" => $row['StudentNumber'], 
                            "username" => $row['username'], 
                            "firstname" => $row['name_first'], 
                            "lastname" => $row['name_last'],
                            "picture" => $row['profilePicture'],
                            "access" => $row['access']
                        );
                        $_SESSION['CREDENTIALS'] = $CREDENTIALS;
                        $conn->close();
                        return(False);
                    } else {
                        $conn->close();
                        return(True);
                    }
                }
                $conn->close();
            }
            return(True);
        }
        
        function loginUser($providedUser, $providedPass){
            $USERNAME = $_SESSION["USER_DETAILS"]["username"];
            $PASSWORD = $_SESSION["USER_DETAILS"]["password"];

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>