
const app = Vue.createApp({
	data(){
		return {
			concepto: '',
			asunto: '',
			hora: '12:00:00',
			horaFinal : '12:30:00',
			tipoCita: '0',
			fecha: '',
			fechaLetra: '',
			lugar: '',
			lugarAtiende: '',
			atiende: '',
			atiendeAlcalde: '',
			asiste: '',
			contacto: '',
			observaciones: '',
			errors: {}
		}
	},
	mounted() {
		const urlParams = new URLSearchParams(window.location.search);
		const fecha = urlParams.get('fecha');

		if(fecha){
			this.fecha = fecha;
		}else{
			this.fechaSeleccionada(new Date());
		}

    },
	methods: {
		limpiarDatos: function(){
			this.concepto = '';
			this.asunto = '';
			this.tipoCita = '0';
			this.lugar = '';
			this.atiendeAlcalde = '';
			this.lugarAtiende = '';
			this.atiende = '';
			this.observaciones = '';
			this.asiste = '';
			this.contacto = '';
		},
		fechaSeleccionada: function(fecha, letra) {

			let mes = (fecha.getMonth() + 1 < 10) ?  '0' + (fecha.getMonth() + 1) : fecha.getMonth() + 1;
			let dia = fecha.getDate();
			//console.log('el dia es ' + dia);
			let year = fecha.getFullYear();
			let diaLetra = fecha.getDay();

			const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viérnes", "Sábado"];
			const month = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
			"Noviembre", "Diciembre"];

      		let fechaLetra = days[diaLetra] + ' ' + dia + ' de ' + month[mes-1] + ' de ' + year;
      		
      		if(letra){
      			return fechaLetra;
      		}

      		this.fechaLetra = fechaLetra;
			return this.fecha = year + '-' + mes + '-' + dia;
      	},
		grabarEvento: function(){

			let form = this;
			form.errors = {};

			let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/guardar-evento';
			 var data = {concepto: this.concepto, asunto: this.asunto, hora: this.hora, horaFinal: this.horaFinal, tipoCita: this.tipoCita,
			  fecha: this.fecha, lugar: this.lugar, atiendeAlcalde: this.atiendeAlcalde, atiende: this.atiende, asiste: this.asiste,
			  contacto: this.contacto, observaciones: this.observaciones};

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
			  		if(data.respuesta){
			  			swal("Excenlente!", data.mensaje, "success").then((value) => {
  							window.location = document.querySelector('meta[name="base-url"]').getAttribute('content') + '/?fecha=' + this.fecha;
						});
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
		siguienteDia: function(){
			let day = new Date(this.fecha+'T00:00:00');
			day.setDate(day.getDate()+1);

			let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
			let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate() ;

			this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;

			this.limpiarDatos();
			//console.log(day);


		},
		anteriorDia: function(){
			let day = new Date(this.fecha+'T00:00:00');
			day.setDate(day.getDate()-1);

			let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
			let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate() ;

			this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;
			this.limpiarDatos();
		}
	},
	watch: {
		fecha: function(value){
			//console.log(new Date(value));
			this.fechaLetra = this.fechaSeleccionada(new Date(value+'T00:00:00'), true);

			//console.log(this.fechaSeleccionada(new Date(value), true))
			//this.fechaSeleccionada(value);
		},
    	lugarAtiende: function (value) {
    		let self = this;

    		switch(value){
    			case '1': self.lugar = 'Despacho del Alcalde';  break;
    			case '2': self.lugar = 'Sala de Cabildo'; break;    		
    		}
    	},
    	atiendeAlcalde: function(value){
    		let self = this;

    		switch(value){
    			case "1": self.atiende = document.getElementsByName('alcalde')[0].content; break;
    			case "2": self.atiende = ''; break;
    			default: self.atiende = ''; break;
    		}
    		console.log(value);
    	},
    	concepto: function() {
            this.errors.concepto = null;
        },
        asunto: function() {
            this.errors.asunto = null;
        },
        lugar: function(){
        	this.errors.lugar = null;
        },
        atiende: function(){
        	this.errors.atiende = null;
        },
        asiste: function(){
        	this.errors.asiste = null;
        },
        contacto: function(){
        	this.errors.contacto = null;
        },
        tipoCita: function(){
        	this.errors.tipoCita = null;
        }

	}
}).mount('#app');