<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tax Calculator</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
    body {
      background-color: #ffe0b2;
      /* Lighter orange color */
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #ffa500;
      /* Lighter orange color */
    }

    .navbar a.nav-link {
      color: #fff;
    }

    .navbar a.nav-link:hover {
      color: #ffcc00;
    }

    .content {
      min-height: calc(100vh - 120px);
      padding: 20px;
    }

    .footer {
      background-color: #ffa500;
      /* Lighter orange color for the footer */
      color: #fff;
      text-align: center;
      padding: 10px 0;
      position: absolute;
      bottom: 0;
      width: 100%;
    }

    /* Style the Terms and Conditions text */
    .terms-and-conditions {
      font-family: Arial, sans-serif;
      font-size: 20px;
      line-height: 1.6;
      text-align: justify;
    }
  </style>
</head>

<body>
  <div class="row p-3" style="background-color:#ffa500; top: 0;">
    <div class="col-12">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="homepage.php" style="color: black">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php" style="color: black">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="learnmore.php" style="color: black">Learn More</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="content">
    <div class="container mt-4">
      <div class="card">
        <div class="card-body terms-and-conditions">
          <p><strong>Terms and Conditions</strong></p>
          <p>We are Karl Divina and Kyle Sison, students of San Beda College Alabang at Muntinlupa City.
            You can contact us via email at kylemsison@gmail.com or divinakarlangelo@gmail.com, or by mail to San Beda College Alabang, Muntinlupa City, Metro Manila, Philippines.</p>
          <p>These Legal Terms constitute a legally binding agreement made between you, whether personally or on behalf of an entity ("you"), and Karl Divina and Kyle Sison, concerning your access to and use of the Services. You agree that by accessing the Services, you have read, understood, and agreed to be bound by all of these Legal Terms. IF YOU DO NOT AGREE WITH ALL OF THESE LEGAL TERMS, THEN YOU ARE EXPRESSLY PROHIBITED FROM USING THE SERVICES AND YOU MUST DISCONTINUE USE IMMEDIATELY.</p>
          <p>We will provide you with prior notice of any scheduled changes to the Services you are using. Changes to Legal Terms will become effective seven (7) days after the notice is given, except if the changes apply to new functionality, security updates, and bug fixes, in which case the changes will be effective immediately. By continuing to use the Services after the effective date of any changes, you agree to be bound by the modified terms. If you disagree with such changes, you may terminate Services as per deletion of account.</p>
          <p>The Services are intended for users who are at least 18 years old. Persons under the age of 18 are not permitted to use or register for the Services.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="footer">
    <div class="container">
      <p>&copy; 2023 Divina & Sison</p>
      <a href="terms.php">Terms and Conditions</a>
      <span class="mx-2">|</span>
      <a href="privacy.php">Privacy Policy</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>