<?php
	header('Content-type: application/json');
	
    include_once 'api.php';
    
    $api = new Api();
    $error = '';
	
	if(isset($_POST['usuario']) && isset($_POST['clave']) /*&& isset($_POST['tipDoc']) && isset($_POST['nroDoc'])*/){
		
		$datos = array(
			'usuario' => $_POST['usuario'],
			'clave' => $_POST['clave']
		);
		
		if ($api->doAuthenticate($datos)) {
			
			if($_POST['op'] == 'listar'){
			
				$tipDoc = "";
				if($_POST['tipDoc'] == "1")$tipDoc="DNI";
				$item = array(
					'idReceta' 	=> 0,
					'tipDoc' 	=> $tipDoc,
					'nroDoc' 	=> $_POST['nroDoc'],
				);
				
				$api->getRecetaValeByNroDoc($item);	
				
			}elseif($_POST['op'] == 'receta'){
				
				$item = array(
					'idReceta' => $_POST['idReceta'],
					'tipDoc' 	=> '',
					'nroDoc' 	=> '',
				);
				
				$api->getRecetaValeByNroDoc($item);	
				
			}elseif($_POST['op'] == 'productoreceta'){
				
				$item = array(
					'idReceta' => $_POST['idReceta'],
					'nroreceta' => ''
				);
				
				$api->getProductoRecetaVale($item);	
				
			}elseif($_POST['op'] == 'logueo'){
				
				$item = array(
					'dni' => $_POST['usuario_medico'],
					'cmp' => $_POST['cmp']
				);
				$api->getLogueoMedico($item);	
				
			}elseif($_POST['op'] == 'catalogo'){
				
				$item = array(
					//'id_establecimiento' => $_POST['idestablecimiento']
					'dni' => $_POST['usuario_medico']
				);
				
				$api->getCatalogoProducto($item);	
			
			}elseif($_POST['op'] == 'stock_establecimiento'){
				
				$item = array(
					'codigo' => $_POST['codigo']
				);
				
				$api->getStockProductoEstablecimiento($item);	
					
			}elseif($_POST['op'] == 'stock_farmacia'){
				
				$item = array(
					'id_establecimiento' => $_POST['idestablecimiento'],
					'codigo' => $_POST['codigo']
				);
				
				$api->getStockProductoFarmacia($item);	
				
			}elseif($_POST['op'] == 'log'){
				
				$item = array(
					'op' => 'c',
					'dni_medico' => $_POST['dni_medico'],
					'codigo_producto' => $_POST['codigo_producto'],
					'nombre_producto' => $_POST['nombre_producto']
				);
				
				$api->crudLog($item);	
				
			}
		
		}else{
			$api->error('Error al Autentificar');
		}
		
    }else{
        $api->error('Error al llamar a la API');
    }
	
    
?>