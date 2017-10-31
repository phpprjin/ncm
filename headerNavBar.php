<header class="main-header">
  <div class="nav">
    <div class="pull-left box"><a class="navbar-brand" href="#" >
        <img src="resources/img/ncmlogo.png"  height = "38px"  alt=" NCM Logo"/>
      </a>
    </div>
    <div class="pull-right box">
   
    <ul class="nav navbar-nav">
    
      <li class="dropdown messages-menu">
        <a >
         <b> Welcome </b><span class="hidden-xs"><?php echo $_SESSION['username'] ?></span>
        </a>
      </li>
      <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">                      
          <img src="resources/img/Help.png"  width="15" alt="Logo"/>
        </a>
      </li>

      <li class="dropdown messages-menu">
        <a href="login.php">                      
          <img src="resources/img/Logout.png"  width="15" alt="Logo"/>
        </a>
      </li>
    </ul>
  </div>
  </div> 
  <hr style="border-top:5px solid red;">
    <ol class="breadcrumb">
      <?php
        $home_page_url = get_landing_page();
      ?>
      <li class="active"><a href="<?php echo $home_page_url ; ?>">Home</a></li>
      
    </ol>
</header> 