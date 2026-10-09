<?php

//check to see if the form was submitted//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //gets the name the user entered//
    $name = $_POST["name"];
    //gets the age the user entered//
    $age = $_POST["age"];

    //displays greeting with name and age//
    echo "Hello, $name! You are $age years old.";
} else {
?>

<form method="post">
    <!--label for name input box -->
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br><br>

    <!--label for age input box -->
    <label for="age">Age:</label>
    <input type="text" name="age" id="age" required>
    <br><br>
    
<!--creates button to submit form -->
    <input type="submit" value="Submit">
</form>

<?php
}
?>