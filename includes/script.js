//De functie hieronder wordt elke keer aan geroepen als er iets gebeurt
$(document).ready(function(){
  var addleden = []; //array alvast klaarzetten voor alle leden die aan of een dispuut of commissie worden toegevoegd
  $('.carousel').carousel(); //inladen slider homepage
  var className = $( "#getError" ).attr("class"); //zodra er door php een error bij een element genaamt getError is gezet wordt deze opgeslagen als className
  var classError = $( "#getErrormess" ).attr("class"); //zodra er door php een errorbericht bij een element genaamt getError is gezet wordt deze opgeslagen als classError
  $( "#"+className ).addClass( "is-invalid" ); //zet bij dit element bijvoorbeeld op de registratiepagina de class is-invalid zodat deze een rode lijn er omheen krijgt (via css)
  $("#feed"+className).removeAttr('hidden'); //onder elke textvakje op de registratie pagina staat een hidden tekst. hier haald hij dus het element hidden weg zodat hij zichtbaar wordt
  $("#feed"+className).text(classError); //zet het errorbericht in de feed

  //Zodra er op sidebarCollapse wordt geklikt (dit zijn die 3 streepjes boven aan de pagina)
  $('#sidebarCollapse').on('click', function () {
        //toggled hij tussen active en niet active (optewel open of gesloten)
        $('#sidebar').toggleClass('active');
    });
  //Als er ergens op een delete knopje wordt gedrukt dan activeerd hij deze
  $(".delModal").on("click", function () {
         var myName = $(this).data('id'); //slaat wat er in het data attribute staat van het element waar je op klikte op in myName
         var myChoice = $(this).attr("class"); //slaat op wat in de class staat als myChoice
         var myID = $(this).closest("tr").attr("id"); //slaat op wat in de dichtbijzijnde tr id staat op als myID
         var myCDID = $(this).closest("td").attr("id"); //en slaat van de dichtbijzijnde td id 't op in myCDID'
         myChoice = myChoice.substr( myChoice.lastIndexOf(' ') + 1); //van alle classes die hij net in myChoice heeft opgeslagen pakt hij hier alleen de laatste en slaat deze weer op
         $(".deleteName").text( myName ); //In de delete modal veranderd hij de text van alle elemementen met .deleteName naar wat er in myName staat (op de ledenpagina is dit bijvoorbeeld de naam van het aangeklikte lid)
         $("#setthisHref").attr("onclick", "location.href='?delete=yes&id="+myID+"&choice="+myChoice+"&ots="+myCDID+"'" ); //als laatste veranderd hij de onclick van de aangeklikte button
  });
  //Deze is met veel dingen hetzelfde als diegene hierboven. Dee wordt aangeroepen als er op edit geklikt wordt
  $(".editModal").on("click", function () {
         var myName = $(this).data('id'); //slaat wat er in het data attribute staat van het element waar je op klikte op in myName
         var myChoice = $(this).attr("class"); //slaat op wat in de class staat als myChoice
         var myID = $(this).closest("tr").attr("id"); //slaat op wat in de dichtbijzijnde tr id staat op als myID
         var myCDID = $(this).closest("td").attr("id"); //en slaat van de dichtbijzijnde td id 't op in myCDID'
         myChoice = myChoice.substr( myChoice.lastIndexOf(' ') + 1); //van alle classes die hij net in myChoice heeft opgeslagen pakt hij hier alleen de laatste en slaat deze weer op
         $(".deleteName").text( myName ); //In de edit modal veranderd hij de text van alle elemementen met .deleteName naar wat er in myName staat (op de ledenpagina is dit bijvoorbeeld de naam van het aangeklikte lid)
         //Kijk op mychoice commissie is zo ja verander dan #commNaam (commissienaam) zo nee dan dispnaam
         if(myChoice == "commissie"){
           $("#commNaam").val( myName ); //verander de value van commNaam
           $("#voorzitterNaam").val( myCDID ); //verander de value van voorzitterNaam
           $("#setthisHref2").attr("onclick", "location.href='?edit=yes&id="+myID+"&choice="+myChoice+"&ots="+myCDID+"'" ); //zet net zo als de vorige de onclick
         }else{
           $("#dispNaam").val( myName ); //verander de value van dispNaam
           $("#dvoorzitterNaam").val( myCDID ); //verander de value van dvoorzitterNaam
           $("#setthisHref3").attr("onclick", "location.href='?edit=yes&id="+myID+"&choice="+myChoice+"&ots="+myCDID+"'" ); //zet net zo als de vorige de onclick
         }
  });
  //zorg er voor dat als de sidebar toggled de main (waar alle content op staat) mee veranderd
  $('#sidebar_toggler').on('click', function () {
          //Als de sidebar zichtbaar is zet dan col-md-10 aan en col-md-12 uit zo niet dan andersom
          if($('#sidebar').hasClass("show")){
            $('main').toggleClass("col-md-10");
            $('main').toggleClass("col-md-12");
          }else{
            $('main').toggleClass("col-md-10");
            $('main').toggleClass("col-md-12");
          }
    });
    //##################################
    //Begin code voor order van tabellen en paginas
    //##################################
    //Kijk wat de orderBy class is (deze wordt door php gezet wanneer er op een sortering wordt geklikt)
    var orderName = $( "#orderBy" ).attr("class");
    $( "#"+orderName ).addClass( "orderBy" ); //Voeg deze toe aan diegene waar je op geklikt hebt

    //Kijk wat de pageLoc class is (deze is op elke pagina vast gezet) op de leden pagina staat dit zo (<h1 id="pageLoc" class="leden">ZHTC ledenbestand<span class="lead">Welkom bij het ZHTC adminpanel</span></h1>)
    var pageName = $( "#pageLoc" ).attr("class");
    if(pageName == "activiteiten"){
      $( "#"+pageName ).addClass( "selected" ); //op pagina activiteiten
      $( "#2"+pageName ).addClass( "selected" );
    }
    //Als pageName disabled is dan staat de sortering uit
    if(pageName == "disabled"){
      //niks
    }else{
      $( "#"+pageName ).addClass( "selected" );  //Voeg deze toe aan diegene waar je op geklikt hebt
    }
    //Einde
    //#####################################
    //Als er een voorzitter gezet is open dan de modaal hiervoor
    var voorzitterName = $( "#getVoorzitter" ).attr("class");
    if(voorzitterName != ""){
      $('#kiesVoorzitter').modal('toggle');
      $( "#getVoorzitter" ).removeClass();
    }

    //BEGIN CODE SIDEBAR
    switch (pageName) { //Kijk wat de pagename is deze wordt al eerder opgehaald zie hierboven in stuk code voor pagina's en sorteringen
    	case 'leden': //als het de leden pagina is dan open de tools van beheer
    		var tools = "beheer"; //tools zijn van beheer
        setSidebar(tools); //run de functie
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
    }
    //fucntie voor het openen van de juiste tools
    function setSidebar(tools) {
        $( "#"+tools ).addClass( "show" ); //laad de gekozen tools zien bijvoorbeeld die van beheer
        $( "#"+tools ).attr("aria-expanded","true"); //html attribute
        $( "#"+tools+"link" ).toggleClass( "collapsed" ); //toggle de class voor het openen van bijvoorbeeld de beheer tools
    }
    //EINDE CODE sidebar
    //Begin code voor polls toevoegen (als je een hoeveelheid intypd dat hij deze laad zien voor aantal pollkeuzemogelijkheden)
    $('#getErrormess').on('change', '#keuze', function() { //deze functie wordt aangeroepen als je iets hebt ingetypt bij keuzepogelijkheden
      $("#jq_target").empty(); //leeg als er nog wat instaat dit is nodig voor als iemand meerdere keren veranderd van keuze
      selectedPlaatsen = $(this).val(); //haal de value op van het input veldje
      if(selectedPlaatsen == 1){ //als het er maar een is zet hem dan op 2 (dat is het minimale aantal keuzes)
        selectedPlaatsen = 2;
      }
      for(var i = 1; i <= selectedPlaatsen; i++){ //loopje die per selectedPlaatsen in keer een input veldje er bij in gooit
      $("#jq_target").append("<div class='form-group row'><label for='mogelijkheid"+i+"' class='col-sm-3 col-form-label'>Keuze "+i+":</label><div class='col-sm-9 px-0 pr-5'><input  id='keuze"+i+"' type='text' class='form-control' name='keuze"+i+"' value='' required></div></div>");
      }
    });
    //einde code polls toevoegen
    //Begin code voor het fancy start editing dingetje van pagina activiteiten
    $('.toggleEdit').on('click', function () { //als edit modus getoggled wordt dan
          $(this).attr("type","hidden"); //haal de edit modus knop weg (hidden)
          $(".editKnop").attr("type","submit"); //laad de aanpassen knop zien
          $(".M_activiteitnaam").attr("readonly", false); //zet readonly uit bij alle input velden
          $(".M_activiteitdatumvan").attr("readonly", false);
          $(".M_activiteittijdvan").attr("readonly", false);
          $(".M_activiteitdatumtot").attr("readonly", false);
          $(".M_activiteittijdtot").attr("readonly", false);
          $(".M_activiteitlocatie").attr("readonly", false);
          $(".M_activiteitinfo").attr("readonly", false);
          $(".editActiviteitTekst").css("display", "block"); //en laad het tekste zien (U kunt nu aanpassingen maken aan deze activiteit)
    });

    $('.editActiviteit').on('hidden.bs.modal', function () { //als er op edit activiteit wordt geklikt (dit is dat pennetje in dat orange vakje)
      //alles weer terug zetten naar de standaard staat
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

    //begin code voor het toevoegenlid pagina
    $(".clickable-row").click(function(){ //als er in de table op een lid wordt geklikt
        var id = $('.id').attr('id'); //sla id op (van dit dispuut/commissie)
        var choice = $('.choice').attr('id'); //sla op of het om dispuut of commissie gaat
        var str = ""; //str definen
        if($('.as').attr('id') == "voorzitter"){ //als het gaat op een voorzitter toevoegen
          var href = choice+"leden?as=voorzitter&choice="+choice+"&id="+id+"&leden="; //zet de href
          if($(this).hasClass('highlight')){ //als deze al een grijze "highlight" heeft dan
            $(this).removeClass('highlight'); //verwijder deze highlight class
            addleden.splice( $.inArray($(this).attr('id'),addleden) ,1 ); //en verwijder deze uit de array
          } else { //is dat niet zo dan
            $(this).addClass('highlight').siblings().removeClass('highlight'); //voeg highlights toe en verwijder highlight van alle andere rows zodat je maar een voorzitter kan kiezen
            addleden = []; //devine addleden array
            addleden.push($(this).attr('id')); //zet dit id in de array
          }
        }else{ //ALs het gaat om leden toevoegen
          var href = choice+"leden?as=lid&choice="+choice+"&id="+id+"&leden="; //verander de href van de knop onder aan de pagina
          if($(this).hasClass("highlight")){ //als deze al een grijze "highlight" heeft dan
              $(this).removeClass('highlight'); //verwijder deze highlight class
              addleden.splice( $.inArray($(this).attr('id'),addleden) ,1 ); //en verwijder deze uit de array
          }else{ zo niet dan
              $(this).addClass('highlight'); //geef deze class highlight
              addleden.push($(this).attr('id')); //en zet hem in de array
          }
        }
        //loopje om alle leden in de array in str te zetten met een , ertussen bijvoorbeeld (321,422,98,214)
        for (var i = 0; i < addleden.length; i++) {
            str += addleden[i]+",";
        }
        href += str; //voeg dit toe aan de href dus dan ziet zo'n href er zo uit bijvoorbeeld (dispuutleden?as=lid&choice=dispuut&id=23&leden=321,422,98,214)
        $('#voltooien').attr("href", href); //zet de href daadwerkelijk
    });

    //begin code voor het laten zien dat je een bestand hebt gekozen voor (dispuutpagina en commissiepagina)
    $( "#file2" ).change(function() { //roep deze functie aan als je een bestand hebt gekozen
      var filename = $('input[type=file]').val().split('\\').pop(); //haal het bestandsnaam op
      $('#divFileName').text(filename); //en zet deze als text van een div ernaast
    });
    //einde code
    //begin code alerts
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){  //als hij een alrt dedecteerd laad deze naar boven faden in ongeveer 2 seconden
        $(this).slideUp(500);
        $(this).hide(); //daarna hide deze
    });
    //einde code alerts
});
