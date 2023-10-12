<?php
session_start();

function debug_to_console($data, $context = 'Debug in Console')
{

  // Buffering to solve problems frameworks, like header() in this and not a solid return.
  ob_start();

  $output  = 'console.info(\'' . $context . ':\');';
  $output .= 'console.log(' . json_encode($data) . ');';
  $output  = sprintf('<script>%s</script>', $output);

  echo $output;
}
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
  <div class="row py-2" style="background-color:#ffa500; top: 0;">
    <div class="col-12">
      <ul class="nav nav-underline justify-content-center">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="homepage.php" style="font-weight: bold; color: white;">Compute your tax</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="row justify-content-center align-items-center mt-5">
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST[$_SESSION['FUNCTIONS']["F2"]])) {
        computeTax($_SESSION['TAX_TYPE']);
      }
    } else {
      // printLayout($TAX_TYPE);
    }

    function printLayout($tax_type)
    {
      if ($tax_type == "income") {
        echo ('
          <div class="col-5 m-3">
            <div class="row mt-4">
              <div class="card col-12">
                <div class="card-body row">
                  <div class="row mt-3 align-items-center">
                    <form 
                      method="post" 
                      action="result.php" 
                      id="taxForm"
                    >
                      <div class="form row">
                        <div class="col-5">
                          <b><label for="tax_type" class="col-form-label">Select Tax Type:</label></b>
                        </div>
                        <div class="col-6">
                          <select class="form-control" name="change_tax" id="tax_type" disabled>
                            <option value="income">Income Tax</option>
                            <option value="capital_gains">Capital Gains Tax</option>
                            <option value="estate">Estate Tax</option>
                            <option value="percentage">Percentage Tax</option>
                            <option value="value-added">Value-Added Tax</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-12 card mt-3">
                    <form 
                      method="post" 
                      action="homepage.php" 
                      id="computeTax"
                    >
                      <div class="row mt-3">
                        <div class="col-5">
                          <b>Period of Income</b>
                        </div>
                        <div class="col-6">
                          <div class="form-check form-check-inline">');
        if ($_POST['income_period'] == "monthly") {
          echo ('<input class="form-check-input" type="radio" name="income_period" id="flexRadioDefault1" checked disabled>');
        } else {
          echo ('<input class="form-check-input" type="radio" name="income_period" id="flexRadioDefault1" disabled>');
        }
        echo ('<label class="form-check-label" for="flexRadioDefault1">
                              Monthly
                            </label>
                          </div>
                          <div class="form-check form-check-inline">');
        if ($_POST['income_period'] == "annually") {
          echo ('<input class="form-check-input" type="radio" name="income_period" id="flexRadioDefault2" checked disabled>');
        } else {
          echo ('<input class="form-check-input" type="radio" name="income_period" id="flexRadioDefault2" disabled>');
        }
        echo ('<label class="form-check-label" for="flexRadioDefault2">
                              Annually
                            </label>
                          </div>
                        </div>
                      </div>');
        echo ('<div class="row mt-3">
                        <div class="col-5">
                          <b>Income (in PHP)</b>
                        </div>
                        <div class="col-6">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1" name="income_value" value="' . $_POST["income_value"] . '" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-2">
                          <div class="input-group mb-3">
                            <input type="submit" class="btn btn-dark" value="Return">
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
                <div class="card-body row mt-2 mb-5">
                <h3><b> Your tax breakdown report is as follows: </b></h3>
                  <div class="col-12">
                    <p><b> CONTRIBUTIONS </b></p>
                  </div>
                  <div class="col-5">
                    <p> PHILHEALTH </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_SESSION['PHILHEALTH'] . '</b></p>
                  </div>
                  <div class="col-5">
                    <p> PAGIBIG </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_SESSION['PAGIBIG'] . '</b></p>
                  </div>
                  <div class="col-5">
                    <p> SSS REGULAR </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_SESSION['SSS_REGULAR'] . '</b></p>
                  </div>
                  <div class="col-5">
                    <p> SSS MPF </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_SESSION['SSS_MPF'] . '</b></p>
                  </div>
                  <div class="col-12">
                    <p> Adding this altogether, your <b>non-taxable income</b> amounts to <b>₱' . $_SESSION['NONTAXABLE_INCOME'] . '</b></p>
                  </div>
                  <div class="col-12">
                    <p> After deducting your contributions, your <b>taxable income</b> amounts to <b>₱' . $_SESSION['TAXABLE_INCOME'] . '</b></p>
                  </div>
                  <div class="col-12">
                    <p> This will lead your <b>annual income tax</b> amounting to <b>₱' . $_SESSION['TAX'] . '</b></p>
                  </div>
                  <div class="col-8">
                    <p> And a <b>final take-home amount</b> of <b>₱' . $_SESSION['FINAL_INCOME'] . '</b></p>
                  </div>
                  <div class="col-4">
                    <a href="#"><i>How was this calculated?</i></a>
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
                          <select class="form-control" name="change_tax" id="tax_type" disabled>
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
                  <div class="col-12 card mt-3">
                    <form 
                      method="post" 
                      action="homepage.php" 
                      id="computeTax"
                    >
                    <div class="row mt-3">
                      <div class="col-5">
                        <b>CGT Base</b>
                      </div>
                      <div class="col-6">
                        <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="CGT Base" aria-label="income" aria-describedby="basic-addon1" name="cgt_value" value= ' . $_POST["cgt_base"] . '>
                        </div>
                      </div>
                    </div>

                      <div class="row justify-content-center">
                        <div class="col-2">
                          <div class="input-group mb-3">
                            <input type="submit" class="btn btn-dark" value="Return">
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
                <div class="card-body row mt-2 mb-5">
                <h3><b> Your tax breakdown report is as follows: </b></h3>
                  <div class="col-12">
                    <p><b> Capital Gains Tax </b></p>
                  </div>
                  <div class="col-5">
                    <p> CGT BASE </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_POST['cgt_base'] . '</b></p>
                  </div>
                  <div class="col-8">
                    <p> You will be required to pay an amount of <b>₱' . $_SESSION['CGT'] . '</b> in <b>capital gains tax</b> from your sale. </p>
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
                          <select class="form-control" name="change_tax" id="tax_type" disabled>
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
                      action="homepage.php" 
                      id="computeTax"
                    >
                      <div class="row mt-3">
                        <div class="col-5">
                          <b>Type of VAT</b>
                        </div>
                        <div class="col-6">
                          <div class="form-check form-check-inline">');
        if ($_POST['vat_type'] == "gross") {
          echo ('<input class="form-check-input" type="radio" name="vat_type" id="flexRadioDefault1" checked disabled>');
        } else {
          echo ('<input class="form-check-input" type="radio" name="vat_type" id="flexRadioDefault1" disabled>');
        }
        echo ('<label class="form-check-label" for="flexRadioDefault1">
                              Gross
                            </label>
                          </div>
                          <div class="form-check form-check-inline">');
        if ($_POST['vat_type'] == "nett") {
          echo ('<input class="form-check-input" type="radio" name="vat_type" id="flexRadioDefault2" checked disabled>');
        } else {
          echo ('<input class="form-check-input" type="radio" name="vat_type" id="flexRadioDefault2" disabled>');
        }
        echo ('<label class="form-check-label" for="flexRadioDefault2">
                              Nett
                            </label>
                          </div>
                        </div>
                      </div>');
        echo ('<div class="row mt-3">
                        <div class="col-5">
                          <b>Amount</b>
                        </div>
                        <div class="col-6">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Income" aria-label="income" aria-describedby="basic-addon1" name="income_value" value="' . $_POST["vat_amount"] . '" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-2">
                          <div class="input-group mb-3">
                            <input type="submit" class="btn btn-dark" value="Return">
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
                <div class="card-body row mt-2">
                <h3><b> Your tax breakdown report is as follows: </b></h3>
                  <div class="col-5">
                    <p> Gross Amount </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_SESSION['VAT_GROSS'] . '</b></p>
                  </div>
                  <div class="col-5">
                    <p> Nett Amount </p>
                  </div>
                  <div class="col-6">
                    <p><b>₱' . $_SESSION['VAT_NETT'] . '</b></p>
                  </div>
                  <div class="col-3">
                    <p> VAT </p>
                  </div>
                  <div class="col-3">
                    <p><b>₱' . $_SESSION['VAT'] . '</b></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        ');
      }
    }

    function computeTax($tax_type)
    {
      $RATES = $_SESSION['RATES'];
      if ($tax_type == "income") {
        $period = $_POST['income_period'] == "monthly";
        $period = $period ? 12 : 1;
        $value = $_POST['income_value'];

        $_SESSION['ANNUITY'] = $ANNUITY = ($period * $value);
        $_SESSION['MONTHLY'] = $MONTHLY = $ANNUITY / 12;

        // PHILHEALTH
        $PHILHEALTH = $_SESSION['PHILHEALTH_VARIABLES'];
        $PHILHEALTH_FLOOR = $PHILHEALTH['FLOOR'];
        $PHILHEALTH_CEILING = $PHILHEALTH['CEILING'];
        $PHILHEALTH_RATE = $PHILHEALTH['RATE'];
        if ($MONTHLY > $PHILHEALTH_FLOOR && $MONTHLY <= $PHILHEALTH_CEILING) {
          $_SESSION['PHILHEALTH'] = $MONTHLY * $PHILHEALTH_RATE;
        } else if ($MONTHLY > $PHILHEALTH_CEILING) {
          $_SESSION['PHILHEALTH'] = $PHILHEALTH_CEILING * $PHILHEALTH_RATE;
        } else {
          $_SESSION['PHILHEALTH'] = 0;
        }

        // PAG-IBIG
        $PAGIBIG = $_SESSION['PAGIBIG_VARIABLES'];
        $PAGIBIG_RATE_MIN = $PAGIBIG["RATE_MIN"];
        $PAGIBIG_RATE_MAX = $PAGIBIG["RATE_MAX"];
        $PAGIBIG_FLOOR = $PAGIBIG['FLOOR'];
        $PAGIBIG_CEILING = $PAGIBIG['CEILING'];
        if ($MONTHLY <= $PAGIBIG_FLOOR) {
          $_SESSION['PAGIBIG'] = $MONTHLY * $PAGIBIG_RATE_MIN;
        } else if ($MONTHLY > $PAGIBIG_FLOOR && $MONTHLY < $PAGIBIG_CEILING) {
          $_SESSION['PAGIBIG'] = $MONTHLY * $PAGIBIG_RATE_MAX;
        } else if ($MONTHLY >= $PAGIBIG_CEILING) {
          $_SESSION['PAGIBIG'] = $PAGIBIG_CEILING * $PAGIBIG_RATE_MAX;
        }

        // SSS
        $SSS = $_SESSION['SSS_VARIABLES'];
        $SSS_FLOOR = $SSS['FLOOR'];
        $SSS_CEILING = $SSS['CEILING'];
        $SSS_RANGE = $SSS["RANGE"];
        $SSS_INCREASE = $SSS["INCREASE"];

        // $SSS_FLOOR = $SSS['FLOOR'];
        // $SSS_CEILING = $SSS['CEILING'];
        $SSS_REGULAR_MIN = $SSS["REGULAR_MIN"];
        $SSS_REGULAR_MAX = $SSS["REGULAR_MAX"];
        $SSS_REGULAR_CUTOFF = $SSS["REGULAR_CUTOFF"];
        $_SESSION['SSS_REGULAR'] = computeSSS_REGULAR($MONTHLY, $SSS_FLOOR, $SSS_CEILING, $SSS_REGULAR_MIN, $SSS_REGULAR_MAX, $SSS_REGULAR_CUTOFF, $SSS_RANGE, $SSS_INCREASE);

        // $SSS_FLOOR = $SSS['FLOOR'];
        // $SSS_CEILING = $SSS['CEILING'];
        $SSS_MPF_MIN = $SSS["MPF_MIN"];
        $SSS_MPF_MAX = $SSS["MPF_MAX"];
        $SSS_MPF_CUTOFF = $SSS["MPF_CUTOFF"];
        $_SESSION['SSS_MPF'] = computeSSS_MPF($MONTHLY, $SSS_FLOOR, $SSS_CEILING, $SSS_MPF_MIN, $SSS_MPF_MAX, $SSS_MPF_CUTOFF, $SSS_RANGE, $SSS_INCREASE);

        debug_to_console($_SESSION['SSS_REGULAR']);
        debug_to_console($_SESSION['SSS_MPF']);

        // TAX
        $_SESSION['PHILHEALTH'] = $total_PHILHEALTH = ($_SESSION['PHILHEALTH'] * 12) / 2;
        $_SESSION['PAGIBIG'] = $total_PAGIBIG = $_SESSION['PAGIBIG'] * 12;
        $_SESSION['SSS_REGULAR'] = $total_SSS_REGULAR = $_SESSION['SSS_REGULAR'] * 12;
        $_SESSION['SSS_MPF'] = $total_SSS_MPF = $_SESSION['SSS_MPF'] * 12;

        $_SESSION['NONTAXABLE_INCOME'] = $total_CONTRIBUTIONS = $total_PHILHEALTH + $total_PAGIBIG + $total_SSS_REGULAR + $total_SSS_MPF;

        $_SESSION['TAXABLE_INCOME'] = $taxable_income = $ANNUITY - $total_CONTRIBUTIONS;

        switch (true) {
          case ($taxable_income < 250000):
            $_SESSION['TAX'] = 0;
            break;
          case in_array($taxable_income, range(250000, 400000)):
            $excess = $taxable_income - 250000;
            $_SESSION['TAX'] = ($excess * 0.15);
            break;
          case in_array($taxable_income, range(400000, 800000)):
            $excess = $taxable_income - 400000;
            $_SESSION['TAX'] = ($excess * 0.20) + 22500;
            break;
          case in_array($taxable_income, range(800000, 2000000)):
            $excess = $taxable_income - 800000;
            $_SESSION['TAX'] = ($excess * 0.25) + 102500;
            break;
          case in_array($taxable_income, range(2000000, 8000000)):
            $excess = $taxable_income - 2000000;
            $_SESSION['TAX'] = ($excess * 0.30) + 402500;
            break;
          case ($taxable_income > 8000000):
            $excess = $taxable_income - 8000000;
            $_SESSION['TAX'] = ($excess * 0.35) + 2205000;
            break;
          default:
            $_SESSION['TAX'] = 0;
            break;
        }

        $_SESSION['FINAL_INCOME'] = $taxable_income - $_SESSION['TAX'];
      } else if ($tax_type == "capital_gains") {
        $CGT_BASE = $_POST['cgt_base'];

        $_SESSION['CGT'] = $CGT_BASE * $RATES['CGT'];
      } else if ($tax_type == "value-added") {
        $TYPE = $_POST['vat_type'];
        $AMOUNT = $_POST['vat_amount'];
        $VAT = $RATES['VAT'];
        $GROSS = $RATES['VAT_GROSS'];

        if ($TYPE == "gross") {
          $_SESSION['VAT'] = round(($AMOUNT * $VAT) / ($GROSS), 2);
          $_SESSION['VAT_GROSS'] = $AMOUNT;
          $_SESSION['VAT_NETT'] = round(($AMOUNT - $_SESSION['VAT']), 2);
        } else {
          $_SESSION['VAT'] = round(($AMOUNT * $VAT), 2);
          $_SESSION['VAT_GROSS'] = round($AMOUNT + $_SESSION['VAT'], 2);
          $_SESSION['VAT_NETT'] = $AMOUNT;
        }
      }

      $TAX_TYPE = $_SESSION['TAX_TYPE'];
      printLayout($TAX_TYPE);
    }

    function computeSSS_REGULAR($MONTHLY, $FLOOR, $CEILING, $MIN, $MAX, $CUTOFF, $RANGE, $INCREASE)
    {
      if ($MONTHLY >= $CUTOFF) {

        return ($MAX);
      } else if ($MONTHLY <= $FLOOR) {
        return ($MIN);
      } else if (in_array($MONTHLY, range($FLOOR, $CEILING))) {
        return ($MIN);
      } else {
        $new_FLOOR = $FLOOR + $RANGE;
        $new_CEILING = $CEILING + $RANGE;
        $new_MIN = $MIN + $INCREASE;
        computeSSS_REGULAR($MONTHLY, $new_FLOOR, $new_CEILING, $new_MIN, $MAX, $CUTOFF, $RANGE, $INCREASE);
      }
    }

    function computeSSS_MPF($MONTHLY, $FLOOR, $CEILING, $MIN, $MAX, $CUTOFF, $RANGE, $INCREASE)
    {
      if ($MONTHLY >= $CUTOFF) {
        return ($MAX);
      } else if ($MONTHLY <= $FLOOR) {
        return ($MIN);
      } else if (in_array($MONTHLY, range($FLOOR, $CEILING))) {
        return ($MIN);
      } else {
        $new_FLOOR = $FLOOR + $RANGE;
        $new_CEILING = $CEILING + $RANGE;
        $new_MIN = $MIN + $INCREASE;
        computeSSS_MPF($MONTHLY, $new_FLOOR, $new_CEILING, $new_MIN, $MAX, $CUTOFF, $RANGE, $INCREASE);
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