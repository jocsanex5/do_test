<?php

include_once('php/vendor/autoload.php');

//requerimientos de la API de google drive

putenv('GOOGLE_APPLICATION_CREDENTIALS=dotes-db-11bb4295a5ea.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive.file']);

session_start();

	/* esta funcion genera el formualrio de ingreso de usuario */

	function mostrarFormIngreso()
	{
		?><script>usuario();</script>;<?php
	}

	function recargarPagina()
	{
		?><script>cargar();</script>;<?php
	}

	/*
		crear nueva clase
	*/

	function nuevaClase($conn)
	{
		if(isset($_GET['siguiente'])){

			$_SESSION['id_sub_im'] = array(

				'id' => uniqid(),
				'tema' => $_GET['temaCls'],
				'fecha' => $_GET['fechaCls'],
				'descripcion' => $_GET['descls']
			);

			?><script>evidenciasIMG();</script><?php
		}
	}

	function subirEvidens($conn, $client)
	{ 
		if (isset($_POST['enviarEvi'])) { 

				//cantidad de evidencias cargadas
			$countfiles = count($_FILES['file']['name']);

				//datos de la clase
			$id_clase = $_SESSION['id_sub_im']['id'];
			$tema = $_SESSION['id_sub_im']['tema'];
			$fecha = $_SESSION['id_sub_im']['fecha'];
			$des = $_SESSION['id_sub_im']['descripcion'];

			/*
				subir datos de clase a MYSQL
				______________________________
			*/

			$aggDatos = "INSERT INTO `clases` (`id`, `tema`, `fecha`, `descripcion`) VALUES ('$id_clase', '$tema', '$fecha', '$des');";
			$consulDatos = mysqli_query($conn, $aggDatos);

			if($consulDatos){

				$consulaCrearTablaEvis = "

					CREATE TABLE `$id_clase`(

					idimage INT(60) PRIMARY KEY auto_increment,
					nombre VARCHAR(200) NOT NULL
				)";

				$resultadoCrearTabla = mysqli_query($conn, $consulaCrearTablaEvis);

				if($resultadoCrearTabla){ echo "jdf";

					/*
						Subir fotos al drive mediante la API de Gooogle...
						__________________________________________________
					*/

					for ($i=0; $i < $countfiles; $i++){

						$nombre = $_FILES['file']['name'][$i];
						$tmp = $_FILES['file']['tmp_name'][$i];
						$type = $_FILES['file']['type'][$i];

						try{

							// subir imagen a drive

							$service = new Google_Service_DriVe($client);
							$file_path = $tmp;

							$file = new Google_Service_Drive_DriveFile();
							$file->setName($nombre);
							$file->setParents(array('1ovWZupoB2D3_UGNke8NHvW8wIfZlvqbh'));
							$file->setDescription('EvidenciaClass');
							$file->setmimeType($type);

							$resultado = $service->files->create(

								$file,
								array(
									'data' => file_get_contents($file_path),
									'mimeType' => $type,
									'uploadType' => 'media' 					
								)
							);

							// subir datos de la imagen a msql

							$consultaImg = "INSERT INTO `$id_clase`(`nombre`) VALUES ('$resultado->id')";
							$resultadoImg = mysqli_query($conn, $consultaImg);

						} catch(Google_Service_Exception $gs){

							$mensaje = json_decode($gs->getMessage());

							echo $mensaje->error->message();
						
						} catch(Exception $e){

							echo $e->getMessage();
						}
					}

					$_SESSION['id_sub_im'] = ''; // recetear valor...

					recargarPagina();
				}
			}
		}
	}

	//num de clases en la base de datos
	function cantDeClases($conn, $data)
	{
		$dat = "SELECT * FROM clases";
		$consultaDatos = mysqli_query($conn, $dat);

		while($datos[] = mysqli_fetch_array($consultaDatos));

		if ($data == 'arr') {
			
			return $datos;
		
		} elseif($data == 'cant'){

			return count($datos);
		}
	}
	
	//consultar datos de las imagenes...
	$generarEvidencias = function($id, $conn){

		$img = "SELECT nombre FROM `$id`";
		$consultaImg = mysqli_query($conn, $img);

		if($consultaImg){

			while($imgs[] = mysqli_fetch_array($consultaImg));

			return $imgs;
		}
	};

	function elimnClass($conn)
	{
		if(isset($_GET['elimn-class'])){

			//eliminar por completo datos de la base de datos...

			$id_clase = $_GET['class-id-select'];	

			$elimnClass = "DELETE FROM clases WHERE clases . id = '$id_clase'";
			$consultaElimn = mysqli_query($conn, $elimnClass);

			$elimnTabla = "DROP TABLE `$id_clase`";
			$conmsultaElimnTabla = mysqli_query($conn, $elimnTabla);

			if($consultaElimn && $conmsultaElimnTabla){

				recargarPagina();
			}
		}
	}

	function modificarClass($conn)
	{
		
		//modificar clase de la base datos

		if(isset($_GET['s_modif_class'])){

			$tema = $_GET['temaCls_modif'];
			$fecha = $_GET['fechaCls_modif'];
			$descripcion = $_GET['descls_modif'];
			$id_clase = $_GET['id_modif'];

			$modifClase = "UPDATE `clases` SET `tema` = '$tema', `fecha` = '$fecha', `descripcion` = '$descripcion' WHERE `clases` . `id` = '$id_clase'";
			$consultaModifClase = mysqli_query($conn, $modifClase);

			if($consultaModifClase){

				recargarPagina();
			}
		}
	}

	function entrarAlSistema()
	{
		if(isset($_POST['entrar-admin'])){

			if(preg_match("/^j0csAn@dmin521$/", $_POST['cod-entrar'])){

				$_SESSION['acceso'] = 'admin';
				unset($_SESSION['err']);
				header('location: index.php');
			
			} else{

				$_SESSION['err'] = array('TypeErr1' => 'DatInvalidSESS03');
				header('location: index.php');
			}
		
		} elseif(isset($_POST['entrar-visit'])){

			$_SESSION['acceso'] = 'visitante'; 
			unset($_SESSION['err']);
			header('location: index.php');
		} 
	}

	function eventosClases()
	{
		if (isset($_SESSION['acceso'])) {
			
			if($_SESSION['acceso'] == 'admin'){

				?><script>opcdeclases();</script>;<?php
			} 
		
		} else mostrarFormIngreso();

		//errores de de ingreso

		if(isset($_SESSION['err'])){

			?><script>accesoDenegado();</script>;<?php
		}
	}

	function salir()
	{
		if(isset($_POST['salir'])){

			session_unset();
			session_destroy();

			recargarPagina();
		}
	}

	entrarAlSistema();

?>