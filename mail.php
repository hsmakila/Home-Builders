<?php
echo "A";

// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("hsmakila@gmail.com","My subject",$msg);
