<?php
include 'classes/db2.class.php';
include 'functions.php';

if (isset($_POST['username']) && $_POST['password']) {
   $username = $_POST['username'];
   $password = $_POST['password'];

   $userinfo = get_user_info($username, $password);
//exit(print_r( $userinfo));
   if ( ! $userinfo ) {
      $message['error'] = 'Username or Password is incorrect ';
   }
   else {
      $_SESSION['userid'] = $userinfo['id'];
      $_SESSION['username'] = $userinfo['username'];
      $_SESSION['userlevel'] = $userinfo['userlevel'];
   }
   
    if (isset($_SESSION['userlevel']) && $_SESSION['userlevel']) {
      $location_href = get_landing_page(); 
// exit($location_href);
      header('Location:' . $location_href );
      exit;
    }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- 12 Oct 17: Completely changed head section -->
          <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login Page</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 and CSS -->
        <link rel="stylesheet" href="resources/css/bootstrap.min.css">
        <link rel="stylesheet" href="resources/css/content.css">
    <link href="resources/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="resources/js/style.js"></script>    
    <script type="text/javascript">

// HTML Popup Model

$(document).ready(function(){
  $(".launch-modal").click(function(){
    // Id myModal is used here to load the response content
    $("#myModal").modal({
      remote: "passwdmdl.php"      
    });
    $('#emailid').val('');
    $('.statusMsg').html('<span></span>');
  });  
}); 
 
 $(document).on('hide.bs.modal','#myModal', function () {
    var url = "http://localhost/ncm/login.php";
    $(location).attr('href',url);   
})
 
//Popup form button click event
$(document).on("click","#savebutton",groupFile);

 function groupFile(){ 
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var usremailid = $("#emailid").val();
    $('#emailid').show();  
    $('#emailidlbl').show();  
    if(usremailid.trim() == '' ){
        $('.statusMsg').html('<span style="color:green;">Please enter your email.</span>');    
        $('#emailid').focus();
        return false;
    }else if(usremailid.trim() != '' && !reg.test(usremailid)){
        $('.statusMsg').html('<span style="color:green;">Please enter a valid email.</span>');    
        $('#emailid').focus();
        return false;
    };
     $.ajax({
            type:'POST',
            url:'changepassword.php',
            data:'usremailid='+usremailid,
            beforeSend: function () {
                $('.savebutton').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success:function(msg){
                if(msg == 'ok'){                    
                    $('#emailid').hide();  
                    $('#emailidlbl').hide();  
                    $('.statusMsg').html('<span style="color:green;">Please do check your registered email for further instructions.</p>');    
                 };                
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
            }
    }); 
    } 
</script>   
  </head> 
  <body>
    
    <!-- POPUP model bootrstap modle  -->  
    <!-- Links -->    
     <!--
     <a href ="#" class=" launch-modal" >Launch Demo Modal </a>
     -->
     <div id="div1"></div> 
    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Content will be loaded here from "remote.php" file -->
            </div>
        </div>
    </div> 
    
    <!-- 12 Oct 17: Added class login-page and NCM logo -->
    <div class="login-page">
      <p class="logo"><a class="one"></a><a class="ems">NCM</a></p>
      
    <?php

    //Destroy All sessions
    $_SESSION = array();

    if (isset($message['error'])) {
      ?>
    
    <p class="warning"><?php echo $message['error']; ?></p>
    <?php }
    ?>
    
    <div class="form">
      <form class="login-form" action="login.php" method="post">
    
        <p class="box-title"> Username </p>
        <input name="username" type="text" />
        <p class="input-error" id="username"></p>
      
        <p class="box-title"> Password </p>
        <input name="password" type="password" />
        <p class="input-error" id="password"></p>
                             
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        <!--
        
        <a href ="#" class=" launch-modal" ><p class="message">Forgot your password?</p> </a>
-->       <a href="#"><p class="message">Forgot your password?</p></a>

      
      </form>
    </div>
    </div> 
  </body>
</html>
