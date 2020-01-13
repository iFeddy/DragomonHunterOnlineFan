//var url = "http://localhost/dragomon/"
var url = "http://www.dragomonhunterfan.com/";

var screen_width = window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;

var screen_height = window.innerHeight ||
    document.documentElement.clientHeight ||
    document.body.clientHeight;

function imgError(image) {
	image.src = url + "/resources/images/noimg.png";
	return true;
}	
	
$(window).scroll(function() {
    if(screen_width > 1023){
        if ($(this).scrollTop() > screen_height / 6) {
            $('.upbt').fadeIn("slow");
    		$('.lateralMenu').fadeIn("slow");
    		
        } else {
            $('.upbt').fadeOut("slow");
    		$('.lateralMenu').fadeOut("slow");
        }
    }
});

var isActiveMenu;
$(window).resize(function() {
	responsiveChanges();
});

$(document).ready(function() {

    // Get an array of all element heights
    var elementHeights = $('.itemSearchBoxes a').map(function() {
        return $(this).height();
    }).get();

    // Math.max takes a variable number of arguments
    // `apply` is equivalent to passing each height as an argument
    var maxItemBoxHeight = Math.max.apply(null, elementHeights);

    // Set each height to the max height
    //alert(maxItemBoxHeight);
    $('.itemSearchBoxes a').height(maxItemBoxHeight);

	var isSlideDown = 0;
    $("#downfilterIcon").css("transform", "rotate(0deg)");
    
	var isFilterDown = 0;
    responsiveChanges();
	
	$('.showFilter').click(function() {
		if(isFilterDown == 0){
					$( ".filterItems" ).slideDown(800);
					$("#downfilterIcon").css("transform", "rotate(180deg)");
					isFilterDown = 1;
				}else{
					$( ".filterItems" ).slideUp(800);
					$("#downfilterIcon").css("transform", "rotate(0deg)");
					isFilterDown = 0;
		}
    });
	
	$( "#respSearch" ).click(function() {
		if(isSlideDown == 0){
			$( ".respSearchMenu" ).slideDown(800);
			isSlideDown = 1;
		}else{
			$( ".respSearchMenu" ).slideUp(800);
            $( ".respMenu" ).slideUp(800);
			isSlideDown = 0;
		}
	});
	
    $( "#respButton" ).click(function() {
		if(isSlideDown == 0){
			$( ".respMenu" ).slideDown(800);
			isSlideDown = 1;
		}else{
            $( ".respSearchMenu" ).slideUp(800);
			$( ".respMenu" ).slideUp(800);
			isSlideDown = 0;
		}
	});

	$('[title]').qtip({
		style: {
			classes: 'qtip-bootstrap qtip-rounded'
		},
		 position: {
                    my: 'left center',
                    at: 'right center',
                    viewport: $(document.body)
                }
	});
		
    $("#showCraftfrItem").click(function() {

        var dmhf_id = $(this).attr('dmhf_id');
        var dmhf_page = $(this).attr('dmhf_pg');
        nextPage = parseInt(dmhf_page) + 1;

        $("#ajaxCraft").fadeIn(500);
        $.get(url + "lib/ajax/ajaxCraftItem.php?id=" + dmhf_id, function(iCraftedItems) {
            //$( "#showCraftfrItem" ).fadeOut(100);
            if (iCraftedItems != "DONE") {
                $("#ajaxCraft").empty();
                $("#ajaxCraft").hide();
                $("#ajaxCraft").append(iCraftedItems).fadeIn(1000);
                $("#showCraftfrItem").attr("dmhf_pg", nextPage);
                $("#showCraftfrItem").hide();
            }
        });
    });
    if (window.canRunAds === undefined) {
        // Mostrar Publicidad para deshabilitar adBlock

        setTimeout(function() {
            $("#overlay").fadeIn(1000);
            setTimeout(function() {
                $("#killMsg").fadeIn(400);
            }, 1000);
        }, 1000);
    }	
	
    /**$( "#overlay" ).click(function() {
    	$("#killMsg").fadeOut(400);
    	setTimeout(function() {
    		$("#overlay").fadeOut(1000);
    	}, 300);
    });**/

    checkSelectedItemStatus();

    $("#killBlock").click(function() {
        document.cookie = '_gotmsg=true; path=/';
        $("#killMsg").fadeOut(400);
        setTimeout(function() {
            $("#overlay").fadeOut(1000);
        }, 300);
    });

    $('.upbt').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 400);
        return false;
    });

	 $('#respUp').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 300);
        return false;
    });
	var isRespQuestOn = 0;
    var isRespTitleOn = 0;
    var isRespAchieOn = 0;

    $('.respSubTouch01').click(function() {
        if(isRespQuestOn == 0){
        $("#respQuest").slideDown(500);
        $("#respTitle").slideUp(500);
        $("#respAchie").slideUp(500);
        isRespQuestOn = 1;
        }else{
           $("#respQuest").slideUp(500); 
           isRespQuestOn = 0;
        }
    });

    $('.respSubTouch02').click(function() {
        if(isRespTitleOn == 0){
        $("#respQuest").slideUp(500);
        $("#respTitle").slideDown(500);
        $("#respAchie").slideUp(500);
        isRespTitleOn = 1;
        }else{
           $("#respTitle").slideUp(500); 
           isRespTitleOn = 0;
        }
    });

    $('.respSubTouch03').click(function() {
        if(isRespAchieOn == 0){
        $("#respQuest").slideUp(500);
        $("#respTitle").slideUp(500);
        $("#respAchie").slideDown(500);
        isRespAchieOn = 1;
        }else{
           $("#respAchie").slideUp(500); 
           isRespAchieOn = 0;
        }
    });

    if ($("#SDBTABLES").length > 0) {
        var sIndex = 'lib/ajax/ajaxSearch.php?k=';
        var sKey = $("#CONF_KEYS").text();

        $.when(i()).done(function() {
			$.when(a()).done(function(){
				$.when(t()).done(function(){
					$.when(m()).done(function(){
						$.when(q()).done(function(){
							$.when(b()).done(function(){
								cl();
							});
						});
					});
				});
            });
        });
		function cl(){
			$("#searchNew").fadeOut(500);
			setTimeout(function() {
				$("#SDBRESULT").fadeIn(500);
			}, 500);
		}
        function i(){
            //Items
            var cName = 4;
            var ajaxURL = $("#CONF_URL").text() + sIndex + sKey + "&c=" + cName;

            $("#SDBTABLES").replaceWith("<div id=\"SDBTABLES\">Items</div>");

            return $.ajax({
                url: ajaxURL,
                success: function(response) {
                    $("#SDBRESULT").append(response);
                }
            });
        }
		function b(){
            //biology
            var cName = 7;
            var ajaxURL = $("#CONF_URL").text() + sIndex + sKey + "&c=" + cName;

            $("#SDBTABLES").replaceWith("<div id=\"SDBTABLES\" style=\"color:rgb(153, 153, 222);\">Biology</div>");

            return $.ajax({
                url: ajaxURL,
                success: function(response) {
                    $("#SDBRESULT").append(response);
                }
            });
        }
		function q(){
            //quests
            var cName = 9;
            var ajaxURL = $("#CONF_URL").text() + sIndex + sKey + "&c=" + cName;

            $("#SDBTABLES").replaceWith("<div id=\"SDBTABLES\" style=\"color:rgb(108, 110, 37);\">Quests</div>");

            return $.ajax({
                url: ajaxURL,
                success: function(response) {
                    $("#SDBRESULT").append(response);
                }
            });
        }
		function m(){
            //maps
            var cName = 8;
            var ajaxURL = $("#CONF_URL").text() + sIndex + sKey + "&c=" + cName;

            $("#SDBTABLES").replaceWith("<div id=\"SDBTABLES\" style=\"color:rgb(228, 155, 27);\">Maps</div>");

            return $.ajax({
                url: ajaxURL,
                success: function(response) {
                    $("#SDBRESULT").append(response);
                }
            });
        }
		function a(){
            //achievementes
            var cName = 5;
            var ajaxURL = $("#CONF_URL").text() + sIndex + sKey + "&c=" + cName;

            $("#SDBTABLES").replaceWith("<div id=\"SDBTABLES\" style=\"color:rgb(60, 255, 0);\">Achievements</div>");

            return $.ajax({
                url: ajaxURL,
                success: function(response) {
                    $("#SDBRESULT").append(response);
                }
            });
        }
		function t(){
            //titles
            var cName = 6;
            var ajaxURL = $("#CONF_URL").text() + sIndex + sKey + "&c=" + cName;

            $("#SDBTABLES").replaceWith("<div id=\"SDBTABLES\" style=\"color:rgb(117, 117, 117);\">Titles</div>");

            return $.ajax({
                url: ajaxURL,
                success: function(response) {
                    $("#SDBRESULT").append(response);
                }
            });
        }
      } 
	  
});


function checkSelectedItemStatus(){
    //Base Stats
    var iHP = $('#iHP').text();
    var iSP = $('#iSP').text();
    var iATK = $('#iATK').text();
    var iPEN = $('#iPEN').text();
    var iDEF = $('#iDEF').text();
    var iCRIT = $('#iCRIT').text();
    var iCRITDMG = $('#iCRITDMG').text();

    $('#statusJQ').on('change', function() {

        var nHP = Math.round(iHP * (this.value / 100));
        $('#iHP').text(nHP);

        var nSP = Math.round(iSP * (this.value / 100));
        $('#iSP').text(nSP);
        
        var nATK = Math.round(iATK * (this.value / 100));
        $('#iATK').text(nATK);

        var nPEN = Math.round(iPEN * (this.value / 100));
        $('#iPEN').text(nPEN);        

        var nDEF = Math.round(iDEF * (this.value / 100));
        $('#iDEF').text(nDEF);   

        var nCRIT = Math.round(iCRIT * (this.value / 100));
        $('#iCRIT').text(nCRIT);        

        var nCRITDMG = Math.round(iCRITDMG * (this.value / 100));
        $('#iCRITDMG').text(nCRITDMG);   
    })
}

function responsiveChanges(){

    var screen_width = window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;

    if(screen_width < 1024){
		
		$('#gplayAPP').fadeIn(100);
				
        if(isActiveMenu != 1){  
            isActiveMenu = 1;
            $('#respButton').fadeIn(100);
            $('#respUp').fadeIn(100);
            $('#respSearch').fadeIn(100);
            //ORDER
            $('#welcomeBanner').insertBefore('#navigateMenu');
            $('#ads300x600').insertAfter('#discus');
            $('#ads300x600').css("margin-bottom", "15px");
            
        }   
    }else{
        isActiveMenu = 0;
            $('#respButton').fadeOut(100);
            $('#respUp').fadeOut(100);
            $('#respSearch').fadeOut(100);
            $('#welcomeBanner').insertBefore('#navigateMenu');
            $('#ads300x600').insertAfter('#searchAll');
    }
}