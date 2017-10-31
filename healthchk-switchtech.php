<script type ="text/javascript">
$(document).ready(function(){
                $('.anchorcmd').click(function () { 

                $("#mycmdModal").on("hidden.bs.modal", function(){
                    $(".modal-content").html("<div>Loading Please Wait!</div>");
                }); 

                $("#mycmdModal").modal({
                    remote: $(this).attr('href'),
                    refresh: true
                });            
                 $('#mycmdModal').removeData()   
                 return false;                  
              })
            });        

</script>
<?php
include "classes/db2.class.php";
include "classes/paginator.class.php";  
include 'functions.php';
//$userid = $_GET['userid'];
//$deviceid = $_GET['deviceid'];
//$arr_res = getDetailViewData($userid, $deviceid );  
//$output = $arr_res['result'][0];
// print_r($output); 
?>
    <?php  
                                               //  Python API Request using curl Begins                    
            $userid = $_GET['userid'];
            $deviceid = $_GET['deviceid'];               
                        $data = 
                                array(
                                "username" => $_SESSION['username'],
                                "password" => "python",
                                "ip_addr" => $device['deviceIpAddr'],
                                "command" => "showversion"
                                
                                ); 
                       // $url_send ="http://localhost/ncm/sshpost.php";  
        $url_send ="http://localhost/ncm/healthcheck/1"; 
            $deviceid = $_GET['deviceid'];              
            $url_final = $url_send.'?deviceid='.$deviceid;            
                        $output = json_decode(sendPostData($url_final),true);
                        
                        ?>

                <div class="ownfont box-body launch-modal">
                  <table class="table table-bordered"  cellspacing="0" cellpadding="0" >
                     <tbody>
                                            <tr>                  
                                              <td><b>Alarm Outstanding</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=alarmoutstanding"><img src="resources/img/RDimage.png"  alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['show_alarm_outstanding']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['show_alarm_outstanding']['count'].'</span>';echo $display; ?></td>
                                              <td><b>Card Hardware </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=cardhardware"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"></img></a><?php $color = ($output['show_card_hardware_grep_prog']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['show_card_hardware_grep_prog']['upto_date_count'].'</span>'; echo $display; ?></td>
                                              <td><b>Card Information </b> </td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=cardinformation"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo 'Locked Account'.$output['show_card_info_grep_card_lock']['locked_count'].'Unlocked Account'.$output['show_card_info_grep_card_lock']['unlocked_count'];?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>Card Table</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=cardtable"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_card_table_grep']['count'];?></td>
                                              <td><b>clock</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=clock"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_clock'];?></td>
                                              <td><b>Context </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=context"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['show_context']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['show_context']['active_count'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            
                                            <tr>                  
                                              <td><b>Crash List</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=crashlist"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php  
echo $output['totalcrashes']; ?></td>
                                              <td><b>Diameter Peers</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=diameterpeers"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> 
<?php echo $output['show_diameter_peers']; ?></td>
                                              <td><b>HD RAID</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=hdraid"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php echo $output['show_hd_raid_grep_degrad']; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>Licence Information</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=licenceinfo"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php echo $output['show_license_info_grep_license_status']['license_status']; ?></td>
                                              <td><b>RCT Status</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=rctstatus"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_rct_status']['Migrations']; ?></td>
                                              <td><b> Show Resource </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=showresource"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['show_resource_grep_license']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['show_resource_grep_license']['within_acceptable_limits_count'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>Services</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=services"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=hdraid"><?php echo 'Context Id :'.$output['show_service_all']['count_unique_context_id'].'Service Id : '.$output['show_service_all']['count_unique_service_id'];?></td>
                                              <td><b>Session Recovery Status </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=sessionrecoverystatus"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php echo $output['show_session_recovery_status_verbose']['overall_status']; ?></td> 
</td>
                                              <td><b>SRP Checkpoint Statistics</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=srpcheckpoint"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_srp_checkpoint_statistics_grep_sessmgrs']['number_of_sessmgrs']; ?> </td>
                                            </tr>
                                            <tr>                  
                                              <td><b>SRP Information </b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=srpinfo"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_srp_info']['chassis_state']; ?></td>
                                              <td><b>SRP Information chassis State </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=srpinfochasstate"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_system_uptime'];?></td>
                                              <td><b>System Uptime </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=systemuptime"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php echo $output['show_srp_info_grep_chassis_state'];?>                                        
                                            </tr>                  
                                            <tr>   
                                              <td><b>Task Resource</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=taskresource"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['show_task_resource_grep_v_good']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['show_task_resource_grep_v_good']['count'].'</span>';
echo $display; ?></td>
                                              <td><b>Task Resource Diamproxy</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=diamproxy"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php echo $output['count'];?></td>
                                              <td><b>Task Resources Session Message</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=taskressessmsg"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php
$color = ($output['show_task_resources_grep_sessmg']['status'] == 'pass') ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['show_task_resources_grep_sessmg']['count'].'</span>';
echo $display; ?></td>
                                            </tr>                  
                                            <tr>  
                                            <!--  <td><b>Light Level</b></td>      
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=lightlevel"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php //echo $output['lightlevel']; ?></td>-->
                                              <td><b>Show version - Image version</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-switches.php?commandname=showversionimageversion"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['show_version_grep_image_version'];?></td>
                                              <td>&nbsp;&nbsp;&nbsp;</td>                                                 
                                              <td> <b> Rerun All checks </b></td> 
                                              <td>&nbsp;&nbsp;&nbsp;</td>         
                                            </tr>
                                          </tbody>
                                       </table>
                                    </div>
