 <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>devicesapp-Home Page</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="resources/css/bootstrap.min.css">
        <!-- Font Awesome -->
        
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Datetimepicker -->
        <link rel="stylesheet" href="resources/css/bootstrap-datetimepicker.min.css">
        <!-- Theme style -->
        
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        

        <link rel="stylesheet" href="resources/css/content.css">
		
		<link rel="stylesheet" href="resources/css/font-awesome.min.css">
		
		<!-- 09 Oct 17: Link to style.css -->
		<link href="resources/css/style.css" rel="stylesheet" type="text/css">
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  
  <script src="resources/js/devices.js?t=".<?php echo date('his'); ?>></script>
  <!-- jQuery 2.2.3 -->
   <script src="resources/js/jquery-2.2.3.min.js"></script>
   <!-- FastClick -->
   <script src="resources/js/fastclick.js"></script>
   <!-- AdminLTE App -->
   <script src="resources/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
   <script src="resources/js/demo.js"></script>
   <!-- DatePicker -->
   <script src="resources/js/moment.js"></script>
   <script src="resources/js/bootstrap-datetimepicker.min.js"></script>
   <script src="resources/js/global.js"></script>        
 
<!-- CSS for switchtechnicians file name: switchtechchkboxtempl.php ---> 
<style>
 
#switchlist {
 position: relative; float: left; width:240px; height: 150px; }
#deviceslist {
    position: relative; float: left; width: 140px; margin-left:200px;}
#mapstates {
    position: relative; float: left; width: 100px;margin-left:140px; background-color: azure; 
    }
#greatlakes {
  position: relative; float: left; width: 100px;margin-left:840px; background-color: azure; 
}
#northcentral {
  position: relative; float: left; width: 100px;margin-left:100px; background-color: azure; 
}
#southcentral {
  position: relative; float: left; width: 100px;margin-left:840px; background-color: azure; 
}
#northeast {
  position: relative; float: left; width: 100px;margin-left:100px; background-color: azure; 
}
#pacific {
  position: relative; float: left; width: 100px;margin-left:840px; background-color: azure; 
}
#southeast {
  position: relative; float: left; width: 100px;margin-left:100px; background-color: azure; 
}


/* Below for the reset_password.php file */

form {   
  /* Just to center the form on the page */
  margin: 0 auto;
  width: 400px;
  /* To see the outline of the form */
  padding: 1em;
  border: 1px solid #CCC;
  border-radius: 1em;
}

form div + div {
  margin-top: 1em;
}

label {
  /* To make sure that all labels have the same size and are properly aligned */
  display: inline-block;
  width: 150px;
  text-align: right;
}

input, textarea {
  /* To make sure that all text fields have the same font settings
     By default, textareas have a monospace font */
  font: 1em sans-serif;

  /* To give the same size to all text fields */
  width: 150px;
  box-sizing: border-box;

  /* To harmonize the look & feel of text field border */
  border: 1px solid #999;  
}

input:focus, textarea:focus {
  /* To give a little highlight on active elements */
  border-color: #000;
}

textarea {
  /* To properly align multiline text fields with their labels */
  vertical-align: top;

  /* To give enough room to type some text */
  height: 5em;
}

.button {
  /* To position the buttons to the same position of the text fields */
  padding-left: 90px; /* same size as the label elements */
}

button {
  /* This extra margin represent roughly the same space as the space
     between the labels and their text fields */
  margin-left: .5em;
}

</style>

</head> 