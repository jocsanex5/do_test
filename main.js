/*
	js 

	by Jx5
	________________________
*/

//globales()


let agregar = document.getElementById('agregar'),
	creador = document.getElementById('creador'),
	inicio = document.getElementById('inicio');

let content_ini = document.getElementById('content-ini'),
	content_agg = document.getElementById('content-agg'),
	content_creador = document.getElementById('content-creador');


//funs()


const agregarinforclase = () =>{

	agregar.addEventListener('click', ()=>{

		creador.classList.remove('active');
		inicio.classList.remove('active');
		agregar.classList.add('active');

		content_ini.classList.add('d-none');
		content_agg.classList.remove('d-none');
		content_creador.classList.add('d-none');
	})
}

const irinicio = () =>{

	inicio.addEventListener('click', ()=>{

		creador.classList.remove('active');
		agregar.classList.remove('active');
		inicio.classList.add('active');

		content_ini.classList.remove('d-none');
		content_agg.classList.add('d-none');
		content_creador.classList.add('d-none');
	})
}

const irACreador = () =>{

	creador.addEventListener('click', ()=>{

		agregar.classList.remove('active');
		inicio.classList.remove('active');
		creador.classList.add('active');

		content_ini.classList.add('d-none');
		content_agg.classList.add('d-none');
		content_creador.classList.remove('d-none');
	})
}

const evidenciasIMG = () =>{

	let btnSubir = document.getElementById('btnSubir')
		f0rm_subir_evi = document.querySelector('.f0rm-subir-evi');

	f0rm_subir_evi.classList.toggle('d-none');	

	btnSubir.addEventListener('submit', ()=>{

		f0rm_subir_evi.classList.toggle('d-none');	
	})
}

const cargar = () =>{

	window.location = 'index.php';
}

const opcdeclases = () =>{

	let clases = document.querySelectorAll('.conten-class');

	clases.forEach((clase)=>{

		clase.addEventListener('click', ()=>{

			Swal.fire({

				html : `
					<button id="btn-elimnar" class="w-50 p-1 mt-3 d-block ms-auto me-auto bg-transparent border-2 border-top-0 border-start-0 border-end-0">
						<h2 class="fs-4">Eliminar</h2>
					</button>

					<button id="btn-modificar" class="w-50 p-1 mt-5 d-block ms-auto me-auto bg-transparent border-2 border-top-0 border-start-0 border-end-0">
						<h2 class="fs-4">Modificar</h2>
					</button>
				`,
				showCloseButton : true,
				showConfirmButton : false
			})

			document.getElementById('btn-elimnar').addEventListener('click', ()=>{

				Swal.fire({

					html: `
						<h3 class="fs-4">Estas seguro que quieres elimanar esta clase?</h3>
						<form action="index.php" method="get">
						<input type="text" class="d-none" id="class-id-select" name="class-id-select" value="">
							<button type="submit" name="elimn-class" id="btnSubir" class="mt-3 btn btn-primary p-3 w-50 w-lg-25">Confirmar</button>
						</form>
					`,
					showCloseButton : true,
					showConfirmButton: false,
				})

				document.getElementById('class-id-select').value = clase.id;
			})

			document.getElementById('btn-modificar').addEventListener('click', ()=>{

				Swal.fire({

					title : 'Modificar clase',
					html: `
						<form id="form-modif-class" class="m-auto" method="get" action="index.php">
							<div class="mb-3">
								<input type="text" class="d-none" id="class-id-select" name="id_modif" value="">
								<label class="form-label text-secondary">Tema de la clase</label>
								<input type="text" id="nombre-clase" class="form-control border-2 border-top-0 border-start-0 border-end-0" name="temaCls_modif" required="">
							</div>

							<div class="mb-3">
								<label class="form-label text-secondary">fecha</label>
								<input type="date" name="fechaCls_modif" class="form-control border-2 border-top-0 border-start-0 border-end-0" required="">
							</div>

							<div class="mb-3">
								<label class="form-label text-secondary">Description</label>
								<textarea  class="form-control" name="descls_modif" id="desClass" cols="30" rows="10" required=""></textarea>
							</div>

							<button type="submit" name="s_modif_class" id="btnSubir" class="btn btn-primary p-3 w-50 w-lg-25">continuar</button>
						</form>
					`,
					showCloseButton : true,
					showConfirmButton: false,
				})	

				document.getElementById('form-modif-class').temaCls_modif.value = clase.children[0].children[0].textContent;
				document.getElementById('form-modif-class').descls_modif.value = clase.children[2].children[0].textContent;
				document.getElementById('form-modif-class').fechaCls_modif.value = clase.title;
				document.getElementById('class-id-select').value = clase.id;
			})
		})
	})
}

window.addEventListener('load', ()=>{

	document.getElementById('loader').classList.add('d-none');
})

//ejects()

agregarinforclase();
irinicio();
opcdeclases();
irACreador();