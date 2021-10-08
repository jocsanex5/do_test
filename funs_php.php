<?php

session_start();

	$cantReg = 0;

	/*
		crear nueva clase
	*/

	function nuevaClase($conn)
	{
		if(isset($_GET['siguiente'])){

			$id = uniqid();
			$tema = $_GET['temaCls'];
			$fecha = $_GET['fechaCls'];
			$des = $_GET['descls'];

			$aggDatos = "INSERT INTO `clases` (`id`, `tema`, `fecha`, `descripcion`) VALUES ('$id', '$tema', '$fecha', '$des');";
			$consulDatos = mysqli_query($conn, $aggDatos);

			if($consulDatos){

				$consulta_new_tab = " 
					CREATE TABLE `$id`(
						cod_imagen INT PRIMARY KEY AUTO_INCREMENT,
						imagen VARCHAR(50)
					)
				";

				$resultado_new_tab = mysqli_query($conn, $consulta_new_tab);

				?>
					<script>evidenciasIMG();</script>;
				<?php

				$_SESSION['id_sub_im'] = $id;
			
			} else{

				echo 'no';
			}
		}
	}

	function db_img($name_input, $conn)
	{
		$imagen = $_FILES[$name_input]['name'];

		if (isset($imagen) && $imagen != "") {

			$id = $_SESSION['id_sub_im'];
			$tipo = $_FILES[$name_input]['type'];
			$temp = $_FILES[$name_input]['tmp_name'];
				
			$subirFoto = "INSERT INTO `$id`(imagen) VALUES ('$imagen')";
			$consulFoto = mysqli_query($conn, $subirFoto);

			if($consulFoto){

				move_uploaded_file($temp, 'recursos/evidencias/' . $imagen);
				$id_sub_im = null;
			
			} else{

				echo "ERR-IM_DB";
			}
		}
	}

	function subirEvidens($conn)
	{ 
		if (isset($_POST['enviarEvi'])) { 
			
			db_img('evi1', $conn);
			db_img('evi2', $conn);
			db_img('evi3', $conn);

			?>
				<script>cargar();</script>;
			<?php
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

		$img = "SELECT imagen FROM `$id`";
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

			//de la tabla clases

			$id_clase = $_GET['class-id-select'];	

			$elimnClass = "DELETE FROM clases WHERE clases . id = '$id_clase'";
			$consultaElimn = mysqli_query($conn, $elimnClass);

			//borrar fotos del servidor

				$borrarFotosDel_S = "SELECT imagen FROM `$id_clase`";
				$consultaBorrarFoto_S = mysqli_query($conn, $borrarFotosDel_S);

				while($imagenes[] = mysqli_fetch_array($consultaBorrarFoto_S));

			foreach ($imagenes as $key) {

				if ($key != '') {

					unlink('recursos/evidencias/' . $key['imagen']); //borrar del directorio..
				}
			}

			if($consultaElimn && $consultaBorrarFoto_S){

				$elimnTablaClass = "DROP TABLE `$id_clase`";
				$consultaElimTablaClass = mysqli_query($conn, $elimnTablaClass);

				if($consultaElimTablaClass){

					?>
						<script>cargar();</script>;
					<?php
				}
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

				?>
					<script>cargar();</script>;
				<?php
			}
		}
	}