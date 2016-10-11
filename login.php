<!--
  Name: Troy Scott
  Date: September, 2016
  Email: troy_pdx@fastmail.fm
-->

<!DOCTYPE html>
<html>
<head>
  <title>Home | SweetTime!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
    .w3-navbar,h1,button {font-family: "Montserrat", sans-serif}
    .fa-tree,.fa-briefcase,.fa-file-text,.fa-coffee {font-size:200px}
    .button {
      background-color: #4CAF50; /* Green  */
      border-radius: 8px;
      border: none;
      color: white;
      padding: 5px 5px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin: 4px 4px;
      cursor: pointer;
    }
    .button1 {width: 250px;}
    .button2 {width: 50%;}
    .button3 {width: 100%;}
    </style>

</head>
<body>

  <!-- SweetTime! banner -->
  <div class="w3-container w3-light-grey w3-center w3-large">
      <h1 class="w3-margin w3-xlarge"><i class="fa fa-clock-o w3-text-blue"></i> SweetTime!</h1>
      <h2 class="w3-margin w3-large">Web-Based Time Tracking System</h2>
  </div>

  <!-- Content -->
  <div class="w3-container w3-dark-grey w3-padding-64">
    <div class="w3-content">

      <div class="w3-content w3-row">
        <div class="w3-third">
          <p class="w3-xlarge w3-text-light-blue">Hello!</p>
        </div>
        <div class="w3-twothird">
          <p>Welcome to SweetTime! a web-based time tracking system tailored for tax preparation firms. Please Log In using your registration credentials. Contact an administrator if you're unable to access the system.</p>
          <p>
          <form action="login_process.php" method="post">
            <table>
              <tr>
                <td colspan=2></td>
                <td>Email Address:</td>
                <td><input type="text" name="email"/></td>
                <td colspan=2></td>
              </tr>
              <tr>
                <td colspan=2></td>
                <td>Password:</td>
                <td><input type="password" name="password"/></td>
                <td colspan=2></td>
              </tr>
              <tr>
                <td colspan=3></td>
                <td><input class="button button3" type="submit" value="Log In" /></td>
                <td></td>
              </tr>
            </table>
          </form>
          </p>

        </div>
      </div>
    </div> <!-- end w3-content -->
  </div> <!-- end w3-container -->
</body>
</html>
