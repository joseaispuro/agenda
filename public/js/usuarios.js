
const app = Vue.createApp({
	data() {
		return {
			usuarios: [],
            usuario: {
                id: 0,
                name: '',
                email: '',
                user: '',
                password : ''
            },
            errors : []
            
		}
	},
	mounted() {

        document.getElementById('spinner').style.display = 'flex';
        let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/get-usuarios';

        fetch(url, {
            method: 'GET', // or 'PUT',
        })
        .then(response => response.json())
        .then(data => {
                document.getElementById('spinner').style.display = 'none';
				this.usuarios = data;

        }).catch(function(error) {
            console.log('err' + error);
        });

	},
	methods: {

        modificar: function (usuario){
            this.errors = [];
            this.usuario.id = usuario.id;
            this.usuario.name = usuario.name;
            this.usuario.user = usuario.user;
            this.usuario.email = usuario.email;
        },

        limpiarDatos: function(){
            this.usuario.id = 0;
            this.usuario.name = '';
            this.usuario.user = '';
            this.usuario.email = '';
            this.usuario.password = '';
            this.errors = [];
        },

		eliminar: function (id) {

			let form = this;

			swal({
				title: "¿Está seguro?",
				text: "¿Realmente desea dar de baja al usuario?",
                buttons: ["Cancelar", "Aceptar"],
				icon: "warning",
				dangerMode: false,
			})
				.then((willDelete) => {
					if (willDelete) {
						//Hacer el request para eliminar el evento
						let url = document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/eliminar-usuario';
						var data = { id: id};

                        this.limpiarDatos();

						fetch(url, {
							method: 'POST', // or 'PUT',
							body: JSON.stringify(data),
							headers: {
								'Content-Type': 'application/json',
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							}
						})
							.then(response => response.json())
							.then(data => {

								if (data.success) {
									swal("Excelente!", 'Usuario eliminado correctamente', "success");
                                    this.usuarios = data.usuarios;
								}else{
                                    swal("Error!", 'No fue posible eliminar al usuario', "error");
                                }

							}).catch(function (error) {
								console.log('err' + error);
							});
					}
				});

		},
        guardarUsuario: function(){
            let form = this;
			form.errors = {};

            let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/admin/guardar-usuario';
			 var data =  this.usuario;

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

                    if(data.success){
                        swal("Excelente!", 'Usuario guardado correctamente', "success");
                        this.usuarios = data.usuarios;
                        this.limpiarDatos();
                    }else{
                        console.log(data.errors)
                        this.errors = data.errors;
                    }

                   
            }).catch(function(error) {
                console.log('err' + error);	
            });

        }



	},
	watch: {



	}
}).mount('#app');