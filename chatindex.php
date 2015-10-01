<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Now Kapow Chat. Now Kapat.</title>
<link type="text/css" rel="stylesheet" href="chatstyle.css" /> //link to css stylesheet
</head>

<?
session_start(); //using cookie-based session to store data, must call this before output to browser

function loginForm(){ //name-choosing form
  echo'
  <div id="loginform">
  <form action="chatindex.php" method="post">
    <p>You gotta have a handle to continue:</p>
    <label for="name">Handle:</label>
    <input type="text" name="name" id="name" />
    <input type="submit" name="enter" id="enter" value="Enter" />
  </form>
  </div>
  ';
}

if(isset($_POST['enter'])){  //checks if user has input a name
  if($_POST['name'] != ""){ //stores input as $_SESSION['name']
    $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name'])); //converts special chars to HTML
  }
  else { //returns an error
    echo '<span class="error">No but seriously, pick a name.</span>';
  }
}
?>

<?php
if(!isset($_SESSION['name'])){
  loginForm();
  }
else {
?>

<div id="wrapper"> //layout structure - three blocks
  
  <div id="menu"> //Welcome block, exit link, div to clear the elements
    <p class="welcome">'Sup, <b><?php echo $_SESSION['name']; ?></b>?</p>
    <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
    <div style="clear:both"></div>
  </div>
   
  <div id="chatbox"><?php
    if(file_exists("chatlog.html") && filesize("chatlog.html") > 0){
      $handle = fopen("chatlog.html", "r");
      $contents = fread($handle, filesize("chatlog.html"));
      fclose($handle);
      
      echo $contents;
    }
  </div>
   
  <form name="message" action=""> //text input for message and submit button
    <input name="usermsg" type="text" id="usermsg" size="63" />
    <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
  </form>
   
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">

//jQuery Document
$(document).ready(function(){
$("exit").click(function(){ //confirmation of exit dialogue box
  var exit = confirm("Are you off, then?"
  if(exit==true){window.location = 'chatindex.php?logout=true';}
  });
});

$("#submitmsg").click(function(){
  var clientmsg = $("#usermsg").val();
    $.post("chatpost.php", {text: clientmsg});
    $("#usermsg").attr("value", "");
  return false;
});

function loadLog(){
setInterval (loadLog, 2500); //reloads the file every 2500ms
var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
$.ajax({
  url: "chatlog.html",
  cache: false, //preventing caching makes sure the chat log is updated every time a request is sent 
  success: function(html){
    $("#chatbox").html(html); //displays the chat log in the box
      var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
      if(newscrollHeight > oldscrollHeight){
      $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'
    }
  },
  });
}

</script>

<?php
if(isset($_GET['logout'])){
  $fp = fopen("chatlog.html", 'a');
  fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has passed the test, and gone into the West, and remained Galadriel. </i><br></div>");
  fclose($fp);
 
  session_destroy();
  header("Location: chatindex.php");
  }
?>

</body>
</html>