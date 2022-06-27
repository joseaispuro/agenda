
const app = Vue.createApp({
	data(){
		return {
			fecha: '',
			fechaLetra: '',
			eventos : {},
			publicado: '',
			opcion: '0',
			tipo: '0'
		}
	},
	mounted(){

		document.getElementById('spinner').style.display = 'flex';

		const urlParams = new URLSearchParams(window.location.search);
		const fecha = urlParams.get('fecha');

		if(fecha){
			this.fecha = fecha;
		}else{
		
		let fecha = new Date();

		let year = fecha.getFullYear();
		let diaLetra = fecha.getDay();

		let mes = (fecha.getMonth() + 1 < 10) ?  '0' + (fecha.getMonth() + 1) : fecha.getMonth() + 1;
		let dia = (fecha.getDate() < 10) ?  '0' + fecha.getDate()  : fecha.getDate();

		fecha = fecha.getFullYear() + '-' + mes  + '-' + dia;


		const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viérnes", "Sábado"];
		const month = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
			"Noviembre", "Diciembre"];

      		let fechaLetra = days[diaLetra] + ' ' + dia + ' de ' + month[mes-1] + ' de ' + year;

      		this.fechaLetra = fechaLetra;
			this.fecha = fecha;
		}

	},
	methods: {
		nuevoEvento: function(){
			window.location = document.getElementsByTagName('meta').namedItem('base-url').content + '/admin/evento?fecha=' + this.fecha;
		},
		mostrar: function(id){
			window.location = document.getElementsByTagName('meta').namedItem('base-url').content + '/admin/evento?id=' + id;
		},
		eliminar: function(id){

			let form = this;

			swal({
				  title: "¿Está seguro?",
				  text: "¿Realmente desea eliminar el evento?",
				  icon: "warning",
				  buttons: true,
				  dangerMode: false,
				})
				.then((willDelete) => {
				  if (willDelete) {
				    //Hacer el request para eliminar el evento
					let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/eliminar-evento';
					 var data = { evento_id : id };

					  fetch(url, {
						  method: 'POST', // or 'PUT',
						  body: JSON.stringify(data),
						  headers:{
					             'Content-Type': 'application/json',
					             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
					         }
					  })
					  .then(response => response.json())
					  .then(data => {

					  	if(data.success){
					  		console.log('ya eliminado');
					  		swal("Excenlente!", data.msg, "success").then((value) => {
  							window.location = document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/?fecha=' + this.fecha;
						});
					  	}
					  	console.log(data);
					  }).catch(function(error) {
					  	console.log('err' + error);	
					  });
				  }
				});

		},
		siguienteDia: function(){
			let day = new Date(this.fecha+'T00:00:00');

			day.setDate(day.getDate()+1);

			let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
			let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate();

			this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;

		},
		imprimir: function(){
			let url = document.getElementsByTagName('meta').namedItem('base-url').content + '/admin/imprimir?fecha=' + this.fecha +'&opcion=' + this.opcion + '&tipo=' + this.tipo ;
			console.log(url)
			window.location =  url;
			
			//window.location = '/imprimir?fecha=' + this.fecha;
		},
		anteriorDia: function(){
			let day = new Date(this.fecha+'T00:00:00');
			day.setDate(day.getDate()-1);

			let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
			let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate() ;

			this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;
		},
		fechaSeleccionada: function(fecha) {

			let mes = (fecha.getMonth() + 1 < 10) ?  '0' + (fecha.getMonth() + 1) : fecha.getMonth() + 1;
			let dia = fecha.getDate();
			//console.log('el dia es ' + dia);
			let year = fecha.getFullYear();
			let diaLetra = fecha.getDay();

			const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viérnes", "Sábado"];
			const month = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
			"Noviembre", "Diciembre"];

      			let fechaLetra = days[diaLetra] + ' ' + dia + ' de ' + month[mes-1] + ' de ' + year;
      		
      			this.fechaLetra = fechaLetra;
      		}
	},
	watch: {
		publicado: function(value){

			/*swal({
				  title: "¿Está seguro?",
				  text: "Desea publicar?",
				  icon: "warning",
				  buttons: true,
				  dangerMode: false,
				})
				.then((willDelete) => {
				  if (willDelete) {
				    console.log('Si cambiar de estado');
				  } else {
				  	console.log('no cambiar de estado');
				  }
				});*/

			this.publicado = (value == 1) ? true : false;

			//Hacer el request para cambiar el estatus a los eventos de ese dia
			let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/update-eventos';
			 var data = { fecha: this.fecha, publicado : this.publicado };

			  fetch(url, {
				  method: 'POST', // or 'PUT',
				  body: JSON.stringify(data),
				  headers:{
			             'Content-Type': 'application/json',
			             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			         }
			  })
			  .then(response => response.json())
			  .then(data => {

			  	//console.log(data);
			  }).catch(function(error) {
			  	console.log('err' + error);	
			  });



		},
		fecha: function(value){

			this.fechaSeleccionada(new Date(value+'T00:00:00'));

			//Obtener eventos
			let form = this;

			let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/get-eventos';
			 var data = { fecha: this.fecha, fecha_hasta : null };

			  fetch(url, {
				  method: 'POST', // or 'PUT',
				  body: JSON.stringify(data),
				  headers:{
			             'Content-Type': 'application/json',
			             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			         }
			  })
			  .then(response => response.json())
			  .then(data => {
			  	document.getElementById('spinner').style.display = 'none';
			  	this.eventos = data.eventos;
			  	this.publicado = (data.publicado) ? data.publicado.publicada : 'false';

			  	//console.log(data);
			  }).catch(function(error) {
			  	console.log('err' + error);	
			  });


		}
	}
}).mount('#app');