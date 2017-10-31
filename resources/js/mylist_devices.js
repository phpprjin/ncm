$(document).ready(function() {
     
    $('.device_details').click(function(e){
 
        $thisdiv = $(this);
        if(!$(this).hasClass('loaded')) { 
        $.ajax({
            type:"get",
            url:"healthchk-switchtech.php",
            data: {deviceid:$(this).data('deviceid'), userid:$(this).data('userid')},
            beforeSend: function(){
                $thisdiv.next('div').html('<div class="text-center overlay box-body">Loading... <div class="fa fa-refresh fa-spin" style="font-size:24px; text-align:center;"></div></div>');
            },
            complete: function() {
                $thisdiv.addClass('loaded');
            },
            success: function(resdata){
                setTimeout(function(){
                    $thisdiv.next('div').html(resdata);                  
                },200  );
            }
        });
        } 
    });

    /*
    *
    */
    $(document).on("click",".launch-modal",function(){ 
    
        $("#mycmdModal").modal({
          remote: "devdetmdl-switches.php"
        });
    }
    );
});