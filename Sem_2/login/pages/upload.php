<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Max Multi : New Item</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="midterm.css">
</head>
<body class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg" style="background-color: #004080;">
            <div class="container-fluid">
                <div class="d-flex">
                    <a class="navbar-brand" href="/ITDOM_Finals/pages/homePage.php">
                        <img src="../assets/logo.svg" alt="">
                    </a>
                </div>

                <div class="d-flex ms-auto order-5">   
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light" aria-current="page" href="/ITDOM_Finals/pages/homePage.php" style="color: white; margin-right: 5px;">Home</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">Give us a review!</a>
                            </li> -->
                            <?php
                                if(isset($_SESSION["ACCESS"])){
                                    checkAccess();
                                } else {
                                    echo ("
                                        <li class=\""."nav-item\"".">
                                            <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."loginPage.php\""." style=\""."color: gray; margin-right: 5px;\"".">Cart</a>
                                        </li>
                                        <li class=\""."nav-item\"".">
                                            <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."loginPage.php\""." style=\""."color: white; margin-right: 5px;\"".">Sign in</a>
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
            </nav>
        </div>
    </div>

	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (empty($_POST["submit"])){   
			} else {
				$MENU_ITEMS = $_SESSION["MENU_ITEMS"];
				if(isset($_POST["submit"])){
					$target_dir = "./assets/";
					$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

					// Check if image file is a actual image or fake image
					if(isset($_POST["submit"])) {
						$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
						if($check !== false) {
							echo "File is an image - " . $check["mime"] . ".";
							$uploadOk = 1;
						} else {
							echo "File is not an image.";
							$uploadOk = 0;
						}
					}

					// Check if file already exists
					if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						$uploadOk = 0;
					}

					// Check file size
					if ($_FILES["fileToUpload"]["size"] > 500000) {
						echo "Sorry, your file is too large.";
						$uploadOk = 0;
					}

					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$uploadOk = 0;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
							echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
							
							$newKey = $_POST["key"];
							$newImage = ("../assets/".$_FILES["fileToUpload"]["name"]);
							$newName = $_POST["name"];
							$newPrice = $_POST["price"];

							setImage($newKey, $newImage);
							setName($newKey, $newName);
							setPrice($newKey, $newPrice);
							createItem($newKey, $newImage, $newName, $newPrice);
						} else {
							echo "Sorry, there was an error uploading your file.";
						}
					}
				} 
			}
		}

		function createItem($newKey, $newImage, $newName, $newPrice){
			$_SESSION["MENU_ITEMS"][$newKey]["image"] = $newImage;
			$_SESSION["MENU_ITEMS"][$newKey]["longname"] = $newName;
			$_SESSION["MENU_ITEMS"][$newKey]["price"] = $newPrice;
			?> 
				<meta http-equiv="refresh" content="0;url=http://localhost/ITDOM2/ITDOM_Finals/pages/homePage.php"> 
			<?php
		}

		function setName($item, $newValue){    
			$_SESSION["MENU_ITEMS"][$item]['longname'] = $newValue; 
		}
		function setPrice($item, $newValue){
			$_SESSION["MENU_ITEMS"][$item]['price'] = $newValue;
		}
		function setImage($item, $newValue){
			$_SESSION["MENU_ITEMS"][$item]['image'] = $newValue;
		}
	    
        function checkAccess(){
            if(isset($_SESSION['ACCESS'])){
                $userAccess = $_SESSION['ACCESS'];
                if($userAccess == "SUPER"){
                    //show add item + user
                } else if($userAccess == "ADMIN"){
                    echo ("
                        <form
                            method=\""."post\""."
                            action=\""."orderReciept.php\""."
                        >
                            <li class=\""."nav-item\"".">
                                <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." name=\""."finish_order\""." value=\""."Cart\""." style=\""."color: white; margin-right: 5px;\""."/>
                            </li>
                        </form>
                        <form
                            method=\""."post\""."
                            action=\""."homePage.php\""."
                        >
                            <li class=\""."nav-item\"".">
                                <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." name=\""."logout_user\""." value=\""."Sign out\""." style=\""."color: white; margin-right: 5px;\""."/>
                            </li>
                        </form>
                        <li class=\""."nav-item\"".">
                            <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."createItem.php\""." style=\""."color: white; margin-right: 5px;\"".">New Item</a>
                        </li>
                    ");
                    echo ("
                        <li class=\""."nav-item\"".">
                            <a class=\""." nav-link disabled active\""." aria-current=\""."page\""." style=\""."color: white; margin-right: 5px;\""."> Welcome, ". $_SESSION['FULLNAME'] ."</a>
                        </li>
                    ");
                } else if($userAccess == "MEMBER"){
                    echo ("
                        <form
                            method=\""."post\""."
                            action=\""."orderReciept.php\""."
                        >
                            <li class=\""."nav-item\"".">
                                <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." name=\""."finish_order\""." value=\""."Cart\""." style=\""."color: white; margin-right: 5px;\""."/>
                            </li>
                        </form>
                        <form
                            method=\""."post\""."
                            action=\""."homePage.php\""."
                        >
                            <li class=\""."nav-item\"".">
                                <input type=\""."submit\""." class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." name=\""."logout_user\""." value=\""."Sign out\""." style=\""."color: white; margin-right: 5px;\""."/>
                            </li>
                        </form>
                        <li class=\""."nav-item\"".">
                            <a class=\""." nav-link disabled active\""." aria-current=\""."page\""." style=\""."color: white; margin-right: 5px;\""."> Welcome, ". $_SESSION['FULLNAME'] ."</a>
                        </li>
                    ");
                }
            } else {
                    echo ("
                        <form
                            method=\""."post\""."
                            action=\""."orderReciept.php\""."
                        >
                            <li class=\""."nav-item\"".">
                                <input type=\""."submit\""." class=\""."nav-link disabled  btn btn-outline-light\""." name=\""."finish_order\""." value=\""."Cart\""." style=\""." color: gray; margin-right: 5px;\""."/>
                            </li>
                        </form>
                        <a class=\""."nav-link btn btn-outline-light\""." aria-current=\""."page\""." href=\""."loginPage.php\""." style=\""." color: white; margin-right: 5px;\"".">Sign in</a>
                    ");
                }
        }

        function reloadPage(){
            echo("<meta http-equiv='refresh' content='1'>");
        }
    ?>
</body>
</html>