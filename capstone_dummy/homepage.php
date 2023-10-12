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
  $_SESSION['TAX_TYPE'] = "income";
} else {
  if (isset($_POST['change_tax'])) {
    $_SESSION['TAX_TYPE'] = $TAX_TYPE = $_POST['change_tax'];
  }
}

$_SESSION['RATES'] = array(
  "CGT" => 0.06,
  "VAT" => 0.12,
  "VAT_GROSS" => 112 / 100
);

$_SESSION['PHILHEALTH_VARIABLES'] = array(
  "FLOOR" => 10000,
  "CEILING" => 80000,
  "RATE" => 0.04
);

$_SESSION['PAGIBIG_VARIABLES'] = array(
  "FLOOR" => 1500,
  "CEILING" => 5000,
  "RATE_MIN" => 0.01,
  "RATE_MAX" => 0.02
);

$_SESSION['SSS_VARIABLES'] = array(
  "FLOOR" => 4249.99,
  "CEILING" => 4750,
  "REGULAR_MIN" => 180,
  "REGULAR_MAX" => 900,
  "REGULAR_CUTOFF" => 19750,
  "MPF_MIN" => 22.5,
  "MPF_MAX" => 450,
  "MPF_CUTOFF" => 29750,
  "RANGE" => 500,
  "INCREASE" => 22.5
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tax Calculator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="capstone.css">
</head>

<body class="container-fluid">
  <div class="row p-3" style="background-color:#ffa500; top: 0;">
    <div class="col-12">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="homepage.php">Compute your tax</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="row justify-content-center align-items-center mt-5">
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST[$_SESSION['FUNCTIONS']["F2"]])) {
        computeTax($_SESSION['TAX_TYPE']);
      }
    } else {
      // printLayout($TAX_TYPE);
    }

    ?>

    <?php
    $TAX_TYPE = $_SESSION['TAX_TYPE'];
    printLayout($TAX_TYPE)
    ?>

    <?php

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
                    <form 
                      method="post" 
                      action="homepage.php" 
                      id="taxForm"
                    >
                      <div class="form row">
                        <div class="col-5">
                          <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                        </div>
                        <div class="col-6">
                          <select class="form-control" name="change_tax" id="tax_type">
                            <option value="income">Income Tax</option>
                            <option value="capital_gains">Capital Gains Tax</option>
                            <option value="value-added">Value-Added Tax</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-12 card mt-3">
                    <form 
                      method="post" 
                      action="result.php" 
                      id="computeTax"
                    >
                      <div class="row mt-3">
                        <div class="col-5">
                          <b>Period of Income</b>
                        </div>
                        <div class="col-6">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="income_period" value="monthly" id="period_monthly" checked>
                            <label class="form-check-label" for="period_monthly">
                              Monthly
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="income_period" value="annually" id="period_annually">
                            <label class="form-check-label" for="period_annually">
                              Annually
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-3 ml-2">
                        <div class="col-5">
                          <b>Income (in PHP)</b>
                        </div>
                        <div class="col-6">
                          <div class="input-group mb-3">
                            <input 
                            type="text" 
                            oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*?)\..*/g, \'$1\').replace(/^0[^.]/, \'0\');" 
                            class="form-control"  
                            placeholder="Income" 
                            aria-label="income"
                            aria-describedby="basic-addon1"
                            name="income_value"
                            id="income_value"
                          >
                          </div>
                        </div>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-2">
                          <div class="input-group mb-3">
                            <input 
                              type="submit" 
                              class="btn btn-dark" 
                              value="Submit" 
                              name="compute_tax"
                            >
                          </div>
                        </div>
                      </div>
                    </form>
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
                            <option value="income">Income Tax</option>
                            <option value="value-added">Value-Added Tax</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-12 card mt-3">
                    <form 
                      method="post" 
                      action="result.php" 
                      id="computeTax"
                    >
                      <div class="row mt-3">
                        <div class="col-5">
                          <b>CGT Base</b>
                        </div>
                        <div class="col-6">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="CGT Base" aria-label="cgt_base" aria-describedby="basic-addon1" name="cgt_base">
                          </div>
                        </div>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-2">
                          <div class="input-group mb-3">
                            <input 
                              type="submit" 
                              class="btn btn-dark" 
                              value="Submit"
                              name="compute_tax"
                            >
                          </div>
                        </div>
                      </div>
                    </form>
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
                    <p><b> CGT Base </b></p>
                  </div>
                  <div class="col-6">
                    <p>The amount of presumed gains by seller from sale or exchange</p>
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
                            <option value="income">Income Tax</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-12 card mt-3">
                    <form 
                      method="post" 
                      action="result.php" 
                      id="computeTax"
                    >
                    <div class="row mt-3">
                      <div class="col-5">
                        <b>Type of VAT</b>
                      </div>
                      <div class="col-6">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="vat_type" value="gross" id="vat_gross" checked>
                          <label class="form-check-label" for="vat_gross">
                            Gross
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="vat_type" value="nett" id="vat_nett">
                          <label class="form-check-label" for="vat_nett">
                            Nett
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3 ml-2">
                      <div class="col-5">
                        <b>Amount</b>
                      </div>
                      <div class="col-6">
                        <div class="input-group mb-3">
                          <input 
                          type="text" 
                          oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*?)\..*/g, \'$1\').replace(/^0[^.]/, \'0\');" 
                          class="form-control"  
                          placeholder="Amount" 
                          aria-label="vat_amount"
                          aria-describedby="basic-addon1"
                          name="vat_amount"
                          id="vat_amount"
                        >
                        </div>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-2">
                        <div class="input-group mb-3">
                          <input 
                            type="submit" 
                            class="btn btn-dark" 
                            value="Submit" 
                            name="compute_tax"
                          >
                        </div>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class="col-5 m-3">
            <div class="row mt-4">
              <div class="card col-12">
                <div class="card-body row mt-3">
                  <div class="col-3 mb-2">
                    <h5><b>Type of VAT</b></h5>
                  </div>
                  <div class="col-3">
                    <p><b>Gross</b></p>
                  </div>
                  <div class="col-6">
                    <p>Amount that is inclusive of VAT</p>
                  </div>
                  <div class="col-3">
                  </div>
                  <div class="col-3">
                    <p><b>Nett</b></p>
                  </div>
                  <div class="col-6">
                    <p>Amount that is exclusive of VAT</p>
                  </div>
                  <div class="col-2">
                    <p><b>Amount</b></p>
                  </div>
                  <div class="col-10">
                    <p>The amount from sale or lease of taxable goods, properties, or services</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ');
      }
    }

    function reloadPage()
    {
      echo ("<meta http-equiv='refresh' content='1'>");
    }
    ?>

  </div>

  <div class="footer row d-flex justify-content-between" style="width: inherit; bottom: 0; position: fixed; margin-bottom: -1em;">
    <div class="col-2">
      <strong>
        <p><a href="terms.php" style="text-decoration: none; color: white;">Terms and Conditions</a></p>
      </strong>
    </div>
    <div class="col-8">
      <strong>
        <p>Divina & Sison &copy; 2023
      </strong>
    </div>
    <div class="col-2">
      <strong>
        <p><a href="privacy.php" style="text-decoration: none; color: white;">Privacy Policy</a></p>
      </strong>
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