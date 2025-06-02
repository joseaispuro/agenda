const { ref } = Vue;

const MiComponente = {
  template: `
    <div>
      <h1>{{ mensaje }}</h1>
      <button @click="cambiarMensaje">Cambiar Mensaje</button>
    </div>
  `,
  setup() {
    const mensaje = ref('Hola, Mundo!');

    const cambiarMensaje = () => {
      mensaje.value = '¡Mensaje cambiado!';
    };

    return {
      mensaje,
      cambiarMensaje
    };
  }
};

// Asegúrate de exportarlo como default
export default MiComponente;
