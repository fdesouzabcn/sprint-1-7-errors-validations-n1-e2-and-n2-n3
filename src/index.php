<?php
declare(strict_types=1);
// Start the session
session_start();

// Start Store $_SESSION data 
$_SESSION['start_timestamp'] = date('Y-m-d H:i:s');
$_SESSION['filepath'] = __FILE__ ;
$_SESSION['filename'] = $_SERVER['PHP_SELF'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Newsletter Subscription</title>
    <style>
        /* Not necessary yet */
    </style>
</head>

<body> 
    <h2>Newsletter</h2>

    <form action="submissionsHandler.php" method="POST">
        <fieldset>
            <legend> Enter your details to sign up </legend>
            <label for="fname">First name:</label><br>
            <input 
                type="text" 
                id ="fname"
                name="fname" 
                placeholder="Enter your first name" 
                pattern="/^[A-Za-z .'-]+$/"
                title="Invalid input: The field Name is limited to letters. No spaces please"
            ><br>

            <label for="lname">Last name:</label><br>
            <input 
                type="text"
                id ="lname"
                name="lname" 
                placeholder="Enter your last name"
                pattern="/^[A-Za-z .'-]+$/"
                title="Invalid input: The field Name is limited to letters. No spaces please"
            ><br><br>

            <label for="email">Enter your email:</label><br>
            <input 
                type="email"
                id ="email"
                name="email" 
                pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                placeholder="user@example.com"  
            ><br><br> 
            <input type="submit" value="Submit">

        </fieldset> <!-- End of Fieldset -->
    </form> <!-- End of Form -->

</body>
</html>   
<?php 
?>