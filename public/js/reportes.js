
const app = Vue.createApp({
	data(){
		return {
			tipoCita: '0',
			fecha_inicio: '',
			fecha_fin: '',
			atiende: 0,
			tipo: 0,
			eventos: {}
		}
	},
	mounted(){
		let fecha = new Date();

		let mes = (fecha.getMonth() + 1 < 10) ?  '0' + (fecha.getMonth() + 1) : fecha.getMonth() + 1;
		let dia = (fecha.getDate() < 10) ?  '0' + fecha.getDate()  : fecha.getDate();

		fecha = fecha.getFullYear() + '-' + mes  + '-' + dia;

		this.fecha_inicio = fecha;
		this.fecha_fin = fecha;

		this.visualizar();

	},
	methods: {
		limpiarDatos: function(){
			this.tipoCita = '0';
		},
		visualizar: function(){

			document.getElementById('spinner').style.display = 'flex';

			let form = this;

			let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/get-eventos';
			 var data = {fecha: this.fecha_inicio, fecha_hasta: this.fecha_fin, atiende: this.atiende, tipo: this.tipo };

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
			  	this.eventos = data.eventos;
			  	document.getElementById('spinner').style.display = 'none';
			  	//console.log(data);
			  		if(data.respuesta){
			  			swal("Excenlente!", data.mensaje, "success");
			  		}/*else{
			  			swal("Error de Autenticación", "Los datos de acceso proporcionados son incorrectos", "error");
			  		}*/

			  		if (data.errors) {
                         for(let key in data.errors) {
                                form.errors[key] = data.errors[key].join('<br>');
                             }
                    }
			  }).catch(function(error) {
			  	console.log('err' + error);	
			  });

		},
		generar: function(){
			let url = document.getElementsByTagName('meta').namedItem('base-url').content + '/admin/generar?fecha_inicio=' + this.fecha_inicio +'&fecha_fin='+this.fecha_fin+'&atiende=' + this.atiende + '&tipo=' + this.tipo ;
			console.log(url)
			window.location =  url;
		}
	},
	watch: {

	}
}).mount('#app');