<?
session_start();
if(isset($_SESSION['name'])){ //check that name exists
  $text = $_POST['text']; //grab the POST data and store it to the $text variable
  
  $fp = fopen("chatlog.html", 'a'); //open log.html to a - write only, file pointer goes to end of the file - if the file does not exist, attempt to create it
  fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>"); //write the message to the file, convert special characters to html again, contain the date and time
  fclose($fp); //close the file
  }
?>