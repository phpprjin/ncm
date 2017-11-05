<?php 
        $command  = $_GET['commandname'];
				switch($command) {
				    
				    case 'alarmoutstanding':
					$url='http://localhost:8080/healthcheck/xos/2/22';

					break;
				    case 'cardhardware':
					$url='http://localhost:8080/healthcheck/xos/2/8';
					break;
				    case 'cardinformation':
					$url='http://localhost:8080/healthcheck/xos/2/9';
					break;             
				    case 'cardtable':
					$url='http://localhost:8080/healthcheck/xos/2/15';
					break;
				    case 'clock':
					$url='http://localhost:8080/healthcheck/xos/2/1';
					break;
				    case 'context':
					$url='http://localhost:8080/healthcheck/xos/2/6';
					break;
				    case 'crashlist':
					$url='http://localhost:8080/healthcheck/xos/2/17';
					break;
				    case 'diameterpeers':
					$url='http://localhost:8080/healthcheck/xos/2/16';
					break;
				    case 'hdraid':
					$url='http://localhost:8080/healthcheck/xos/2/5';
					break;
				    case 'licenceinfo':
					$url='http://localhost:8080/healthcheck/xos/2/12';
					break;
 				    case 'rctstatus':
					$url='http://localhost:8080/healthcheck/xos/2/18';
					break;
 				    case 'showresource':
					$url='http://localhost:8080/healthcheck/xos/2/11';
					break;
 				    case 'services':
					$url='http://localhost:8080/healthcheck/xos/2/7';
					break;
 				    case 'sessionrecoverystatus':
					$url='http://localhost:8080/healthcheck/xos/2/10';
					break; 
					case 'srpcheckpoint':
					$url='http://localhost:8080/healthcheck/xos/2/13';
					break; 
				    case 'srpinfo':
					$url='http://localhost:8080/healthcheck/xos/2/14';
					break;
			            case 'srpinfochasstate':
					$url='http://localhost:8080/healthcheck/xos/2/4';
					break;
			            case 'systemuptime':
					$url='http://localhost:8080/healthcheck/xos/2/2';
					break;
			           case 'taskresource':
					$url='http://localhost:8080/healthcheck/xos/2/21';
					break;
          			   case 'diamproxy':
					$url='http://localhost:8080/healthcheck/xos/2/19';
					break;
			          case 'taskressessmsg':
					$url='http://localhost:8080/healthcheck/xos/2/20';
					break;
			          case 'showversionimageversion':
					$url='http://localhost:8080/healthcheck/xos/2/3';
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
