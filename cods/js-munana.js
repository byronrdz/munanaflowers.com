$(function(){
	$(".sp").hide();
	$(".en").show();
	


//---Galeria------------------------------
	$("#ventana").hide();
	$("#transparente").hide();
	$("#nombre").hide();

	$(".th").attr("width","200");
	$(".th").attr("height","113");


	$(".th").click(function(){
		imagen = ($(this).attr("id"));
		nombre = ($(this).attr("alt"));
		$("<img id='hotspot' src=imgs/galeria/"+imagen+">").appendTo($("#ventana"))
		$("<div id='nombre'>"+nombre+"</div>").appendTo($("#ventana"))
		$("#hotspot").css({"z-index":"4","position":"absolute","top":"0px","left":"0px"});
		$("#ventana").fadeIn();
		$("#transparente").fadeIn();
		$("#nombre").fadeIn();
	});

	recuperar = function(){
		$("#ventana").empty();
		$("#ventana").fadeOut();
		$("#transparente").fadeOut();
		$("#nombre").fadeOut();
	};

	$("#ventana").click(function(){recuperar()});
	$("#transparente").click(function(){recuperar()});
	$("body").keypress(function(){recuperar()});

	$(".th").hover(
	function(){$("body").css("cursor","crosshair")},
	function(){$("body").css("cursor","default")}
	);


//---Menu-------------------------------


	$(".boton_menu").hover(
		function(){
			$(this).css({"border-bottom":"1px solid #f07070","background":"#ffeeee"});
		},
		function(){
			$(this).css({"border-bottom":"0px","background":"#ffffff"});
		}
	);
	
	$(".boton_menu").click(

		function(){
			var lugar;
			lugar = $(this).attr("alt");
			document.getElementById(lugar).scrollIntoView({
        			behavior: "smooth"
      			});
		}
	);	

//---Boton home--------------------


	$(".boton-home").hover(
		function(){
			$(this).css("top","-31px");
			
		},
		function(){
			$(this).css("top","-28px");
		}
	);


	$(".boton-home").click(
		function(){
			var lugar;
			lugar = "home";
			document.getElementById(lugar).scrollIntoView({
        			behavior: "smooth"
      			});
		}
	);	
	
//----Boton lang--------------------------

	$("img.boton-lang").hover(
		function(){
			$(this).css({"width":"36px","height":"42px"});
			
		},
		function(){
			$(this).css({"width":"35px","height":"40px"});
		}
	);
	
	$("#boton-sp").click(function(){
		$(".en").hide();
		$(".sp").show()
	});

	$("#boton-en").click(function(){
		$(".sp").hide();
		$(".en").show()
	});

});
