$(document).ready(function(){
  var className = $( "#getError" ).attr("class");
  var classError = $( "#getErrormess" ).attr("class");
  $( "#"+className ).addClass( "is-invalid" );
  $("#feed"+className).removeAttr('hidden');
  $("#feed"+className).text(classError);

  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
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
    $( "#"+pageName ).addClass( "selected" );

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
      case 'dispuutepagina':
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
      for(var i = 1; i <= selectedPlaatsen; i++){
      $("#jq_target").append("<div class='form-group row'><label for='mogelijkheid"+i+"' class='col-sm-3 col-form-label'>Keuze "+i+":</label><div class='col-sm-9 px-0 pr-5'><input  id='keuze"+i+"' type='text' class='form-control' name='keuze"+i+"' value='' required></div></div>");
      }
    });
});
