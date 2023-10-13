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

  <div class="content">
    <div class="container my-2">
      <div class="card">
        <div class="card-body terms-and-conditions">
          <h3 style="text-align: center;"><strong>Capital Gains Tax</strong></h3>
          <p>
            Capital Gains Tax is the tax imposed on the presumed gains to have been realized by the seller from a sale or exchange. This tax is applied the highest value of presumed gains, which may or may not be the same as the actual gains.
          </p>
          <h4 style="text-align: center;"><strong>Capital Gains Tax Calculation</strong></h4>
          <h5><strong>CGT Base</strong></h5>
          <p>First, identify what you will be using as your Capital Gains Tax Base, or CGT Base. This is the highest amount of presumed gains which you, as the seller, will realize from your sale. </p>
          <h5><strong>TRAIN Law</strong></h5>
          <p>Under TRAIN Law, the percentage which will be applied to calculate for Capital Gains Tax is 6%.</p>
          <h5><strong>Computation</strong></h5>
          <p>By multiplying your CGT Base with the current CGT Rate of 6%, you are able to calculate for the amount of Capital Gains Tax you must pay.</p>
          <p>Ex. CGT Base = ₱3,000,000</p>
          <p><u>CGT Base</u> (₱3,000,000) x <u>CGT Rate</u> (0.06) = <u>₱180,000 in Capital Gains Tax</u> from the sale.</p>
        </div>
      </div>
    </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>