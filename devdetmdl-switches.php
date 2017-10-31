<?php 
        $command  = $_GET['commandname'];
				switch($command) {
				    
				    case 'alarmoutstanding':
					$url='http://localhost:8080/healthcheck/ios/1';

					break;
				    case 'cardhardware':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
				    case 'cardinformation':
					$url='http://localhost:8080/healthcheck/asr5000/1';
					break;             
				    case 'cardtable':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
				    case 'clock':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
				    case 'context':
					$url='http://localhost:8080/healthcheck/ios/1/show-version';
					break;
				    case 'crashlist':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
				    case 'diameterpeers':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
				    case 'hdraid':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
				    case 'licenceinfo':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
 				    case 'rctstatus':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
 				    case 'showresource':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
 				    case 'services':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
 				    case 'sessionrecoverystatus':
					$url='http://localhost:8080/healthcheck/ios/1';
					break; 
					case 'srpcheckpoint':
					$url='http://localhost:8080/healthcheck/ios/1';
					break; 
          case 'srpinfo':
					$url='http://localhost:8080/healthcheck/ios/1';
					break;
          case 'srpinfochasstate':
					$url='http://localhost:8080/healthcheck/ars5000/1/show-version';
					break;
          case 'systemuptime':
					$url='http://localhost:8080/healthcheck/ars5000/1/show-version';
					break;
          case 'taskresource':
					$url='http://localhost:8080/healthcheck/ars5000/1/show-version';
					break;
          case 'diamproxy':
					$url='http://localhost:8080/healthcheck/ars5000/1/show-version';
					break;
          case 'taskressessmsg':
					$url='http://localhost:8080/healthcheck/ars5000/1/show-version';
					break;
          case 'showversionimageversion':
					$url='http://localhost:8080/healthcheck/ars5000/1/show-version';
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