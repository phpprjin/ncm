  <?php
  error_reporting(1);
  include ("classes/db2.class.php");
  include "classes/paginator.class.php";  
  include ("functions.php");

  user_session_check();
  check_user_authentication('2'); //switch tech type user

  $page_title = "Switchtech users list";
  $city_name = '';
  $marketname = '';

  if (isset($_SESSION['city_name'])) {
     $city_name = $_SESSION['city_name'];
  }  
  if (isset($_SESSION['marketname'])) {
    $marketname = $_SESSION['marketname'];
  } 

  if (isset($_GET['markets'])) { 
      $marketname =  $_SESSION['marketname'] = $_GET['markets']; 
  }

  if (isset($_GET['city_name'])) { 
      $city_name = $_SESSION['city_name'] = $_GET['city_name']; 
  }


  
  $userid = $_SESSION['userid'];
  $succss_msg  = '';

  if (isset($_POST['addlist']) && $_POST['addlist'] ) {
    $_SESSION['succss_msg'] = '';

    if ($_SESSION['mylistname'] != $_POST['addlist']){
      $data=array('listname'=>$_POST['addlist'],'userid'=>$userid);
      $result = insert_usrfavritedev($data);
    }

    if ($result) { $succss_msg =  "Switch list added successfully."; }
  }

  if (isset($_GET['action']) && $_GET['action'] == 'editmylist') {
    $switchlistid = $_SESSION['switchlistid'] = $_GET['switchlistid'];

  }
  // $user_city_list = getSEuserCityList($_SESSION['userid']);
  ?>
  <!DOCTYPE html>
  <html>
     <?php include("includes.php");  ?>
      <body class="hold-transition skin-blue sidebar-mini ownfont">
        <div class="content">
          <?php include ('menu.php'); ?>        
          <div class="col-md-6 panel-info" style="height:500px">
            <div class="panel-heading">My List</div>
              <div class="panel-body">
                <div id="switchlist" class="col-md-6">
                  <div>
                    <form id="usrmyfavlstfrm" name="usrmyfavlstfrm" action="switchtech_devicelist.php" method = "POST"                  class="navbar-form search">
                      <div class="input-group add-on">
                        <input name="addlist" id="addlist" class="form-control search-details" placeholder="Create New List"  type="text">
                        <div class="input-group-btn">
                          <button class="btn btn-default search-details"  type ="submit" name="addlistbtn" name="addlistbtn"  value="Submit">Submit</button>
                        </div>                                       
                      </div>
                    </form>
                    <?php 
                    if ($succss_msg != '') {  
                    ?>
                      <div class="text-success"><?php echo $succss_msg ?></div>
                    <?php
                    }
                    ?>
                  </div> 
                 <div style="border:1px solid darkgray;"> 
                    <div class="panel-warning"   id="delete_mylists">
                      <div class="panel-heading">
                        My Device List  
                        <div id="myswitchlist_delete" type="button" class="droppable pull-right box box-danger">
                          <i class="fa fa-trash"></i>&nbsp; Delete 
                        </div>
                      </div>
                    </div> 
                    <table id="<?php echo $device['id'] ?>" class="table table-border">
                      <thead>
                        <tr>
                          <th>List Name</th>
                          <th>Edit</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody> 
                  <?php  
                      $userid =  $_SESSION['userid'];
                      $myswitchlist = usrfavritelist_display($userid);                       
                      foreach($myswitchlist['result'] as $key=>$value) { 
                      ?> 
                        <tr class="del_<?php echo $value['listid'];?>">                            
                          <td>
                            <i data-listid="<?php echo $value['listid'] ?>" data-listname=" <?php echo $value['listname']; ?>" class="draggable fa fa-arrows"></i>&nbsp;
                          <?php echo $value['listname']; ?></td>
                          <td><a href="switchtech_devicelist.php?action=editmylist&switchlistid=<?php echo $value['listid'];?>"><i class="fa fa-edit"></i></a></td>
                          <!--
                           <td><i class="fa fa-edit" onclick="switchlist(<?php echo $userid;?>,<?php echo $value['listid'];?>);"></i></td>
                           <td><i class="fa fa-trash" onclick="switchlistdel(<?php echo $userid;?>,<?php echo $value['listid'];?>);" width="22" height="22"></i></td> -->
                          <td><a href="mylist_devices.php?userid=<?php echo $userid;?>&listid=<?php echo $value['listid'];?>"><i class="fa fa-eye" width="22" height="22"></i></a></td>
                        </tr>
                  <?php  
                      } 
                      ?> 
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php 
                if (isset( $_SESSION['switchlistid'] )) {
                  $switchlist = usrfavritecondev_display($userid,$_SESSION['switchlistid']);
                ?>
                <div class="col-md-6">
                  <div class="panel-warning" style="border:1px solid gray">
                    <div class="panel-heading"><b> View devices List : <span id="my_device_list_name"> <?php echo $switchlist['mylistname'] ?></span> </b>
                        <div id="mylist_delete"   style="" class="droppable pull-right box box-danger"><i class="fa fa-trash"></i>&nbsp; Delete 
                        </div> 
                    </div>
                    
                      <div id="deviceslist" class="panel-body <?php echo ($_SESSION['switchlistid']!='') ? 'droppable' :'' ?>" >
                        <input type="hidden" name="hidd_mylistid" id="hidd_mylistid" value="<?php echo  $_SESSION['switchlistid']; ?>">
                        <table class="table" <?php echo ($_SESSION['switchlistid']!='') ? 'data-mylistid="'.$_SESSION['switchlistid'] .'"':'' ?> id="mydevicestbl" >                 
                          <thead>
                            <tr><th> Device Id </th><th>Device Name</th></tr> 
                          </thead>      
                          <tbody>
                           <?php                              
                              foreach ($switchlist['result'] as $key => $listitem) {
                                ?>
                                <tr class='<?php echo "del_" . $listitem['nodeid']; echo " swtlistid_".$_SESSION['switchlistid']; ?>'>
                                  <td align='left'>
                                  <i data-listid="<?php echo $_SESSION['switchlistid']; ?>" data-deviceid="<?php echo  $listitem['nodeid'] ?>" data-devicename="<?php echo $listitem['deviceName'] ?>" class='fa fa-arrows draggable'></i>&nbsp;<?php echo $listitem['nodeid'] ?></td>
                                  <td align='left'><?php echo $listitem['deviceName'] ?></td>
                                </tr>
                                <?php
                              }
                           ?>
                          </tbody>
                        </table> 
                      </div>
                      
                  </div>
                </div>
                <?php
                }
                ?>
            </div>
          </div> 
          <div style="position:relative; background-color: red">
          <div id="map_section" style="<?php echo (isset($_SESSION['city_name'])) ?  "display: none" :"display: block"; ?>" class="col-md-6 panel-primary pull-right">
             <div id="mapstates" > 

<img src="resources/img/Map.png" alt="US Map" usemap="#Map" width="500" height="316">

<map name="Map" id="Map">
    
    <area target="" alt="" title="" href="#" class="map_region" data-market="Pacific Northwe" coords="199,37,300,135" shape="rect">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Houston/Gulf co" coords="302,59,335,151" shape="rect">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Great Plains" coords="332,178,207,136" shape="rect">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Northern Califo" coords="334,58,370,115" shape="rect">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Southern Califo" coords="358,173,333,117" shape="rect">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Mountain" coords="358,150,379,172" shape="rect">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Tristate" coords="360,116,403,106,412,117,409,130,406,140,400,145,394,147,388,152,390,161,383,156,373,148,361,148,357,141" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Washington/Balt" coords="396,103,400,93,419,77,427,67,438,65,442,76,445,94,445,103,425,109,410,110" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="New England" coords="441,64,463,31,474,29,487,51,478,61,474,68,468,73,467,88,473,93,461,102,448,107" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Illinois/Wiscon" coords="410,111,431,105,455,105,444,115,446,123,442,132,425,128,412,130" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Carolinas/Tenes" coords="335,173,380,173,431,163,440,161,442,172,434,184,426,192,420,198,412,209,405,218,376,192,351,194,334,192,334,192" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Kansas/Missouri" coords="383,159,412,130,429,129,444,138,442,158,410,166,381,170" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="South West" coords="334,196,376,194,404,220,400,233,370,237,353,235,345,224,334,226" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Florida" coords="353,236,400,235,421,271,420,293,407,285,395,271,392,256,380,246,366,250,355,243" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="New York Metro" coords="54,15,69,15,116,26,123,54,120,69,101,67,94,98,32,84,32,78" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="OPW" coords="33,84,115,106,111,120,109,132,103,157,89,154,95,144,95,132,81,132,69,132,75,140,95,179,95,203,69,199,41,173,31,120,26,103" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Michigan/Indian" coords="116,25,200,38,196,125,200,134,211,140,208,171,151,167,151,153,110,141,116,104,94,96,101,66,123,70,123,52,116,39" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Tri-state" coords="194,225,201,173,152,167,149,152,121,146,110,141,105,159,94,160,94,147,89,135,72,134,79,150,83,160,95,179,99,188,95,195,91,207,104,215,122,227,146,229" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Central Texas" coords="249,295,249,275,281,255,297,256,328,259,335,243,354,242,347,227,337,227,331,220,307,215,283,219,272,207,261,209,241,206,227,201,226,181,202,179,196,224,169,229,176,239,183,254,196,260,205,250,220,267,225,276,231,289,238,295,243,297" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="Georgia/Alabama" coords="334,220,333,177,275,179,227,178,228,202,251,208,271,208,286,219,308,215,322,216" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="R1M3" coords="55,234,78,228,98,237,99,267,100,279,112,284,129,300,123,303,114,297,93,282,82,281,73,282,74,291,61,296,31,300,44,283,59,285,46,269,38,251,51,246" shape="poly">
    <area target="" alt="" title="" href="#" class="map_region" data-market="R1M4" coords="132,259,169,267,204,294,191,308,159,288,144,277,131,274" shape="poly">
</map>          

              </div>
          </div>

          <div class="col-md-6 panel-primary pull-right">
            <div class="panel-heading">
            <input type="hidden" name="marketname" id="marketname" value="<?php echo $city_name?>">
            <form id="city_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
              <?php
              $str_marketname = str_replace(array('R' , 'M' ),array('Regn','-Market' ), $marketname );
              ?>
              <span>Devices List : <span id="market-region"><?php echo $str_marketname . ( ($city_name != '') ? " [" . $city_name . ']': '' ); ?></span></span>            
                <span class="pull-right">

                  <span style="cursor: pointer;" onclick="showMap()"> Show Map&nbsp;  <i class="fa fa-map-o" title="Show Map" ></i>&nbsp;</span>
                  
                  <select id="markets"  class="market_name_list" style="color:darkblue" name="markets">
                    <option value=''>Select Region-Market </option>
                    <?php
                    //if (isset($_SESSION['marketname'])) {
                       
                      $market_list = get_market_list(); 
                      if ( $market_list['result'] ) {
                        foreach ($market_list['result'] as $key => $value) {
                          $seleced = ($marketname == $value['market_name']) ? "selected" : "";
                          $str_marketname = str_replace(array('R' , 'M' ),array('Regn','-Market' ), $value['market_name'] );
                          echo "<option " . $seleced . " value='" . $value['market_name'] . "'>" . $str_marketname ."</option>";
                        }
                      }
                    //}
                    ?>
                  </select>  
                   
                   <select id="subregions" name="city_name" class="city_name_list" style="color:darkblue" name="subregions">
                    <option value=''>Select subregion</option>
                    <?php
                    if (isset($_SESSION['marketname'])) {
                       
                      $sub_region_list = get_market_subregion_list( $_SESSION['marketname'] ); 
                      if ( $sub_region_list['result'] ) {
                        foreach ($sub_region_list['result'] as $key => $value) {
                          $seleced = (  $_SESSION['city_name'] == $value['subregion']) ? "selected":"";
                          echo "<option " . $seleced . " value='" . $value['subregion'] . "'>" . $value['subregion'] . "</option>";
                        }
                      }
                    }
                    ?>
                  </select>                                 
                  </span>
              </form>            
            </div>
            <div id="container_mycityswitches" class="panel-body">
               <?php include ("switchTypeDevicesByCity.inc.php"); ?>
            </div>
          </div> 
          </div>
        </div>
        <div id="mycmdModal" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <!-- Content will be loaded here from "remote.php" file -->
              </div>
          </div>
        </div>
    <input type="hidden" id="hidd_userid" value="<?php echo $_SESSION['userid'] ?>">
        <?php include ('footer.php'); ?>  
        <script src="resources/js/mydashboardlist.js?t=<?php echo date('his'); ?>"></script>
      </body>
  </html>     