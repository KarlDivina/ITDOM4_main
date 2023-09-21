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

    // pagination
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karl D | Add Item</title>
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

        function printAddItem(){
            ?>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="row card-login">
                        <div class="col-12 mt-4"><h2>Add Item</h2></div>
                        <div class="col-12">
                            <section class="items">
                                <form
                                    method="post"
                                    action="addItemPage.php"
                                    enctype="multipart/form-data"
                                >
                                    <p>
                                        Product Code: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="item_code"
                                        />
                                    </p>
                                    <p>
                                        Product Name: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="item_name"
                                        />
                                    </p>
                                    <p>
                                        Price: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="item_price"
                                        />
                                    </p>
                                    <p>
                                        Product Image: 
                                        <input 
                                            type="file" 
                                            class="form-control form-rounded"
                                            name="image" 
                                        />
                                    </p>
                                    <p>
                                        <input 
                                            type="submit"
                                            name="add_item"
                                            class="btn"
                                            value="AddItem"
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
                                    action="addItemPage.php"
                                >
                                    <p>
                                        Product Code: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="item_code"
                                            placeholder="<?php echo $_SESSION['ERR_CODE']?>"
                                            value="<?php if(!empty($_POST['item_code'])){
                                                echo($_POST['item_code']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        Product Name: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="item_name"
                                            placeholder="<?php echo $_SESSION['ERR_NAME']?>"
                                            value="<?php if(!empty($_POST['item_name'])){
                                                echo($_POST['item_name']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        Price: 
                                        <input
                                            type="text"
                                            class="form-control form-rounded"
                                            name="item_price"
                                            placeholder="<?php echo $_SESSION['ERR_PRICE']?>"
                                            value="<?php if(!empty($_POST['item_price'])){
                                                echo($_POST['item_price']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        Product Image: 
                                        <input 
                                            type="file" 
                                            class="form-control form-rounded"
                                            name="image"
                                            value="<?php if(!empty($_POST['image'])){
                                                echo($_POST['image']);
                                            } ?>"
                                        />
                                    </p>
                                    <p>
                                        <input 
                                            type="submit"
                                            name="add_item"
                                            class="btn"
                                            value="AddItem"
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
            if (empty($_POST['add_item'])){ //register user
                printAddItem();
            } else {
                //fit guideline
                // pass must be x alphanumeric chars long including at least one special char | check + display
                $providedCode = $_POST['item_code'];
                $providedName = $_POST['item_name'];
                $providedPrice = $_POST['item_price'];

                if(!$error = checkDetails($providedCode, $providedName, $providedPrice)){
                    if(!$error = checkItem($providedCode)){
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
                                    $sql = "INSERT INTO items(
                                    ItemCode, 
                                    Name, 
                                    Price,
                                    Image
                                    ) VALUES (
                                        '$providedCode', 
                                        '$providedName', 
                                        '$providedPrice',
                                        '$providedImage'
                                    );";
                                    if($conn->query($sql) === TRUE){
                                        $conn->close();
                                        // record inserted
                                        // echo("User registered succesfully!");
                                        ?> <meta http-equiv="refresh" content="0;url=http://localhost/ITDOM4/Sem_2/login/pages/homePage.php"> <?php
                                    } else {
                                        echo("Error: " . $sql . "<br>" . $conn->error);
                                    }
                                }
                            }
                        }
                    } else {
                        $_SESSION['ERR_CODE'] = "Cannot have duplicate Item Code!";
                        printError();
                    }
                } else {
                    printError();
                }
            }
        } else {
            printAddItem();
        } 

        function checkDetails($code, $name, $price){
            $errCount = 0;

            $_SESSION['ERR_CODE'] = $code;
            $_SESSION['ERR_NAME'] = $name;
            $_SESSION['ERR_PRICE'] = $price;

            if(empty($code)){
                $_SESSION['ERR_CODE'] = "Item Code is required!";
                $errCount += 1;
            } if(empty($name)){
                $_SESSION['ERR_NAME'] = "Product Name is required!";
                $errCount += 1;
            } if(empty($price)){
                $_SESSION['ERR_PRICE'] = "Price is required!";
                $errCount += 1;
            } 

            if($errCount > 0){
                return(True);
            } else {
                return(False);
            }
            return(True);
        }

        function checkItem($code){
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="schooldb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            } else {
                $sql = "SELECT * FROM items WHERE ItemCode = '$code';";
                if($conn->query($sql) === TRUE){
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $conn->close();
                        return(True);
                    } else {
                        $conn->close();
                        return(False);
                    }
                } else {
                    $conn->close();
                    return(False);
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