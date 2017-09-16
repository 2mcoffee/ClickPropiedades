<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>ClickPropiedades.com | Propiedades e Inmuebles en Venta y Alquiler</title>

<!--Framework JQuery-->
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>

<!--Google Fonts-->
<link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>

<!--API Google Maps-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBC-d0FBMhO-Ix712FZ7kQrz38GXtVm-XQ&sensor=FALSE" type="text/javascript"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?sensor=FALSE" type="text/javascript"></script>

<!--Hojas de Estilo-->
<link rel="stylesheet" type="text/css" href="css/default.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/lightSlider.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/lightGallery.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/alertify.core.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/alertify.default.css" media="screen">

<!--Slider & Gallery-->
<script type="text/javascript" src="js/jquery.lightSlider.js"></script>
<script type="text/javascript" src="js/lightGallery.js"></script>
<script type="text/javascript" src="js/zoomsl-3.0.js"></script>

<!--Flip Images-->
<script type="text/javascript" src="js/jquery.cycle2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle2.caption2.min.js"></script>

<!--Validaciones-->
<script type="text/javascript" src="js/alertify.js"></script>

<!--Formulario-->
<script type="text/javascript" src="js/form.js"></script>

<!--Funcion Destacados-->
<script type="text/javascript">
    $(document).ready(function() {
	$("#featured").lightSlider({
		item:4,
		keyPress:true,
		auto:true,
		loop:true});
	});
</script>

<!--Llenado de Combos-->
<script type="text/javascript">
$(document).ready(function() 
{
	$("#provincia").change(function() {
		var provincia = $(this).val();
		 
				if(provincia > 0)
				{
			        var datos = { idProvincia : $(this).val()   };
					
			        $.post("views/Partidos.php", datos, function(partidos) {
					  	var $combopartido = $("#partido");
		                $combopartido.empty();
						$combopartido.append("<option value='0'>Partido</option>");
		                $.each(partidos, function(index, partido) {
	                        $combopartido.append("<option value=" + partido.id + ">" + partido.nombre + "</option>");
		                   });
					}, 'json');
				}
				else
				{
					
					var $combopartido = $("#partido");
					$combopartido.empty() ;
					$combopartido.append("<option value ='0'>Partido</option>");
				}
			});			
}
		
		) 
;
</script>

<script type="text/javascript">
$(document).ready(function() 
{
$("#partido").change(function() {
 
	var partido = $(this).val();
				if(partido > 0)
				{
			        var datos = { idPartido : $(this).val()   };
			        $.post("views/Localidades.php", datos, function(localidades) {
					  	var $combolocalidad = $("#localidad");
		                $combolocalidad.empty();
						$combolocalidad.append("<option value='0'>Localidad</option>");
		                $.each(localidades, function(index, localidad) {
	                        $combolocalidad.append("<option value=" + localidad.id + ">" + localidad.nombre + "</option>");
		                   });
					}, 'json');
				}
				else
				{
					
					var $combolocalidad = $("#localidad");
					$combolocalidad.empty() ;
					$combolocalidad.append("<option value ='0'>Localidad</option>");
				}
			});
} ) ;			
</script>

<!--Funcion Toogle para Item Edificacion-->
<script type="text/javascript">
$(document).ready(function(){
	$('#itemsEdificacion').click(function() {
	    $('.itemsEdificacion').slideToggle('slow');
		return false;
	});
});
</script>

<!--Funcion Toogle para Item Moneda-->
<script type="text/javascript">
$(document).ready(function(){
	$('#itemsMoneda').click(function() {
	    $('.itemsMoneda').slideToggle('slow');
		return false;
	});
});
</script>

<!--Funcion Toogle para Item Localidad-->
<script type="text/javascript">
$(document).ready(function(){
	$('#itemsLocalidad').click(function() {
	    $('.itemsLocalidad').slideToggle('slow');
		return false;
	});
});
</script>

<!--Funcion Toogle para Item Operacion-->
<script type="text/javascript">
$(document).ready(function(){
	$('#itemsOperacion').click(function() {
	    $('.itemsOperacion').slideToggle('slow');
		return false;
	});
});
</script>

<!--Funcion Galeria-->
<script type="text/javascript">
$(document).ready(function() {
    $('#imageGallery').lightSlider({
	    gallery:true,
	    animateThumb:true,
	    item:1,
	    thumbItem:5,
		thumbMargin:2,
	    slideMargin:0,
	    currentPagerPosition:'left',
	    onSliderLoad: function(plugin) {
	    plugin.lightGallery();
	    }
    });
});
</script>

<!--Funcion Zoom-->
<script type="text/javascript">
jQuery(function(){
	$(".my-foto").imagezoomsl({  
		zoomrange: [1, 1],
		magnifiersize: [400, 400],
		magnifiereffectanimate: "fadeIn",
        magnifierborder: "none"
	});
});   
</script>

<?php
$page=basename($_SERVER['PHP_SELF']);
			if ($page=='DetailController.php') {
?>
<!--Funcion Toogle para Opciones en Detalle de Aviso-->
<script type="text/javascript">
$(document).ready(function() {
	$('a').on('click', function(){
	   var target = $(this).attr('data-rel');
	   $("#"+target).show().siblings("div").hide();
	});
});
</script>
<?php
};
?>

<!--Validar INPUT en Solicitud de Asesor-->
<script type="text/javascript">
	$(document).ready(function() {
		var msg="";
		var elements = document.getElementsByTagName("INPUT");
		for (var i = 0; i < elements.length; i++) {
			elements[i].oninvalid = function(e) {
				e.target.setCustomValidity("");

				switch(e.target.id){
					case "name" :
					msg="Ingresar su nombre";
					break;
					case "email" :
					msg="Ingresar su email";
					break;
					case "subject" :
					msg="Ingresar el asunto";
					break;
					case "message" :
					msg="Ingresar el mensaje";
					break;
				}

				if (!e.target.validity.valid) {
					e.target.setCustomValidity(msg);
				}
				
			};
			elements[i].oninput = function(e) {
				e.target.setCustomValidity("");
			};
		} 
	})
</script>

<!--Validar TEXTAREA en Solicitud de Asesor-->
<script type="text/javascript">
	$(document).ready(function() {
		var msg="";
		var elements = document.getElementsByTagName("TEXTAREA");
		for (var i = 0; i < elements.length; i++) {
			elements[i].oninvalid = function(e) {
				e.target.setCustomValidity("");

				switch(e.target.id){
					case "message" :
					msg="Ingresar el mensaje";
					break;
				}

				if (!e.target.validity.valid) {
					e.target.setCustomValidity(msg);
				}
				
			};
			elements[i].oninput = function(e) {
				e.target.setCustomValidity("");
			};
		} 
	})
</script>

<!--Validar Login-->
<?php
$page=basename($_SERVER['PHP_SELF']);
			if ($page=='login.php' || $page=='loginUser.php') {
?>
<script type="text/javascript">
function CheckForm(frmLogin) {

	if (document.forms.frmLogin.username.value == '')
	{
		alertify.error('Debe completar el nombre de usuario.');
		document.forms.frmLogin.username.focus();
		return false;
	}

	if (document.forms.frmLogin.username.value.length < 5)
	{
		alertify.error('.El usuario debe contener mas de 5 caracteres.');
		document.forms.frmLogin.username.focus();
		return false;
	}
	
		if (document.forms.frmLogin.password.value == '')
	{
		alertify.error('Debe ingresar la clave de acceso.');
		document.forms.frmLogin.password.focus();
		return false;
	}

	if (document.forms.frmLogin.password.value.length < 8)
	{
		alertify.error('La clave debe contener al menos 8 caracteres.');
		document.forms.frmLogin.password.focus();
		return false;
	}
}
</script>
<?php
};
?>

<!--Validar Reset de Clave-->
<?php
$page=basename($_SERVER['PHP_SELF']);
			if ($page=='reset.php' || $page=='resetearMail.php') {
?>
<script type="text/javascript">
function CheckForm(frmReset) {

	if (document.forms.frmReset.username.value == '')
	{
		alertify.error('Debe completar el nombre de usuario.');
		document.forms.frmReset.username.focus();
		return false;
	}

	if (document.forms.frmReset.username.value.length < 5)
	{
		alertify.error('El usuario debe contener mas de 5 caracteres.');
		document.forms.frmReset.username.focus();
		return false;
	}
	
	if (document.forms.frmReset.email.value == '')
	{
		alertify.error('Debe completar el campo Email.');
		document.forms.frmReset.email.focus();
		return false;
	}

	if (document.forms.frmReset.email.value.indexOf("@") < 1)
	{
		alertify.error('Dirección de email no válida.');
		document.forms.frmReset.email.focus();
		return false;
	}

	if (document.forms.frmReset.email.value.indexOf(".") < 1)
	{
		alertify.error('Dirección de email no válida.');
		document.forms.frmReset.email.focus();
		return false;
	}
}
</script>
<?php
};
?>

<!--Validar Registro de Usuario-->
<?php
$page=basename($_SERVER['PHP_SELF']);
			if ($page=='register.php') {
?>
<script type="text/javascript">
function CheckForm(frmRegister) {

	if (document.forms.frmRegister.username.value == '')
	{
		alertify.error('Debe completar el nombre de usuario.');
		document.forms.frmRegister.username.focus();
		return false;
	}

	if (document.forms.frmRegister.username.value.length < 5)
	{
		alertify.error('El usuario debe contener más de 5 caracteres.');
		document.forms.frmRegister.username.focus();
		return false;
	}
	
	if (document.forms.frmRegister.password.value == '')
	{
		alertify.error('Debe ingresar una clave para el usuario.');
		document.forms.frmRegister.password.focus();
		return false;
	}

	if (document.forms.frmRegister.password.value.length < 8)
	{
		alertify.error('La clave debe contener al menos 8 caracteres.');
		document.forms.frmRegister.password.focus();
		return false;
	}
	
	if (document.forms.frmRegister.razonsocial.value == '')
	{
		alertify.error('Debe completar el campo Razon Social.');
		document.forms.frmRegister.razonsocial.focus();
		return false;
	}
	
	if (document.forms.frmRegister.cuit.value !== '')
	{
		if (isNaN(document.forms.frmRegister.cuit.value) === true)
		{
			alertify.error('El campo CUIT es numérico.');
			document.forms.frmRegister.cuit.focus();
			return false;
		}
		
		if (document.forms.frmRegister.cuit.value.length < 9)
		{
			alertify.error('El número de CUIT debe contener al menos 9 caracteres.');
			document.forms.frmRegister.cuit.focus();
			return false;
		}
	}
	
	if (document.forms.frmRegister.asesor.value == '')
	{
		alertify.error('Debe ingresar el nombre de un asesor comercial.');
		document.forms.frmRegister.asesor.focus();
		return false;
	}
	
	if (document.forms.frmRegister.codigo.value == '')
	{
		alertify.error('Debe completar el código de área.');
		document.forms.frmRegister.codigo.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmRegister.codigo.value) === true)
	{
		alertify.error('El campo Código de área es numérico.');
		document.forms.frmRegister.codigo.focus();
		return false;
	}
	
	if (document.forms.frmRegister.telefono.value == '')
	{
		alertify.error('Debe completar el número telefónico.');
		document.forms.frmRegister.telefono.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmRegister.telefono.value) === true)
	{
		alertify.error('El campo Teléfono es numérico.');
		document.forms.frmRegister.telefono.focus();
		return false;
	}
	
	if (document.forms.frmRegister.email.value == '')
	{
		alertify.error('Debe completar el campo Email.');
		document.forms.frmRegister.email.focus();
		return false;
	}

	if (document.forms.frmRegister.email.value.indexOf("@") < 1)
	{
		alertify.error('Dirección de email no válida.');
		document.forms.frmRegister.email.focus();
		return false;
	}

	if (document.forms.frmRegister.email.value.indexOf(".") < 1)
	{
		alertify.error('Dirección de email no válida.');
		document.forms.frmRegister.email.focus();
		return false;
	}
	
	if (document.forms.frmRegister.provincia.value == 0)
	{
		alertify.error('Debe seleccionar una provincia.');
		document.forms.frmRegister.provincia.focus();
		return false;
	}
	
	if (document.forms.frmRegister.partido.value == 0)
	{
		alertify.error('Debe seleccionar un partido.');
		document.forms.frmRegister.partido.focus();
		return false;
	}
	
	if (document.forms.frmRegister.localidad.value == 0)
	{
		alertify.error('Debe seleccionar una localidad.');
		document.forms.frmRegister.localidad.focus();
		return false;
	}
	
	if (document.forms.frmRegister.calle.value == '')
	{
		alertify.error('Debe ingresar la calle.');
		document.forms.frmRegister.calle.focus();
		return false;
	}
	
	if (document.forms.frmRegister.altura.value == '')
	{
		alertify.error('Debe ingresar la altura.');
		document.forms.frmRegister.altura.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmRegister.altura.value) === true)
	{
		alertify.error('El campo altura es numérico.');
		document.forms.frmRegister.altura.focus();
		return false;
	}
}
</script>
<?php
};
?>

<!--Validar Update de Usuario-->
<?php
$page=basename($_SERVER['PHP_SELF']);
			if ($page=='profile.php') {
?>
<script type="text/javascript">
function CheckForm(frmUpdateProfile) {

		if (document.forms.frmUpdateProfile.razonsocial.value == '')
	{
		alertify.error('Debe completar el campo Razon Social.');
		document.forms.frmUpdateProfile.razonsocial.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.cuit.value == '')
	{
		alertify.error('Debe ingresar su numero de CUIT.');
		document.forms.frmUpdateProfile.cuit.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmUpdateProfile.cuit.value) === true)
	{
		alertify.error('El campo CUIT es numérico.');
		document.forms.frmUpdateProfile.cuit.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.cuit.value.length < 9)
	{
		alertify.error('El campo CUIT debe contener al menos 9 caracteres.');
		document.forms.frmUpdateProfile.cuit.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.asesor.value == '')
	{
		alertify.error('Debe ingresar el nombre de un asesor comercial.');
		document.forms.frmUpdateProfile.asesor.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.codigo.value == '')
	{
		alertify.error('Debe completar el código de área.');
		document.forms.frmUpdateProfile.codigo.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmUpdateProfile.codigo.value) === true)
	{
		alertify.error('El campo Código de área es numérico.');
		document.forms.frmUpdateProfile.codigo.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.telefono.value == '')
	{
		alertify.error('Debe completar el número telefónico.');
		document.forms.frmUpdateProfile.telefono.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmUpdateProfile.telefono.value) === true)
	{
		alertify.error('El campo Teléfono es numérico.');
		document.forms.frmUpdateProfile.telefono.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.email.value == '')
	{
		alertify.error('Debe completar el campo Email.');
		document.forms.frmUpdateProfile.email.focus();
		return false;
	}

	if (document.forms.frmUpdateProfile.email.value.indexOf("@") < 1)
	{
		alertify.error('Dirección de email no válida.');
		document.forms.frmUpdateProfile.email.focus();
		return false;
	}

	if (document.forms.frmUpdateProfile.email.value.indexOf(".") < 1)
	{
		alertify.error('Dirección de email no válida.');
		document.forms.frmUpdateProfile.email.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.provincia.value == 0)
	{
		alertify.error('Debe seleccionar una provincia.');
		document.forms.frmUpdateProfile.provincia.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.partido.value == 0)
	{
		alertify.error('Debe seleccionar un partido.');
		document.forms.frmUpdateProfile.partido.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.localidad.value == 0)
	{
		alertify.error('Debe seleccionar una localidad.');
		document.forms.frmUpdateProfile.localidad.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.calle.value == '')
	{
		alertify.error('Debe ingresar la calle.');
		document.forms.frmUpdateProfile.calle.focus();
		return false;
	}
	
	if (document.forms.frmUpdateProfile.altura.value == '')
	{
		alertify.error('Debe ingresar la altura.');
		document.forms.frmUpdateProfile.altura.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmUpdateProfile.altura.value) === true)
	{
		alertify.error('El campo altura es numérico.');
		document.forms.frmUpdateProfile.altura.focus();
		return false;
	}
}
</script>
<?php
};
?>

<!--Validar Carga de Aviso-->
<?php
$page=basename($_SERVER['PHP_SELF']);
			if ($page=='publish.php' || $page=='editAd.php') {
?>
<script type="text/javascript">
function CheckForm(frmPublish) {

		if (document.forms.frmPublish.tipoinmueble.value == 0)
	{
		alertify.error('Debe indicar el tipo de inmueble.');
		document.forms.frmPublish.tipoinmueble.focus();
		return false;
	}
	
	if (document.forms.frmPublish.operacion.value == 0)
	{
		alertify.error('Debe indicar el tipo de operación.');
		document.forms.frmPublish.operacion.focus();
		return false;
	}
		
	if (document.forms.frmPublish.provincia.value == 0)
	{
		alertify.error('Debe indicar la provincia.');
		document.forms.frmPublish.provincia.focus();
		return false;
	}
	
	if (document.forms.frmPublish.partido.value == 0)
	{
		alertify.error('Debe indicar el partido.');
		document.forms.frmPublish.partido.focus();
		return false;
	}
	
	if (document.forms.frmPublish.localidad.value == 0)
	{
		alertify.error('Debe indicar la localidad.');
		document.forms.frmPublish.localidad.focus();
		return false;
	}
	
	if (document.forms.frmPublish.calle.value == '')
	{
		alertify.error('Debe ingresar la calle.');
		document.forms.frmPublish.calle.focus();
		return false;
	}
	
	if (document.forms.frmPublish.altura.value == '')
	{
		alertify.error('Debe ingresar la altura.');
		document.forms.frmPublish.altura.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.altura.value) === true)
	{
		alertify.error('El campo altura es numérico.');
		document.forms.frmPublish.altura.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.suptotal.value) === true)
	{
		alertify.error('El campo superficie total es numérico.');
		document.forms.frmPublish.subtotal.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.ambientes.value) === true)
	{
		alertify.error('El campo ambientes es numérico.');
		document.forms.frmPublish.ambientes.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.dormitorios.value) === true)
	{
		alertify.error('El campo dormitorios es numérico.');
		document.forms.frmPublish.dormitorios.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.banos.value) === true)
	{
		alertify.error('El campo baños es numérico.');
		document.forms.frmPublish.banos.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.toilette.value) === true)
	{
		alertify.error('El campo toilettes es numérico.');
		document.forms.frmPublish.toilette.focus();
		return false;
	}
	
	if (isNaN(document.forms.frmPublish.antiguedad.value) === true)
	{
		alertify.error('El campo antiguedad es numérico.');
		document.forms.frmPublish.antiguedad.focus();
		return false;
	}
}
</script>
<?php
};
?>

<style type="text/css">
ul{
	list-style: none outside none;
	padding-left: 0;
}
.content-slider li{
	background-color: #DDDDDD;
	text-align: center;
	color: #555555;
	font-family:Verdana, Geneva, Tahoma, sans-serif;
}
.content-slider h1 {
	width:100%;
	text-align:center;
	margin: 0;
	padding-top:10px;
	font-size:10px;
}
.content-slider h1 img {
	vertical-align:middle;
	border-radius:2px;
	border:10px;
	border-color:white;
	max-height:86px;
	max-width:200px;
}	
.content-slider h2 {
	padding-top:10px;
	margin: 0;
	text-align:center;
	font-size:10px;
	font-weight:bold;
}
.content-slider h3 {
	padding-top:5px;
	margin: 0;
	padding:0;
	text-align:center;
	font-size:11px;
	font-weight:normal;
}
.content-slider h4 {
	padding-top:5px;
	margin: 0;
	padding:0;
	text-align:center;
	font-size:10px;
	font-weight:normal;
}
.content-slider h5 {
	padding-top:5px;
	margin: 0;
	padding:0;
	font-size:11px;
	font-weight:bold;
	text-align:center;
}
.content-slider h6 {
	margin:0px;
	padding:0px;
}
.content-slider h6 a {
	background: linear-gradient(to bottom, #AAC2D2 0%, #5988A8 100%) repeat scroll 0% 0% transparent;
	border-radius: 8px;
	border: medium none;
	box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.5), 2px 2px 1px rgba(0, 0, 0, 0.1), 0px 1px 0px rgba(255, 255, 255, 0.2) inset;
	color: white;
	cursor: pointer;
	font-size: 12px;
	padding: 5px 15px;
	text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.4);
	font-family: "Open Sans",sans-serif;
	font-weight: 300;
    font-style: normal;
	font-size:12px;
	text-decoration:none;
}
.demo{
	width: 900px;
	text-align:center;
}
.galeria {
	width:450px;
	display:inline-block;
	vertical-align:top;
}
</style>

</head>
