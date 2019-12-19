<?php 
include('../lib/nusoap/lib/nusoap.php');
include("../include/cnn.phtml");
//$link=Conectarse();
include("../include/f_producto.php");
include("../include/f_ingreso.php");
include("../include/f_ingresonea.php");
include("../include/f_pecosa.php");
include("../include/f_maealmac.php");

$server = new soap_server; 
$server->configureWSDL('wsMonitoreo', 'urn:wsMonitoreo'); 
$server->wsdl->schemaTargetNamespace='urn:wsMonitoreo';


function doAuthenticate(){    
	
	if(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']) ):
		if($_SERVER['PHP_AUTH_USER']=="userafis@ludpol" && $_SERVER['PHP_AUTH_PW']=="WS@ludPol@fi" ):
			return true;
		else:
	   		return false;
		endif;
	endif;
}

$server->register('ObtenerStockProducto', 
	array('prodcodigo'=>'xsd:string','ano'=>'xsd:string'),
	array('return' => 'xsd:string'),'urn:wsMonitoreo','urn:wsMonitoreo#GrabarPedido','rpc','encoded','ws para Consultar Stock del Producto');

function ObtenerStockProducto($prodcodigo,$ano)
{ 
	if(doAuthenticate()):
		$codproducto = F_MUESTRA_ID_PRODUCTO($prodcodigo);
		$FECHAHASTA="";
		$CANTIDADINICIAL = F_MUESTRA_DATO_ALMACEN_2("CANTIDADINICIAL",$ano,$codproducto);
		$TOTALINGRESO = F_CANTIDAD_INGRESADA_DET_X_PRODUCTO($ano,$codproducto,1,$FECHAHASTA);
		$TOTALINGRESONEA = F_CANTIDAD_INGRESADA_NEA_DET_X_PRODUCTO($ano,$codproducto,1,$FECHAHASTA);
		$INGRESOS = $TOTALINGRESO + $TOTALINGRESONEA;
		$cantidadentregada2 = F_CANTIDAD_ATENDIDA_PECOSAS_X_PRODUCTO($ano,$codproducto,1,2,$FECHAHASTA);
		$MAECANTSTK = $CANTIDADINICIAL + $INGRESOS - $cantidadentregada2;
		
		return $MAECANTSTK;
	
	endif;
	
} 


// Use the request to (try to) invoke the service
//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA); 

// Use the request to (try to) invoke the service
if (isset($HTTP_RAW_POST_DATA))
{
    $input = $HTTP_RAW_POST_DATA;
}
else
{
    $input = implode("\r\n", file('php://input'));
}
$server->service($input);



?>
