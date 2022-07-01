const { createApp } = Vue

createApp({
  data() {
    return {
      fecha: '',
      fechaLetra: '',
      diaLetra: '',
      dia: '',
      mes: '',
      eventos : {},
    }
  },
  mounted (){
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
      siguienteDia: function(){
          let day = new Date(this.fecha+'T00:00:00');

          day.setDate(day.getDate()+1);

          let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
          let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate();

          this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;

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

          const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
          const month = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
          "Noviembre", "Diciembre"];

              let fechaLetra = days[diaLetra] + ' ' + dia + ' de ' + month[mes-1] + ' de ' + year;

              this.fechaLetra = fechaLetra;
      },
      reiniciar(){

           let fecha = new Date();
          let mes = fecha.getMonth() + 1;

          mes = (mes < 10) ? '0' + mes : mes;
          let anio =  fecha.getFullYear();
          let dia = fecha.getDate();
          dia = (dia < 10) ? '0' + dia : dia;
          
          let fec =  anio + '-' + mes + '-' + dia;

          this.fecha = fec;

      },
      imprimirPdf(){

          let url = document.getElementsByTagName('meta').namedItem('base-url').content + '/imprimir-pdf/' + this.fecha ;
          window.location =  url;

      },
      compartirWhatsApp(evento){

          let form = this;

          window.location = 'whatsapp://send?text=AGENDA%20DEL%20ALCALDE%0AMUNICIPIO%20DE%20MAZATLAN%0A' + form.fechaLetra +'%0A' + evento.fecha_inicio.substr(11,5) +' hrs. %0AConcepto: ' + this.prepararTexto(evento.concepto) + '%0AAsunto: ' + this.prepararTexto(evento.asunto) + '%0ALugar: ' + this.prepararTexto(evento.lugar);
      },
      prepararTexto(texto){
          return texto.replace(' ', '%20');
      }
  },
  watch: {
      fecha: function(value){

          this.fechaSeleccionada(new Date(value+'T00:00:00'));

          //Obtener eventos
          let form = this;

          //Colocamos el dia cuando cambia
          let tempDia = form.fecha.split('-');
          form.dia = tempDia[2];

          //Colocamos el mes cuando cambia
          let tempMes = form.fechaLetra.split(' ');
          form.mes = tempMes[3];
          form.diaLetra = tempMes[0];

          form.eventos = [];

          let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/get-eventos-public';
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

              //console.log(data);
            }).catch(function(error) {
              console.log('err' + error);
            });


      }
  }
}).mount('#app');


/////////////////////////////////////////////////////////////////////////////////////////////////////////
// Click en el calendario

var inputFecha = document.querySelector('.fecha input');

document.querySelector('.fecha .click-area').addEventListener('click', () => {
    inputFecha.showPicker();
});

document.querySelectorAll('.fecha .arrow').forEach(arrow => arrow.addEventListener('click', (e) => {
    var diff = e.target.classList.contains('next') ? +1 : -1,
        fecha = inputFecha.valueAsDate || new Date();

    fecha.setDate(fecha.getDate() + diff);
    inputFecha.valueAsDate = fecha;
    onDateSelect(fecha);
}));

inputFecha.addEventListener('input', () => {
    onDateSelect(inputFecha.valueAsDate);
});

function onDateSelect(fecha) {
    console.log("Fecha Seleccionada:", fecha);
}
