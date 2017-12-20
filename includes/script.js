$(document).ready(function(){
  var addleden = [];
  $('.carousel').carousel();
  var className = $( "#getError" ).attr("class");
  var classError = $( "#getErrormess" ).attr("class");
  $( "#"+className ).addClass( "is-invalid" );
  $("#feed"+className).removeAttr('hidden');
  $("#feed"+className).text(classError);

  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
  $(".delModal").on("click", function () {
         var myName = $(this).data('id');
         var myChoice = $(this).attr("class");
         var myID = $(this).closest("tr").attr("id");
         var myCDID = $(this).closest("td").attr("id");
         myChoice = myChoice.substr( myChoice.lastIndexOf(' ') + 1);
         //alert(myName+" "+myChoice+" "+myID+" "+myCDID);
         $(".deleteName").text( myName );
         $("#setthisHref").attr("onclick", "location.href='?delete=yes&id="+myID+"&choice="+myChoice+"&ots="+myCDID+"'" );
  });
  $(".editModal").on("click", function () {
         var myName = $(this).data('id');
         var myChoice = $(this).attr("class");
         var myID = $(this).closest("tr").attr("id");
         var myCDID = $(this).closest("td").attr("id");
         myChoice = myChoice.substr( myChoice.lastIndexOf(' ') + 1);
         //alert(myName+" "+myChoice+" "+myID+" "+myCDID);
         //alert(myName+" "+myChoice+" "+myID+" "+myCDID);
         $(".deleteName").text( myName );
         if(myChoice == "commissie"){
           $("#commNaam").val( myName );
           $("#voorzitterNaam").val( myCDID );
           $("#setthisHref2").attr("onclick", "location.href='?edit=yes&id="+myID+"&choice="+myChoice+"&ots="+myCDID+"'" );
         }else{
           $("#dispNaam").val( myName );
           $("#dvoorzitterNaam").val( myCDID );
           $("#setthisHref3").attr("onclick", "location.href='?edit=yes&id="+myID+"&choice="+myChoice+"&ots="+myCDID+"'" );
         }
  });
  $('#sidebar_toggler').on('click', function () {
          if($('#sidebar').hasClass("show")){
            $('main').toggleClass("col-md-10");
            $('main').toggleClass("col-md-12");
          }else{
            $('main').toggleClass("col-md-10");
            $('main').toggleClass("col-md-12");
          }
    });
    var orderName = $( "#orderBy" ).attr("class");
    $( "#"+orderName ).addClass( "orderBy" );

    var pageName = $( "#pageLoc" ).attr("class");
    if(pageName == "activiteiten"){
      $( "#"+pageName ).addClass( "selected" );
      $( "#2"+pageName ).addClass( "selected" );
    }
    if(pageName == "disabled"){
      //niks
    }else{
      $( "#"+pageName ).addClass( "selected" );
    }

    var voorzitterName = $( "#getVoorzitter" ).attr("class");
    if(voorzitterName != ""){
      $('#kiesVoorzitter').modal('toggle');
      $( "#getVoorzitter" ).removeClass();
    }
    //$( "#"+pageName ).addClass( "selected" );

    switch (pageName) {
    	case 'leden':
    		var tools = "beheer";
        setSidebar(tools);
    		break;
    	case 'poll':
    		var tools = "beheer";
        setSidebar(tools);
    		break;
    	case 'commissiedisputen':
    		var tools = "beheer";
        setSidebar(tools);
    		break;
      case 'beheerpagina':
      		var tools = "beheer";
          setSidebar(tools);
      		break;
      case 'activiteiten':
          var tools = "beheer";
          setSidebar(tools);
          var tools = "commissie";
          setSidebar(tools);
          break;
      case 'commissieleden':
      	var tools = "commissie";
        setSidebar(tools);
      	break;
      case 'commissiepagina':
      	var tools = "commissie";
        setSidebar(tools);
    		break;
      case 'dispuutleden':
        var tools = "dispuut";
        setSidebar(tools);
        break;
      case 'dispuutpagina':
        var tools = "dispuut";
        setSidebar(tools);
        break;
    	default:
    		//
    }
    function setSidebar(tools) {
        $( "#"+tools ).addClass( "show" );
        $( "#"+tools ).attr("aria-expanded","true");
        $( "#"+tools+"link" ).toggleClass( "collapsed" );
    }
    $('#getErrormess').on('change', '#keuze', function() {
      $("#jq_target").empty();
      selectedPlaatsen = $(this).val();
      if(selectedPlaatsen == 1){
        selectedPlaatsen = 2;
      }
      for(var i = 1; i <= selectedPlaatsen; i++){
      $("#jq_target").append("<div class='form-group row'><label for='mogelijkheid"+i+"' class='col-sm-3 col-form-label'>Keuze "+i+":</label><div class='col-sm-9 px-0 pr-5'><input  id='keuze"+i+"' type='text' class='form-control' name='keuze"+i+"' value='' required></div></div>");
      }
    });

    $('.toggleEdit').on('click', function () {
          $(this).attr("type","hidden");
          $(".editKnop").attr("type","submit");
          $(".M_activiteitnaam").attr("readonly", false);
          $(".M_activiteitdatumvan").attr("readonly", false);
          $(".M_activiteittijdvan").attr("readonly", false);
          $(".M_activiteitdatumtot").attr("readonly", false);
          $(".M_activiteittijdtot").attr("readonly", false);
          $(".M_activiteitlocatie").attr("readonly", false);
          $(".M_activiteitinfo").attr("readonly", false);
          $(".editActiviteitTekst").css("display", "block");
    });

    $('.editActiviteit').on('hidden.bs.modal', function () {
      $(".toggleEdit").attr("type","submit");
      $(".editKnop").attr("type","hidden");
      $(".M_activiteitnaam").attr("readonly", true);
      $(".M_activiteitdatumvan").attr("readonly", true);
      $(".M_activiteittijdvan").attr("readonly", true);
      $(".M_activiteitdatumtot").attr("readonly", true);
      $(".M_activiteittijdtot").attr("readonly", true);
      $(".M_activiteitlocatie").attr("readonly", true);
      $(".M_activiteitinfo").attr("readonly", true);
      $(".editActiviteitTekst").css("display", "none");
    })

    $(".clickable-row").click(function(){
        var id = $('.id').attr('id');
        var choice = $('.choice').attr('id');
        var str = "";
        if($('.as').attr('id') == "voorzitter"){
          var href = choice+"leden?as=voorzitter&choice="+choice+"&id="+id+"&leden=";
          if($(this).hasClass('highlight')){
            $(this).removeClass('highlight');
            addleden.splice( $.inArray($(this).attr('id'),addleden) ,1 );
          } else {
            $(this).addClass('highlight').siblings().removeClass('highlight');
            addleden = [];
            addleden.push($(this).attr('id'));
          }
        }else{
          var href = choice+"leden?as=lid&choice="+choice+"&id="+id+"&leden=";
          if($(this).hasClass("highlight")){
              $(this).removeClass('highlight');
              addleden.splice( $.inArray($(this).attr('id'),addleden) ,1 );
          }else{
              $(this).addClass('highlight');
              addleden.push($(this).attr('id'));
          }
        }
        for (var i = 0; i < addleden.length; i++) {
            str += addleden[i]+",";
        }
        href += str;
        $('#voltooien').attr("href", href);
    });
    $( "#file2" ).change(function() {
      var filename = $('input[type=file]').val().split('\\').pop();
      $('#divFileName').text(filename);
    });
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(this).slideUp(500);
        $(this).hide();
        //$('#message').empty();
    });
});
