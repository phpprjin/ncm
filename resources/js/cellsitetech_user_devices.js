$(document).ready(function() {
      
         var table =  $('#example').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":"cellt_server_process.php",             
          "columns": [
            {  "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''},
            { "data": "csr_site_name" },
            { "data": "deviceName" },
            { "data": "market" },
            { "data": "deviceseries" },
            { "data": "nodeVersion" },
            { "data": "lastpolled" }
        ],
        "order": [[1, 'asc']],
            // Per-row function to iterate cells
        "createdRow": function (row, data, rowIndex) {
             $(row).addClass('device_row');
        }

      } );

      $('#example tbody').on('click', 'td.details-control', function () {
        
         var tr = $(this).closest('tr');
         var row = table.row( tr ); 
         var current_click_row = row.child.isShown();

         $('tr.device_row').each(function(){  
          
          var orow = table.row(this);
          // alert(orow.child.isShown());
          if (orow.child.isShown()){                
              // This row is already open - close it
                orow.child.hide();
                $(this).removeClass('shown');
          }
         }); 

         
          if ( row.child.isShown() ) {
              // This row is already open - close it
              row.child.hide();
              tr.removeClass();
          }
          else {
                  // Open this row
                  // alert(tr.attr('id'));
                  if (!current_click_row ){
                  row.child( format(tr.attr('id')) ).show();
                  tr.addClass('shown');

                  var id = tr.attr('id').replace('row_','');  
                  var ajs = $.ajax({
                    type:"get",
                    url:"healthchk-cellsitetech.php",
                    data: {deviceid:id, userid:$('#userid').val()},
                    beforeSend: function(){
                        $('#detail_'+id).html('<div class="text-center overlay box-body">Loading... <div class="fa fa-refresh fa-spin" style="font-size:24px; text-align:center;"></div></div>');
                    },
                    complete: function() {
                        $('#detail_'+id).addClass('loaded');
                    },
                    success: function(resdata){
                        $('#detail_'+id).html(resdata);
                    }
                });
            }
          }

             

      });

});

function format ( d ) {
     var id = d.replace('row_','');
    
     return "<div id='detail_"+id+"'></div>";
     
  }