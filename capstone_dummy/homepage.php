<?php
session_start();

$_SESSION['FUNCTIONS'] = array(
  "F1" => "change_tax",
  "F2" => "compute_tax",
  "F3" => "clear_tax",
  "F4" => "login_user",
  "F5" => "register_user",
  "F6" => "check_user",
  "F7" => "logout_user"
);

if (!isset($_SESSION['CREDENTIALS'])) {
  $_SESSION['CREDENTIALS'] = array();
} else {
  $CREDENTIALS = $_SESSION['CREDENTIALS'];
}

if (!isset($_SESSION['TAX_TYPE'])) {
  $_SESSION['TAX_TYPE'] = $TAX_TYPE = "income";
} else {
  if (isset($_POST['change_tax'])) {
    $_SESSION['TAX_TYPE'] = $TAX_TYPE = $_POST['change_tax'];
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tax Calculator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="container-fluid">
  <div class="row p-3" style="background-color:bisque; top: 0;">
    <div class="col-12">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php" style="color: black">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="learnmore.php" style="color: black">Learn More</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Log In</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="row justify-content-center align-items-center mt-5">
    <?php
    printLayout($TAX_TYPE)
    ?>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST[$_SESSION['FUNCTIONS']["F7"]])) { //logout
        logoutUser();
      } else if (empty($_POST[$_SESSION['FUNCTIONS']["F6"]])) {
        registerUser();
      } else if (empty($_POST[$_SESSION['FUNCTIONS']["F5"]])) {
        checkUser();
      } else if (empty($_POST[$_SESSION['FUNCTIONS']["F4"]])) {
        loginUser();
      } else if (empty($_POST[$_SESSION['FUNCTIONS']["F3"]])) {
        clearTax();
      } else if (empty($_POST[$_SESSION['FUNCTIONS']["F2"]])) {
        computeTax($TAX_TYPE);
      } else if (empty($_POST[$_SESSION['FUNCTIONS']["F1"]])) {
        changeTax();
      }
    } else {
      // printLayout($TAX_TYPE);
    }

    function printLayout($tax_type)
    {
      //  = $_SESSION['TAX_TYPE'];

      if ($tax_type == "income") {
        echo ('
          <div class="col-5 m-3">
            <div class="row mt-4">
              <div class="card col-12">
                <div class="card-body row">
                  <div class="row mt-3 align-items-center">
                    <form method="post" action="homepage.php" id="taxForm">
                      <div class="form row">
                        <div class="col-5">
                          <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                        </div>
                        <div class="col-6">
                          <select class="form-control" name="change_tax" id="tax_type">
                            <option value="income">Income Tax</option>
                            <option value="capital_gains">Capital Gains Tax</option>
                            <option value="estate">Estate Tax</option>
                            <option value="percentage">Percentage Tax</option>
                            <option value="value-added">Value-Added Tax</option>
                            <option value="witholding">Witholding Tax</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  
                  <div class="row mt-3">
                    <div class="col-5">
                      <b>Period of Income</b>
                    </div>
                    <div class="col-6">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Monthly
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                          Yearly
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-5">
                      <b>Income (in PHP)</b>
                    </div>
                    <div class="col-6">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1">
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3 mb-3">
                    <div class="col-5">
                      <b>Government Employed</b>
                    </div>
                    <div class="col-6">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Yes (GSIS)
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                          No (SSS)
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class="col-5 m-3">
            <div class="row mt-4">
              <div class="card col-12">
                <div class="card-body row mt-3">
                  <div class="col-4">
                    <p><b>Period of Income</b></p>
                  </div>
                  <div class="col-6">
                    <p>The period of your indicated income</p>
                  </div>
                  <div class="col-4">
                    <p><b>Income (in PHP)</b></p>
                  </div>
                  <div class="col-6">
                    <p>The amount of your income in PHP</p>
                  </div>
                  <div class="col-4">
                    <p><b>Government Employment</b></p>
                  </div>
                  <div class="col-6">
                    <p>If you are a government employee</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ');
      } else if ($tax_type == "capital_gains") {
        echo ('
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row">
                <div class="row mt-3 align-items-center">
                  <form method="post" action="homepage.php" id="taxForm">
                    <div class="form row">
                      <div class="col-5">
                        <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                      </div>
                      <div class="col-6">
                        <select class="form-control" name="change_tax" id="tax_type">
                          <option value="capital_gains">Capital Gains Tax</option>
                          <option value="estate">Estate Tax</option>
                          <option value="income">Income Tax</option>
                          <option value="percentage">Percentage Tax</option>
                          <option value="value-added">Value-Added Tax</option>
                          <option value="witholding">Witholding Tax</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Period of Income</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Monthly
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        Yearly
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Income (in PHP)</b>
                  </div>
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1">
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-3">
                  <div class="col-5">
                    <b>Government Employed</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Yes (GSIS)
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        No (SSS)
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row mt-3">
                <div class="col-4">
                  <p><b>Period of Income</b></p>
                </div>
                <div class="col-6">
                  <p>The period of your indicated income</p>
                </div>
                <div class="col-4">
                  <p><b>Income (in PHP)</b></p>
                </div>
                <div class="col-6">
                  <p>The amount of your income in PHP</p>
                </div>
                <div class="col-4">
                  <p><b>Government Employment</b></p>
                </div>
                <div class="col-6">
                  <p>If you are a government employee</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        ');
      } else if ($tax_type == "estate") {
        echo ('
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row">
                <div class="row mt-3 align-items-center">
                  <form method="post" action="homepage.php" id="taxForm">
                    <div class="form row">
                      <div class="col-5">
                        <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                      </div>
                      <div class="col-6">
                        <select class="form-control" name="change_tax" id="tax_type">
                          <option value="estate">Estate Tax</option>
                          <option value="capital_gains">Capital Gains Tax</option>
                          <option value="income">Income Tax</option>
                          <option value="percentage">Percentage Tax</option>
                          <option value="value-added">Value-Added Tax</option>
                          <option value="witholding">Witholding Tax</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Period of Income</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Monthly
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        Yearly
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Income (in PHP)</b>
                  </div>
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1">
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-3">
                  <div class="col-5">
                    <b>Government Employed</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Yes (GSIS)
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        No (SSS)
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row mt-3">
                <div class="col-4">
                  <p><b>Period of Income</b></p>
                </div>
                <div class="col-6">
                  <p>The period of your indicated income</p>
                </div>
                <div class="col-4">
                  <p><b>Income (in PHP)</b></p>
                </div>
                <div class="col-6">
                  <p>The amount of your income in PHP</p>
                </div>
                <div class="col-4">
                  <p><b>Government Employment</b></p>
                </div>
                <div class="col-6">
                  <p>If you are a government employee</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        ');
      } else if ($tax_type == "percentage") {
        echo ('
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row">
                <div class="row mt-3 align-items-center">
                  <form method="post" action="homepage.php" id="taxForm">
                    <div class="form row">
                      <div class="col-5">
                        <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                      </div>
                      <div class="col-6">
                        <select class="form-control" name="change_tax" id="tax_type">
                          <option value="percentage">Percentage Tax</option>
                          <option value="capital_gains">Capital Gains Tax</option>
                          <option value="estate">Estate Tax</option>
                          <option value="income">Income Tax</option>
                          <option value="value-added">Value-Added Tax</option>
                          <option value="witholding">Witholding Tax</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Period of Income</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Monthly
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        Yearly
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Income (in PHP)</b>
                  </div>
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1">
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-3">
                  <div class="col-5">
                    <b>Government Employed</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Yes (GSIS)
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        No (SSS)
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row mt-3">
                <div class="col-4">
                  <p><b>Period of Income</b></p>
                </div>
                <div class="col-6">
                  <p>The period of your indicated income</p>
                </div>
                <div class="col-4">
                  <p><b>Income (in PHP)</b></p>
                </div>
                <div class="col-6">
                  <p>The amount of your income in PHP</p>
                </div>
                <div class="col-4">
                  <p><b>Government Employment</b></p>
                </div>
                <div class="col-6">
                  <p>If you are a government employee</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        ');
      } else if ($tax_type == "value-added") {
        echo ('
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row">
                <div class="row mt-3 align-items-center">
                  <form method="post" action="homepage.php" id="taxForm">
                    <div class="form row">
                      <div class="col-5">
                        <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                      </div>
                      <div class="col-6">
                        <select class="form-control" name="change_tax" id="tax_type">
                          <option value="value-added">Value-Added Tax</option>
                          <option value="capital_gains">Capital Gains Tax</option>
                          <option value="estate">Estate Tax</option>
                          <option value="income">Income Tax</option>
                          <option value="percentage">Percentage Tax</option>
                          <option value="witholding">Witholding Tax</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Period of Income</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Monthly
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        Yearly
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Income (in PHP)</b>
                  </div>
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1">
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-3">
                  <div class="col-5">
                    <b>Government Employed</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Yes (GSIS)
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        No (SSS)
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row mt-3">
                <div class="col-4">
                  <p><b>Period of Income</b></p>
                </div>
                <div class="col-6">
                  <p>The period of your indicated income</p>
                </div>
                <div class="col-4">
                  <p><b>Income (in PHP)</b></p>
                </div>
                <div class="col-6">
                  <p>The amount of your income in PHP</p>
                </div>
                <div class="col-4">
                  <p><b>Government Employment</b></p>
                </div>
                <div class="col-6">
                  <p>If you are a government employee</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        ');
      } else if ($tax_type == "witholding") {
        echo ('
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row">
                <div class="row mt-3 align-items-center">
                  <form method="post" action="homepage.php" id="taxForm">
                    <div class="form row">
                      <div class="col-5">
                        <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                      </div>
                      <div class="col-6">
                        <select class="form-control" name="change_tax" id="tax_type">
                          <option value="witholding">Witholding Tax</option>
                          <option value="capital_gains">Capital Gains Tax</option>
                          <option value="estate">Estate Tax</option>
                          <option value="income">Income Tax</option>
                          <option value="percentage">Percentage Tax</option>
                          <option value="value-added">Value-Added Tax</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Period of Income</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Monthly
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        Yearly
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-5">
                    <b>Income (in PHP)</b>
                  </div>
                  <div class="col-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1">
                    </div>
                  </div>
                </div>
                <div class="row mt-3 mb-3">
                  <div class="col-5">
                    <b>Government Employed</b>
                  </div>
                  <div class="col-6">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                        Yes (GSIS)
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        No (SSS)
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-5 m-3">
          <div class="row mt-4">
            <div class="card col-12">
              <div class="card-body row mt-3">
                <div class="col-4">
                  <p><b>Period of Income</b></p>
                </div>
                <div class="col-6">
                  <p>The period of your indicated income</p>
                </div>
                <div class="col-4">
                  <p><b>Income (in PHP)</b></p>
                </div>
                <div class="col-6">
                  <p>The amount of your income in PHP</p>
                </div>
                <div class="col-4">
                  <p><b>Government Employment</b></p>
                </div>
                <div class="col-6">
                  <p>If you are a government employee</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        ');
      }
    }

    function changeTax()
    {
      // $_SESSION['TAX_TYPE'] = $_POST['change_tax'];
      // reloadPage();
    }

    function computeTax($tax_type)
    {
    }

    function clearTax()
    {
    }

    function loginUser()
    {
    }
    function registerUser()
    {
    }
    function checkUser()
    {
    }
    function logoutUser()
    {
    }

    function reloadPage()
    {
      echo ("<meta http-equiv='refresh' content='1'>");
    }



    // code graveyard

    // <div class="row mt-3">
    //   <div class="col-5">
    //     <b>Number of Dependents</b>
    //   </div>
    //   <div class="col-6">
    //     <div class="form-check form-check-inline">
    //       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
    //       <label class="form-check-label" for="flexRadioDefault1">
    //         0
    //       </label>
    //     </div>
    //     <div class="form-check form-check-inline">
    //       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
    //       <label class="form-check-label" for="flexRadioDefault2">
    //         1
    //       </label>
    //     </div>
    //     <div class="form-check form-check-inline">
    //       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
    //       <label class="form-check-label" for="flexRadioDefault2">
    //         2
    //       </label>
    //     </div>
    //     <div class="form-check form-check-inline">
    //       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
    //       <label class="form-check-label" for="flexRadioDefault2">
    //         3 or more
    //       </label>
    //     </div>
    //   </div>
    // </div>

    // dropdown button for tax type
    // <div class="col-5">
    //   <b>Type of Tax:</b>
    // </div>
    // <div class="col-6">
    //   <div class="dropdown">
    //     <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    //       Income Tax
    //     </button>
    //     <ul class="dropdown-menu">
    //         <li><a class="dropdown-item" href="#">Donor's Tax</a></li>
    //         <li><a class="dropdown-item" href="#">Excise Tax</a></li> 
    //       <li><a class="dropdown-item" href="#">Sales Tax</a></li>
    //       <li><a class="dropdown-item" href="#">Capital Gains Tax</a></li>
    //       <li><a class="dropdown-item" href="#">Estate Tax</a></li>
    //       <li><a class="dropdown-item" href="#">Income Tax</a></li>
    //       <li><a class="dropdown-item" href="#">Percentage Tax</a></li>
    //       <li><a class="dropdown-item" href="#">Value-Added Tax</a></li>
    //       <li><a class="dropdown-item" href="#">Witholding Tax</a></li>
    //     </ul>
    //   </div>
    // </div>

    ?>






  </div>

  <div class="footer row card d-flex justify-content-around" style="height: 3em; width: inherit; background-color: bisque; bottom: 0; position: fixed;">
    <div class="card-body col-3 align-self-start" style="left: 0;">Divina & Sison &copy; 2023</div>
    <div class="card-body col-9 d-flex flex-row-reverse">
      <div class="row">
        <!-- <a>Terms and Conditions</a>
        <a>Privacy Policy</a> -->
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  <?php
  // JavaScript block within PHP
  echo '<script>';
  echo '$(document).ready(function() {';
  echo '$("#tax_type").on("change", function () {';
  echo '$("#taxForm").submit();';
  echo '});';
  echo '});';
  echo '</script>';
  ?>
</body>

</html>