<?php 
        $command  = $_GET['commandname'];
        $deviceid = $_GET['deviceid'];
                                
				switch($command) {
				    
				    case 'alarmoutstanding':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/22';

					break;
				    case 'cardhardware':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/8';
					break;
				    case 'cardinformation':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/9';
					break;             
				    case 'cardtable':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/15';
					break;
				    case 'clock':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/1';
					break;
				    case 'context':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/6';
					break;
				    case 'crashlist':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/17';
					break;
				    case 'diameterpeers':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/16';
					break;
				    case 'hdraid':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/5';
					break;
				    case 'licenceinfo':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/12';
					break;
 				    case 'rctstatus':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/18';
					break;
 				    case 'showresource':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/11';
					break;
 				    case 'services':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/7';
					break;
 				    case 'sessionrecoverystatus':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/10';
					break; 
					case 'srpcheckpoint':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/13';
					break; 
				    case 'srpinfo':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/14';
					break;
			            case 'srpinfochasstate':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/4';
					break;
			            case 'systemuptime':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/2';
					break;
			           case 'taskresource':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/21';
					break;
          			   case 'diamproxy':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/19';
					break;
			          case 'taskressessmsg':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/20';
					break;
			          case 'showversionimageversion':
					$url='http://63.49.0.192:8080/healthcheck/xos/'.$deviceid.'/3';
					break;
				    default: 
					break;
				}   
                  /*    Ends  */    
        ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 style="font-size:12px;font-family:arial;text-align:center;" class="modal-title">Device Console Output  - Command Issued - <?php echo $_GET['commandname'];?> </h4>
    
</div>

<div class="modal-body">    
<?php
	      if (isset($url)) {
		       if (!$data = @file_get_contents($url)) {
             $error = error_get_last(); 
             $data = "HTTP request failed. Error was: " . $error['message'];
           } 
        } else 
            $data = "CLI command needs is in progress.";
          
     echo "<span style='font-family:courier;font-size:12px;font-weight:500;'> $data</span>";
?>  
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    
</div>
