
const app = Vue.createApp({
	data(){
		return {
			usuario: '',
			password: ''
		}
	},
	methods: {
		ingresar : function(){

		 if(this.usuario == '' || this.password == ''){
		  			swal("Faltan datos", "Debe llenar los campos de usuario y contraseña", "warning");
		 }else{

			 let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/login';
			 var data = {user: this.usuario, password: this.password};

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
			  	console.log(data);
			  		//console.log(data.exito);
			  		if(data.exito){
			  			swal("Bienvenido!", "Los datos de acceso proporcionados son correctos", "success").then((value) => {
  							window.location = '/';
						});
			  		}else{
			  			swal("Error de Autenticación", "Los datos de acceso proporcionados son incorrectos", "error");
			  		}
			  }).catch(error => console.log(error));

		 }
		},
		limpiarDatos: function(){
			this.usuario = '';
			this.password = '';
		}
	}
}).mount('#app');