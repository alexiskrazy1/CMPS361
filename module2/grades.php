<?php

//logs the sudents current grade//
$grade = 78;

//puts out a message based on the users grade//
if ($grade >= 90) {
    echo "Your grade is A";
} elseif ($grade >= 80) {
    echo "Your grade is B";
} elseif ($grade >= 70) {
    echo "Your grade is C";
} else {
    echo "Your grade is Fail";
}

?>