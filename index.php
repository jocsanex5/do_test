<?php  

	// by jX5

	include_once('conexion.php');
	include_once('funs_php.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Test Form By Jx5</title>
	<link rel="shortcut icon" href="recursos/favicon.png" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet"> 
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
	<meta name="theme-color" content="#005243ab">
	<link rel="stylesheet" href="estilosPersonalizados.css">
</head>
<body>
	<div id="loader" class="loader w-100 h-100 position-fixed top-0 start-0">
		<div class="content">
			<div class="cssload-container">
				<ul class="cssload-flex-container">
					<li>
						<span class="cssload-loading cssload-one"></span>
						<span class="cssload-loading cssload-two"></span>
						<span class="cssload-loading-center"></span>
					</li>
				</div>
			</div>	
		</div>
	</div>

	<div class="wrapper">
		<div class="container mt-3 w-100 h-100">
			<div class="container-fluit">
				<ul class="nav nav-tabs">
					<li class="nav-item">
			    		<a class="nav-link text-dark active" id="inicio" aria-current="page" href="#">Inicio</a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link text-dark" id="agregar" aria-current="page" href="#">Agregar</a>
					</li>

					<li class="nav-item">
				    	<a class="nav-link text-dark" id="creador" href="#">Creador</a>
					</li>
				</ul>
			</div>

			<div id="c0ntent" class="container-fluit p-3 w-100 h-100 bg-white" id="content">
				<div id="content-ini" class="mt-5 v">
					<?php if(cantDeClases($conn, 'cant') == 1): ?>

						<h1>No hay registros <span class="badge">FT</span></h1>

						<p class="mt-3">
							Aqui se visializaran las clases impartidas. Agrega datos a la
							app..
						</p>

					<?php else: 

						foreach (cantDeClases($conn, 'arr') as $key) {

							if($key != ''){
								?>
									<div id="<?=$key['id']?>" class="mb-5 conten-class d-flex flex-column w-100 p-3 text-center" title="<?=$key['fecha'];?>">
										<div class="tema-class">
											<h2 class="fs-1"><?=$key['tema']?></h2>
										</div>

										<div class="id-class">
											<span class="d-block fs-6 text-muted fst-italic">Clase <?=$key['id']?></span>
										</div>

										<div class="descript-class m-3">
											<p class="fs-5"><?=$key['descripcion']?></p>
										</div>

										<div class="evis">
											<?php 
												foreach ($generarEvidencias($key['id'], $conn) as $key) {
								
													if($key['imagen'] != ''){
														?>
															<img class="m-2" src="recursos/evidencias/<?=$key['imagen']?>" width="300px" alt="">
														<?php
													}
												}
											?>
										</div>
									</div>
								<?php
							}		
						}
					?>

					<?php endif?>
				</div>

				<div id="content-agg" class="d-none v">
					<form class="m-auto" method="get" action="index.php">
						<div class="mb-3">
							<label class="form-label text-secondary">Tema de la clase</label>
							<input type="text" class="form-control border-2 border-top-0 border-start-0 border-end-0" name="temaCls" required="">
						</div>

						<div class="mb-3">
							<label class="form-label text-secondary">fecha</label>
							<input type="date" name="fechaCls" value="2021-07-28" class="form-control border-2 border-top-0 border-start-0 border-end-0" required="">
						</div>

						<div class="mb-3">
							<label class="form-label text-secondary">Description</label>
							<textarea  class="form-control" name="descls" id="desClass" cols="30" rows="10" required=""></textarea>
						</div>

						<button type="submit" name="siguiente" id="btnSubir" class="btn btn-primary p-3 w-50 w-lg-25">Siguiente</button>
					</form>
				</div>

				<div id="content-creador" class="d-none v w-100">
					<div>
						<img class="d-block m-auto logo" src="recursos/logo.png" width="500px" alt="">
					</div>

					<div class="w-100 bg-secondary p-4 rounded-top">
						<h2 class="m-4 ms-auto me-auto d-block">Por Jx5</h2>

						<p class="text-white">
							Para ver mas proyectos, visita mi perfil de gitHub
						</p>

						<div class="redes ms-auto me-auto">
							<img class="m-4 img-redes" src="recursos/facebook.png" width="60px" alt="">
							<img class="m-4 img-redes" src="recursos/instagram.png" width="60px" alt="">
							<a href="mailto:jocsanex5@gmail.com?Subject=Envia%20tu%20pregunta%20o%20comentario!!!">
								<img class="m-4 img-redes" src="recursos/gmail.png" width="60px" alt="">
							</a>

							<a href="https://github.com/jocsanex5">
								<img class="m-4 img-redes" src="recursos/github.png" width="60px" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="container f0rm-subir-evi d-none">
				<form method="POST" action="index.php" enctype="multipart/form-data">
					<div>
						<h2 class="m-3">Evidencias de clase</h2>
					</div> 

				 	<div class="mb-3">
						<label for="formFile" class="form-label">Evi1</label>
						<input class="form-control bg-white" name="evi1" type="file" id="formFile1" required="">
					</div>

					<div class="mb-3">
						<label for="formFile" class="form-label">Evi2</label>
						<input class="form-control" name="evi2" type="file" id="formFile2" required="">
					</div>

					<div class="mb-3">
						<label for="formFile" class="form-label">Evi3</label>
						<input class="form-control" name="evi3" type="file" id="formFile3" required="">
					</div>

					<button type="submit" name="enviarEvi" id="btnSubir" class="btn btn-primary p-3 w-50">Subir evidencias</button>
				 </form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="main.js"></script>

	<?php 

		nuevaClase($conn); 
		subirEvidens($conn);
		elimnClass($conn);
		modificarClass($conn);

	?>
</body>
</html>