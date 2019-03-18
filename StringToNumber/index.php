<?php
//To convert string s into a number, we will use the ord() function for every character in the string, and add the result into an integer (y). Next, we will use the function floor(abs(sin(y*2))*100) to convert it into a number between 0 and 100. Finally, we will display it.

//Check if input was given, if it was not, kill the script
if(!isset($_GET['in'])){
    die();
}

//Set the input to a variable
$in = $_GET['in'];

//Convert the input to a number (step 1)

$y = 0;
for($i = 0; $i <= strlen($in); $i++){
    y+=ord(substr($in, $i, 1));
}

//Convert the input to a number (step 2)
$y = floor(abs(sin(y*2))*100)
    
//Lastly, we'll display it
echo $y;