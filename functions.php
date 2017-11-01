<?php

function logToFile($filename, $msg) {  
   // open file 
   $fd = fopen($filename, "a"); 
   // append date/time to message 
   $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg;  
   // write string 
   fwrite($fd, $str . "\n"); 
   // close file 
   fclose($fd); 
} 

function get_user_info($username, $password) {

  global $db2;
  if (trim($username) !='' && trim($password) != '') {
      $password= md5($password);
      $sql = "SELECT * FROM users WHERE username='" .$username. "' AND password='" .$password. "'";
      $db2->query($sql);
      $rows = $db2->resultset();
      $result = $rows[0];

      return $result;
  }
  return false;

} 

function check_user_authentication($usertype) {
  global $db2;

  if ($_SESSION['userid']) {
    if ($_SESSION['userlevel']  == $usertype) {
      return true;
    }
    else {
      header('Location: access.php?msg=You are not authorized to access this page');
    }
  }
}

function get_landing_page() {

  if (!$_SESSION['userlevel']) {
    return 'login.php';
  }
  else { 
    if ($_SESSION['userlevel'] === "1") { // fieldsite technician 
      $location_href = "cellsitetech_devicelist.php";
    }
    if ($_SESSION['userlevel'] === "2") {
      $location_href = "switchtech_devicelist.php";
    }
    return $location_href;
  }

}
/*
* User Login check and user session creation
*/
function user_session_check() {
	global $db2;
  if (isset($_POST['username']) && $_POST['password']){


    $username = $_POST['username'];
    $password = $_POST['password'];

    if (trim($username) !='' && trim($password) != '') {
      $password= md5($password);
      $sql = "SELECT * FROM users WHERE username='" .$username. "' AND password='" .$password. "'";
      $db2->query($sql);
      $rows = $db2->resultset();
      $result = $rows[0];
  
      if ( ! $result ) {
        header("Location: login.php?msg=Username and Password is wrong");
        exit();
      }
      $userid = $_SESSION['userid'] = $result['id']; 
      $_SESSION['username'] = $username;
    }
    else { 
       header("Location: login.php");
       exit();
    }

  }
  else {

    if ( ! isset($_SESSION['userid'])) {
      
      header("Location: login.php?msg=User session expired");
      exit();
    }
  } 

}

function get_user_type(){
  global $db2;

  $db2->query("SELECT userlevel FROM users WHERE id=" . $_SESSION['userid']);
  $db2->query($sql);
      $rows = $db2->resultset();
      $result = $rows[0];
  return $result;
}
   
/*
* Checks for session live or not
*/
function is_live_session($sessid) {

    $db2 = new db2(); 
    //exit("SELECT COUNT(*) FROM sessions WHERE sessionid=" .$sessid );
    $db2->query( "SELECT COUNT(*) FROM sessions WHERE sessionid='" .$sessid ."'");
    $row = $db2->resultsetCols();
    $sess_record_count = $row[0];

    return $sess_record_count;
}

/*
* Nodes table for devices list
*/

function get_device_list_from_nodes($user_id) {

	global $db2, $pages; 
	$pages->paginate();
	if ($user_id > 0) {
		$sql_count = "SELECT COUNT(*) ";
		$sql_select = "SELECT n.id, n.custom_Location, n.deviceName, n.deviceIpAddr, n.model, v.vendorName, n.investigationstate, n.status, n.upsince, n.nodeVersion ";
				
		$sql_condition = " FROM userdevices ud
				 JOIN nodes n on ud.nodeid = n.id 
				 JOIN healthcheck hc ON hc.deviceid = n.id -- Need to be removed later
				 LEFT JOIN vendors v on v.id = n.vendorId
				 WHERE ud.userid = " . $user_id ;

		$sql_search_cond = '';
		if ( $_SESSION['search_term'] != ''){
			$search_term = $_SESSION['search_term'];

			$sql_search_cond = " AND ( n.deviceName LIKE '%" . $search_term . "%' ";			
			$sql_search_cond .= " OR n.deviceIpAddr LIKE '%" . $search_term . "%' ";				 	 
			$sql_search_cond .= " OR n.custom_Location LIKE '%" . $search_term . "%' ";		

/* Other fields temporarely excluded*/

// $status_val = (strtolower(trim($search_term))  == 'reachable') ? '1' : '0';
// $sql_search_cond .= " OR n.status = " . $status_val;

// $sql_search_cond .= " OR n.upsince LIKE '%" . $search_term . "%' ";		
// $sql_search_cond .= " OR n.nodeVersion LIKE '%" . $search_term . "%' ";		

			$sql_search_cond .= " OR n.investigationstate LIKE '%" . $search_term . "%' ";		
			$sql_search_cond .= " OR n.model LIKE '%" . $search_term . "%' ) ";
		}
	}  
	$count_sql = $sql_count . $sql_condition . $sql_search_cond;
	$db2->query($count_sql);
  $row = $db2->resultsetCols();
	$total_rec = $row[0];

	$sql = $sql_select . $sql_condition . $sql_search_cond;
	$sql .= $pages->limit;
	$db2->query($sql);
	
	$resultset['result'] = $db2->resultset();
	$resultset['total_rec'] = $total_rec;
	
	return $resultset;
}

/*
*  get device details for the current users
*/
function get_device_list($user_id, $usertype='ME') {

	$db2 = new db2();
	$pages = new Paginator;
	$pages->paginate();

	if ($user_id > 0) {

		$sql = "SELECT dd.* FROM currentusers cu 
				 JOIN devicedetails dd on cu.deviceId = dd.id 
				 WHERE cu.userid = " . $user_id . " AND cu.usertype='" . $usertype . "' ";
	}
	else {
		$sql = "SELECT dd.* FROM currentusers cu 
				 JOIN devicedetails dd on cu.deviceId = dd.id ";
	}	

	$count_sql = str_replace("dd.*", 'count(*)', $sql);
	
	$db2->query($count_sql);
	$row = $db2->resultsetCols();
	$total_rec = $row[0];
	//$pages->items_total = $count_result['total'];
	//$pages->mid_range = 7; // Number of pages to display. Must be odd and > 3

	$sql .= $pages->limit;

	// exit($sql);
	$db2->query($sql);
	// print_R($sql);
	
	$resultset['result'] = $db2->resultset();
	$resultset['total_rec'] = $total_rec;
	
	return $resultset;
}

/* 
 *	Updates the device_details table and
 *  current_users table
*/
function update_devicedetails($userid, $usertype, $device_details){

	$db2 = new db2();

	//Swich Tech API and Field Tech API calls are handled here
	//for device_details information
	foreach ($device_details as $key => $device) {
		 
            $devicename = $device['name'];
            $ipaddress  = $device['ipaddress'];
            $vendor	= $device['vendor'];
            $prompt = $device['prompt']; 
            $username = $device['username'];
            $password = $device['password']; 
            $port = $device['port'];
            $access_type = $device['access_type']; 		

		$sql = "INSERT INTO `devicedetails` (`name`, `ipaddress`, `vendor`, `prompt`, `username`, `password`, `port`, 
				`access_type`) VALUES
				('$devicename', '$ipaddress', '$vendor', '$prompt', '$username', '$password', '$port', '$access_type')";

		$db2->query($sql);
		$db2->execute();
		$lastInsertId  = $db2->lastInsertId(); 

		$sql = "INSERT INTO currentusers (userId, deviceId, userType)
				VALUES ('$userid', $lastInsertId, '$usertype' )";		

		$db2->query($sql);
		$db2->execute();
	} 
}

/*
* Updates the sessions table
*
*/
function update_sessions($userid, $usertype, $sessionid) {

		$db2   = new db2();

		$sql = "SELECT * FROM sessions WHERE sessionId = '".$sessionid."'";
		$db2->query($sql);
		$recordset = $db2->resultset();

		if (!$recordset) {
			$sql = "INSERT INTO `sessions` (`userId`, `userType`, `sessionId`, `initLogged`, `LastLogged`) VALUES
					('$userid', '$usertype', '$sessionid', now(), now() )";
			$db2->query($sql);
			$db2->execute();
		}
		else {

			$sql = "UPDATE `sessions` SET lastLogged = now() WHERE sessionId = '".$sessionid."'"; 
			// exit ($sql);
			$db2->query($sql);
			$db2->execute();		
		}
}

/*
* Deletes users from sessions table where users are idle for last 20 mins or more
*
*/
function delete_idleuser() {

	$db2 = new db2();

	$sql = "select * from sessions T where TIMESTAMPDIFF(MINUTE,T.initLogged,T.lastLogged) > " . CRON_TIME_INTERVAL;

	$db2->query($sql);
	$recset = $db2->resultset();
	$deleted_users = array();
	foreach ($recset as $key => $value) {

		$userid =  $value['userId'];

		$sql = "DELETE FROM currentusers WHERE userId=$userid ";
		$db2->query($sql);
		$db2->execute();

		$sql = "DELETE FROM sessions WHERE userId=$userid ";
		$db2->query($sql);
		$db2->execute();
		
		$deleted_users[] = $userid;
		
	}
	return $deleted_users;

}



/*
* Deletes users from sessions table where users are idle for last 20 mins or more
*
*/
function delete_alluser() {

	$db2 = new db2();

	$sql = "select * from sessions T where TIMESTAMPDIFF(MINUTE,T.initLogged,T.lastLogged) > " . CRON_TIME_INTERVAL;
	$sql = "DELETE FROM sessions";
	$db2->query($sql);
	$db2->execute();

	$sql = "DELETE FROM currentusers";
	$db2->query($sql);
	$db2->execute();

	$sql = "DELETE FROM devicedetails";
	$db2->query($sql);
	$db2->execute();

}


/*
* Api call
*/

function sendPostData ($url, $post) { 
// print_r($data_string);
	  $ch = curl_init($url);
	  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
	  curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);    
	  $result = curl_exec($ch);
	  curl_close($ch);  
	  return $result;
};

function getDetailViewData($userid, $deviceid) {
	$db2 = new db2(); 
	$sql_select = "SELECT hk.deviceid, hk.cpuutilization, hk.freememory, hk.buffers, hk.iosversion, hk.bootstatement, hk.configregister, hk.environmental, hk.platform, hk.bfdsession, hk.interfacestates, hk.interfacecounters, hk.mplsinterfaces, hk.mplsneighbors, hk.bgpvfourneighbors, hk.bgpvsixneighbors, hk.bgpvfourroutes, hk.bgpvsixroutes, hk.twothsndbyteping, hk.fivethsndbyteping, hk.logentries, hk.xconnect, hk.lightlevel, hk.userid ";
	$sql_condition = " 
	FROM 
	healthcheck hk 
	JOIN nodes n on n.id = hk.deviceid
	JOIN userdevices ud on ud.nodeid = hk.deviceid AND ud.userid = hk.userid
	WHERE hk.userid = $userid and hk.deviceid = ". $deviceid; 

	$sql = $sql_select . $sql_condition;

//echo  $sql;

	logToFile(my.log, $sql);
	$db2->query($sql);
	 //print_R($sql);
		$resultset['result'] = $db2->resultset(); 
		logToFile(my.log, $resultset);
		return $resultset;	 
};

/*
* Function to get the Switches list of user
*/
function getSwitchDevicesList($userid){

  global $db2;

  $sql = "SELECT n.id, n.deviceName, n.custom_Location, n.city  FROM userdevices ud  
          JOIN nodes n ON n.id = ud.nodeid
          WHERE ud.userid = $userid AND n.city != ''
          ORDER BY ud.nodeid
          ";
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}


/*
* Functin to get the switch devices list by city wise for the user
*/
function getSwitchDevicesListByCity($userid, $city){

  global $db2, $pages;

  //$pages->paginate();
  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n.id, n.deviceName, n.custom_Location, n.city, n.subregion ";

  $sql_condition = " FROM userdevices ud  
                    JOIN nodes n ON n.id = ud.nodeid
                    WHERE ud.userid = $userid AND n.subregion = '$city' ";
  $sql_order = " ORDER BY ud.nodeid ";

  $count_sql = $sql_count . $sql_condition ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];

  $sql = $sql_select . $sql_condition . $sql_order;
  $sql .= $pages->limit; 
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}


/*
* Functin to get the switch devices list by market and subregion wise for the user
*/
function get_switchlist_for_market_subregion($userid, $market, $subregion){

  global $db2, $pages;
  $pages->paginate();
  
  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n.id, n.deviceName, n.custom_Location, n.city, n.market as 'subregion' ";

  $sql_join = " FROM userdevices ud  
                    JOIN nodes n ON n.id = ud.nodeid ";

                   // JOIN mst_market mm on mm.subregion = n.subregion ";

  $sql_where_condition = " WHERE ud.userid = $userid and n.switch_name !='' ";

  if ($market != '') {
    $sql_where_condition .= " AND n.market  = '$market' ";
  }
  if ($subregion != '') {
    $sql_where_condition .= " AND n.submarket = '$subregion' ";
  }

  $sql_order = " ORDER BY ud.nodeid ";

  $count_sql = $sql_count .  $sql_join . $sql_where_condition  ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];
  

  $sql = $sql_select . $sql_join . $sql_where_condition . $sql_order;
  $sql .= $pages->limit;  

// echo  $sql ;
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}



/*
*
*/
function getSWroutersDetails($deviceid, $userid) {
  global $db2;

  $sql_select = " SELECT n2.id,n2.deviceName,n2.deviceIpAddr, n2.custom_Location, n2.connPort, n2.model, n2.systemname ";
  $sql_condition = " FROM nodes n
                    JOIN userdevices ud ON ud.nodeid = n.id
                    JOIN connectingdevices cd ON cd.swname = n.switch_name
                    JOIN nodes n2 ON cd.swrtrconnodeid = n2.id  
                    WHERE n.id = $deviceid AND ud.userid = $userid  ";

  $sql = $sql_select . $sql_condition;
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;

}

/*
* Function to get the Switch Technician city list
*/
function getSEuserCityList($userid)  {

  global $db2;

  $sql = "SELECT  n.city  FROM userdevices ud  
          JOIN nodes n ON n.id = ud.nodeid
          WHERE ud.userid = $userid AND n.city != ''
          group BY n.city 
          ORDER BY n.city ";
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}



function usrfavritelist_display($userid){
  $db2 = new db2(); 
  $sql_select = "SELECT id, listid, listname";
  $sql_condition = " 
  FROM 
  userdevices
  WHERE userid = $userid  and listid <> 0 
  group by listid" ;
  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
  // echo $sql;
  $resultset['result'] = $db2->resultset(); 
  // print'<pre>';
  // print_r($resultset['result']);
  return $resultset;   
}

function insert_my_device_record($data){
  // echo "inside the function";
   $db2 = new db2();
   $listid = $data['listid'];
   $userid =$data['userid']; 
   $nodeid = $data['deviceid'];
  

    $sql = "SELECT  listname FROM userdevices WHERE listid = $listid group by listname ";
    //print $sql;
    $db2->query($sql);
    $recordset = $db2->resultset();  
    //print_r($recordset);    
    $listname = $recordset[0]['listname'];
    
     $sql = "INSERT INTO userdevices (nodeid, userid, listid, listname) 
           VALUES($nodeid,$userid,$listid,'$listname')";
// echo $sql;
     $db2->query($sql);
     $result =$db2->execute();
    
   return $result;

}

function insert_usrfavritedev($data){
  // echo "inside the function";
   $db2 = new db2();
   $lname = $data['listname'];
   $userid =$data['userid']; 
   $nodes = array($data['deviceid']);
  

    $sql = "SELECT  max(listid) + 1  as listidmaxval FROM userdevices WHERE listid <> 0 ";
    $db2->query($sql);
    $recordset = $db2->resultset();      
    $listid = $recordset[0]['listidmaxval']+1;
    
     $sql = "INSERT INTO userdevices (id, nodeid, userid, listid, listname) 
           VALUES('','$nodes[$i]','$userid','$listid','$lname')";

     $_SESSION['mylistname'] = $lname;
     $_SESSION['switchlistid'] = $listid;
     $db2->query($sql);
     $result =$db2->execute();
    
   return $result;

}

function usrfavritecondev_display($userid,$listid){
  $db2 = new db2(); 
  $sql_select = " SELECT ud.id, ud.listid, ud.listname, ud.nodeid, n.deviceName ";
  $sql_condition = " 
  FROM 
  userdevices ud
  LEFT JOIN nodes n on ud.nodeid = n.id
  WHERE ud.listid = $listid and ud.userid = $userid and ud.listid <> 0 "; 
  $sql = $sql_select . $sql_condition;
 // echo "$sql";
  $db2->query($sql);
  

  $resultset['result'] = $db2->resultset(); 
  $resultset['mylistname'] = $resultset['result'][0]['listname'];
  if ($resultset['result'][0]['nodeid'] == '0' ){ 
    unset($resultset['result'][0]);
  }
 // print_r($resultset);
  return $resultset;   
}


function user_mylist_devieslist($userid,$listid){ 

  
  global $db2, $pages; 
  $pages->paginate();
  if ($userid > 0) {
    $sql_count = "SELECT COUNT(*) ";
    $sql_select = "SELECT n.id, n.custom_Location, n.deviceName, n.deviceIpAddr, n.model, v.vendorName, n.investigationstate, n.status, n.upsince, n.nodeVersion, ud.listname ";
        
    $sql_condition = " FROM userdevices ud
         JOIN nodes n on ud.nodeid = n.id 
         -- JOIN healthcheck hc ON hc.deviceid = n.id  
         LEFT JOIN vendors v on v.id = n.vendorId
         WHERE ud.userid = " . $userid ." and ud.listid = " . $listid ;
 
     
  }  
  $count_sql = $sql_count . $sql_condition; 
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  $total_rec = $row[0];

  $sql = $sql_select . $sql_condition;
  $sql .= $pages->limit;
  $db2->query($sql);
  
  $resultset['result'] = $db2->resultset();
  $resultset['total_rec'] = $total_rec;
  // print_r($resultset);
  return $resultset;
}


function usrfavritelistdel ($userid,$switchlistid){
  $db2 = new db2(); 
  $sql = "delete from userdevices where userid = $userid and listid = $switchlistid";
  //echo $sql;
  $db2->query($sql);
  $db2->execute();
  //return $resultset;   
  return;
}


function usrfavritelistswdel($userid,$switchlistid,$switchid){
  $db2 = new db2(); 
  $sql = "delete from userdevices where listid = $switchlistid and nodeid = $switchid and userid = $userid";
  $db2->query($sql);
  $db2->execute();
  //echo $sql;
  //return $resultset;   
  return;
}

function get_market_subregion_list($market_name) {
  global $db2;
  $sql_select = "SELECT submarket as subregion ";
  $sql_condition = " FROM 
                     nodes
                     WHERE market = '$market_name'
                     group by subregion
                     order by submarket ";
  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}
 
 
 
function  userexist($emailid) { 
    $db2 = new db2(); 
    $sql = "SELECT COUNT(*) FROM users WHERE email ='" .$emailid."'";
    $db2->query($sql);
    $row = $db2->resultsetCols();
    $resultset['result'] = $db2->resultset();
   // echo "Result from user table".$sql;
   // print_r($row); 
   // echo '<br>';
   return $row;
} 

function sendmail($mailbody,$pwrurl) {
  $mail = new PHPMailer();
  $mail->IsSMTP(); // send via SMTP
  $mail->SMTPAuth = true; // turn on SMTP authentication
  $mail->Username = "ncmdministrator@gmail.com"; // SMTP username
  $mail->Password = "ncmdministratorpassword"; // SMTP password
  $webmaster_email = "ncmadministrator@gmail.com"; //Reply to this email ID
  $email="enduser@gmail.com"; // Recipients email ID
  $name="enduser"; // Recipient's name
  $mail->From = $webmaster_email;
  $mail->FromName = "NCM Administrator";
  $mail->AddAddress($email,$name);
  $mail->AddReplyTo($webmaster_email,"NCM administrator@gmail.com");
  $mail->WordWrap = 50; // set word wrap
  //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
  //$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
  $mail->IsHTML(true); // send as HTML
  $mail->Subject = "NCM Password Reset";
  //$mail->Body = "Hi,
  //This is the HTML BODY "; //HTML Body
  $mail->Body = file_get_contents('emailcontent.php').$mailbody.$pwrurl;
  $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
  if(!$mail->Send())
  {
  echo "Mailer Error: " . $mail->ErrorInfo;
  }
  else
  {
  //echo "Message has been sent";
  }
  //echo "<br>"."sendmail completed";
}

function updateuserpassword($emailid,$password) {
   // Update the user's password
    $db2   = new db2();
    $sql = "SELECT * FROM users WHERE email = '".$emailid."'";
    $db2->query($sql);
    $recordset = $db2->resultset();      
    if (!$recordset) {
      echo "Username not found in our records.";    
    }  else {          
        $sql = "UPDATE `users` SET password = '".$password."' WHERE email = '".$emailid."'"; 
        $db2->query($sql);
        $db2->execute();   
        return true;
    };      
}
function get_market_list() {
  global $db2;

  $sql_select = "SELECT market as market_name ";
  $sql_condition = " FROM nodes
                      where market != ''
                      GROUP BY market "; 
  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
  // echo $sql;
  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}