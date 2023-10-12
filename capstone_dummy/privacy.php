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
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      flex-grow: 1;
      padding: 20px;
      border: 1px solid #ffa500;
      /* Add a border around the content */
      border-radius: 10px;
      /* Optional: Add rounded corners to the border */
    }

    .footer {
      background-color: #ffa500;
      /* Lighter orange color for the footer */
      color: #fff;
      text-align: center;
      padding: 10px 0;
    }

    /* Style the Terms and Conditions text */
    .terms-and-conditions {
      font-family: Arial, sans-serif;
      font-size: 16px;
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
        <!-- <li class="nav-item">
          <a class="nav-link" href="about.php" style="color: black">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="learnmore.php" style="color: black">Learn More</a>
        </li> -->
      </ul>
    </div>
  </div>

  <div class="content">
    <div class="container mt-4">
      <div class="card">
        <div class="card-body terms-and-conditions">
          <p><strong>Privacy Policy</strong></p>
          This Privacy Policy is designed to help you understand how PH Tax Calculator ("we," "our," or "us") collects, uses, discloses, and protects your personal information when you use our tax calculator website. We are committed to ensuring the privacy and security of your information. By using our website, you agree to the terms outlined in this policy. If you do not agree with our practices, please do not use our website.

          <p><strong>Information We Collect:</strong></p>
          <p>1.1. Personal Information: When you use our website, we may collect personal information that can identify you, such as your name, email address, and contact details. We collect this information when you voluntarily provide it to us through contact forms, email, or other means.</p>

          <p>1.2. Usage Information: We may collect information about your use of our website, including but not limited to your IP address, device type, browser type, and the pages you visit. We use this data to improve our website's performance and functionality.</p>

          <p><strong>How We Use Your Information:</strong></p>
          <p>2.1. Providing Services: We use the information you provide to offer and improve our tax calculator services. This includes generating tax calculations and providing accurate results.</p>

          <p>2.2. Communication: We may use your contact information to respond to your inquiries, provide updates, and deliver important service-related messages.</p>

          <p>2.3. Improvement and Analysis: We analyze usage data to improve our website's functionality and to optimize the user experience.</p>

          <p><strong>Disclosure of Your Information:</strong></p>
          <p>3.1. Service Providers: We may share your information with trusted third-party service providers to help us operate our website, deliver our services, or manage our business. These service providers are obligated to keep your information confidential and use it only for the purposes we specify.</p>

          <p>3.2. Legal Requirements: We may disclose your information if required by law, in response to a valid court order, government request, or to protect our rights, privacy, safety, or property.</p>

          <p>3.3. Business Transfers: In the event that our website is acquired by or merged with another company, your information may be transferred as part of the transaction. We will notify you of such changes.</p>

          <!-- <p><strong>Cookies and Tracking Technologies:</strong></p>
          <p>We use cookies and similar tracking technologies to improve your experience on our website. You can manage your preferences for these technologies through your browser settings. For more information, please review our <a href="#">Cookie Policy</a> available on our website.</p> -->

          <p><strong>Security:</strong></p>
          <p>We take reasonable measures to protect your information from unauthorized access or disclosure. However, no data transmission over the internet can be guaranteed as 100% secure. Please be cautious when sharing personal information online.</p>

          <p><strong>Your Privacy Choices:</strong></p>
          <p>You have the right to access, update, or delete your personal information. You can also opt out of receiving promotional communications from us. To exercise these rights or for any privacy-related concerns, please contact us at divinakarlangelo@gmail.com or kylemsison@gmail.com.</p>

          <p><strong>Changes to this Privacy Policy:</strong></p>
          <p>We reserve the right to update this Privacy Policy from time to time. When we make changes, we will update the "Last Updated" date at the top of this policy. We encourage you to review this policy periodically to stay informed about how we are protecting your information.</p>

          <p><strong>Contact Us:</strong></p>
          <p>If you have any questions or concerns about this Privacy Policy or our privacy practices, please contact us at divinakarlangelo@gmail.com or kylemsison@gmail.com.

            By using our website, you signify your agreement to this Privacy Policy. If you do not agree with this policy, please do not use our website.

            PH Tax Calculator is committed to protecting your privacy, and we thank you for entrusting us with your information.</p>
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