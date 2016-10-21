<!--
  Name: Troy Scott
  Date: October, 2016
  Email: troy_pdx@fastmail.fm
-->

<!DOCTYPE html>
<html>
<head>
  <title>Login | SweetTime!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="sweettime.css" />
</head>
<body>

  <!-- GitHub Fork Me banner -->
  <a href="https://github.com/troypdx/sweettime"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>

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
                <td><input class="w3-btn w3-green w3-round" type="submit" value="Log In" /></td>
                <td></td>
              </tr>
            </table>
          </form>

          <p>This demonstration version of SweetTime! provides two sample user profiles:</p>
          <lu>
             <li>Employee Sample - Email Address: employee@gmail.com, Password: employee</li>
             <li>Administrator Sample - Email Address: administrator@gmail.com, Password: administrator</li>
          </lu>

        </div>
      </div>
    </div> <!-- end w3-content -->
  </div> <!-- end w3-container -->
</body>
</html>
