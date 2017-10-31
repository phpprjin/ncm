$(document).ready(function() { 

 /* City Select box form submit */
  /*
  $('.city_name_list').change(function(e) {
    if ($(this).val() != '') {
      $('#city_form').submit();
    }
  });
  
  */
  
  // $("#markets").change(function() 
  // {       
  //   $.ajax({
  //     type: "get",
  //     url: "marketregions.php",
  //     data: {
  //       'marketname':$("#markets").val()
  //     },
  //     beforeSend: function() { 
  //     },
  //     complete: function() { 
  //     },
  //     success: function(resdata) {
  //       $('#subregions').html("");
  //       $('#subregions').append("<option value=''>Select subregion</option>");
  //       $.each(resdata, function(key, data) {
  //         $('#subregions').append("<option value='" + data.subregion +
  //           "'>" + data.subregion + "</option>");
  //       });
  //     }
  //   });
  // });

  /* City Select box form submit */
 
  $('.city_name_list, .market_name_list').change(function() {
    // alert($(this).attr('id'));
    if ($(this).attr('id') == 'markets') {

      $('#subregions').val('');
      // alert($('#subregions').val());
    }

    //if ($(this).val() != '') {
      $('#city_form').submit();
    //} 
  });  
    
  /*
  $('.market_name_list').click(function(e)) {
          alert('markets clicked.');
   
   });
  */
  /* Accordian ajax call for switch details */
  $('.device_details').click(function(e) {
    $thisdiv = $(this);
    if (!$(this).hasClass('loaded')) {
      $.ajax({
        type: "get",
        url: "ajaxer/mycityswitchlist.php",
        data: {
          deviceid: $(this).data('deviceid'),
          userid: $(this).data('userid')
        },
        beforeSend: function() {
          $thisdiv.next('div').html(
            '<div class="text-center overlay box-body">Loading... <div class="fa fa-refresh fa-spin" style="font-size:24px; text-align:center;"></div></div>'
          );
        },
        complete: function() {
          $thisdiv.addClass('loaded');
        },
        success: function(resdata) {
          setTimeout(function() {
            $thisdiv.next('div').html(resdata);
          }, 200);
        }
      });
    }
  });

  $('#mapstates').click(function() {
    $('#map_section').hide('slow');
  });
   
  $(document).on("mouseover", "body", function() {
          $("#switchlist .draggable").draggable({
      cursor: "move",
      cursorAt: {
        top: 15,
        left: 15
      },
      helper: function(event){
        return $("<div class='btn btn-warning btn-small'><i class='fa fa-times'></i>&nbsp;&nbsp;" + $(this).data('listname') + "</div>");
      }

    });

    $("#myswitchlist_delete.droppable").droppable({ 
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function(event, ui) {   
        switchlistdel( $('#hidd_userid').val() , ui.draggable.data('listid'));
      }
    });

// My Device List Section
    $("#mydevicestbl .draggable").draggable({
      cursor: "move",
      cursorAt: {
        top: 15,
        left: 15
      },
      helper: function(event){
        return $("<div class='btn btn-warning btn-small'><i class='fa fa-times'></i>&nbsp;&nbsp;" + $(this).data('devicename') + "</div>");
      }

    });

    $("#mylist_delete.droppable").droppable({ 
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function(event, ui) { 
      switchesdel($('#hidd_userid').val(), ui.draggable.data('listid')  ,  ui.draggable.data('deviceid')); 
        //alert('asd');  , ui.draggable.data('listid'));
      }
    });

    /**
    *  Drag and Drop devices to my device list box
    */
    /*Draggable option enaled for Device List box accordion container */
    $("#container_mycityswitches .draggable").draggable({
      cursor: "move",
      cursorAt: {
        top: -2,
        left: -2
      },
      helper: function(event) {
        return $(
          "<div class='box' style='border:1px solid gray; background-color:lightblue;width:200px'><i class='fa fa-plus'></i> &nbsp; " +
          $(this).data('devicename') +
          "</div>");
      }
    });

    /*Droppable option enabled for My Device List box in MyList section*/
    $("#deviceslist.droppable").droppable({
      drop: function(event, ui) {
        $item = ui.draggable; 
        if (!$(this).find('tr').hasClass('del_' + $item.data('deviceid'))) {
          $(this).find('table#mydevicestbl').append(reconstruct(ui.draggable)); 
          add_item_my_devices($item.data('userid'),$('#hidd_mylistid').val(), $item.data('deviceid'))
        }
      }
    });
  });

  $(".map_region").click(function(marketid) {
    $("#marketname").val($(this).data('market')); 
    $("#market-region").text($(this).data('market').replace('R' ,'Regn').replace('M','-Market')); 
    $(location).attr("href","switchtech_devicelist.php?markets="+$(this).data('market'))
    
  });

  $(".map_region").mouseenter(function(market) {    
    $("#market-region").html('<span style="color:orange">' + $(this).data('market').replace('R' ,'Regn').replace('M','-Market') + '</span>'); 
  });

  $(".map_region").mouseleave(function(market) {    
    $("#market-region").text($("#marketname").val().replace('R' ,'Regn').replace('M','-Market')); 
  });

});

function reconstruct($item) {   

  return "<tr class=del_" + $item.data('deviceid') + ">" + "<td align='left'><i data-listid='" +  $item.data('listid') + "' data-deviceid='" + $item.data('deviceid') + "' data-devicename='" +  $item.data('devicename') + "' class='fa fa-arrows draggable'></i>&nbsp;" + $item.data('deviceid') + "</td>" +
    "<td align='length'>" +  $item.data('devicename') + "</td></tr>";
}

function drag_and_drops() {
     $("#switchlist .draggable").draggable({
      cursor: "move",
      cursorAt: {
        top: 15,
        left: 15
      },
      helper: function(event){
        return $("<div class='btn btn-warning btn-small'><i class='fa fa-times'></i>&nbsp;&nbsp;" + $(this).data('listname') + "</div>");
      }

    });

    $("#myswitchlist_delete.droppable").droppable({ 
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function(event, ui) {   
        switchlistdel( $('#hidd_userid').val() , ui.draggable.data('listid'));
      }
    });

// My Device List Section
    $("#mydevicestbl .draggable").draggable({
      cursor: "move",
      cursorAt: {
        top: 15,
        left: 15
      },
      helper: function(event){
        return $("<div class='btn btn-warning btn-small'><i class='fa fa-times'></i>&nbsp;&nbsp;" + $(this).data('devicename') + "</div>");
      }

    });

    $("#mylist_delete.droppable").droppable({ 
      classes: {
        "ui-droppable-active": "ui-state-active",
        "ui-droppable-hover": "ui-state-hover"
      },
      drop: function(event, ui) { 
      switchesdel($('#hidd_userid').val(), ui.draggable.data('listid')  ,  ui.draggable.data('deviceid')); 
        //alert('asd');  , ui.draggable.data('listid'));
      }
    });

    /**
    *  Drag and Drop devices to my device list box
    */
    /*Draggable option enaled for Device List box accordion container */
    $("#container_mycityswitches .draggable").draggable({
      cursor: "move",
      cursorAt: {
        top: -2,
        left: -2
      },
      helper: function(event) {
        return $(
          "<div class='box' style='border:1px solid gray; background-color:lightblue;width:200px'><i class='fa fa-plus'></i> &nbsp; " +
          $(this).data('devicename') +
          "</div>");
      }
    });

    /*Droppable option enabled for My Device List box in MyList section*/
    $("#deviceslist.droppable").droppable({
      drop: function(event, ui) {
        $item = ui.draggable; 
        if (!$(this).find('tr').hasClass('del_' + $item.data('deviceid'))) {
          $(this).find('table#mydevicestbl').append(reconstruct(ui.draggable)); 
          add_item_my_devices($item.data('userid'),$('#hidd_mylistid').val(), $item.data('deviceid'))
        }
      }
    });
 
}

function showMap() {
  // alert('sdf');
  $('#map_section').show();
}

function add_item_my_devices(userid, switchlistid, deviceid) {
  $.ajax({
    type: "POST",
    dataType: "json",
    url: 'usrfavlistedit.php',
    data: {
      'switchlistid': switchlistid,
      'deviceid': deviceid,
      'userid': userid,
      'operation': 'add'
    },
    success: function(data) { 
      var len = data.length;
      for (var i = 0; i < len; i++) {     
        var tr_str = "<tr class=del_" + data[i].nodeid + ">" + "<td align='center'>" + data[i].nodeid +
          "</td>" + "<td align='center'>" + '<i class="fa fa-trash" onclick="switchesdel(' +
          userid + ',' + switchlistid + ',' + data[i].nodeid + ');" width="22" height="22">' +
          "</td>" + "</tr>";
        $("#mydevicestbl").append(tr_str);
      }
    }
  });
}

/*
* To be removed ( this feature is implemented directly on page reload )
* This function is used for listing mydevice list 
*/
/*
--- can be Remove from this ----
function switchlist(userid, switchlistid) {
  // alert('inside the switchlist id'+switchlistid);
  swtlstidglbl = switchlistid;
  $('table#mydevicestbl').find("tr:gt(0)").remove();
  $('#my_device_list_name').text();

  $('#deviceslist').addClass("droppable");
  $('#mydevicestbl').attr('data-mylistid', switchlistid);
  $('#hidd_mylistid').val(switchlistid);
  $.ajax({
    type: "POST",
    dataType: "json",
    url: 'usrfavlistedit.php',
    data: {
      'switchlistid': switchlistid,
      'userid': userid,
      'operation': 'list'
    },
    success: function(res_data) { 
      var mylistname = res_data.mylistname;
      var data = res_data['result'];
      if (data) {
        $.each(data, function(i, item) {
          var tr_str = "<tr class='del_" + item.nodeid + "'>" + "<td align='left'><i data-listid='"+switchlistid+"' data-deviceid='"+item.nodeid + "' data-devicename='"+  item.deviceName + "' class='draggable fa fa-arrows'></i>&nbsp;" +
            item.nodeid + "</td>" + "<td align='left'>" +  item.deviceName + "</td>" +
            "</tr>";
          $("#mydevicestbl").append(tr_str);
        });
      }
      $('#my_device_list_name').text(mylistname);
    }
  });
}
--- Remove till this ---- 
*/
function switchlistdel(userid, switchlistid) {
  if (confirm('Are you sure you want to delete list?')) {
    $.ajax({
      type: "POST",
      url: 'usrfavlistdel.php',
      data: {
        'switchlistid': switchlistid,
        'userid': userid
      },
      success: function() {
        $(location).attr("href", 'switchtech_devicelist.php'); 
      }
    });
  }
}

function switchesdel(userid, listid, switchid) { 
  if (confirm('Are you sure you want to delete device?')) {
    $.ajax({
      type: "POST",
      url: 'usrfavswitchdel.php',
      data: {
        'userid': userid,
        'listid': listid,
        'switchid': switchid
      },
      success: function() {
        $('.del_' + switchid).remove();
      }
    })
  }
}