<template>
  <div class="mb-3">
    <label :for="id" class="form-label">{{ label }}</label>
    <input
      :id="id"
      :type="tipo"
      :name="id"
      class="form-control"
      :placeholder="placeholder"
      v-model="valor"
      @blur="validarCampo"
    />
    <div v-if="erro" class="text-danger mt-1">
      {{ mensagemErro }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: String,
    label: String,
    tipo: {
      type: String,
      default: 'text'
    },
    requerido: {
      type: Boolean,
      default: false
    },
    placeholder: String,
    mensagemErro: String
  },
  data() {
    return {
      valor: '',
      erro: false
    };
  },
  methods: {
    validarCampo() {
      if (this.requerido && this.valor.trim() === '') {
        this.erro = true;
        return;
      }

      if (this.tipo === 'email' && this.valor.trim() !== '') {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        this.erro = !regex.test(this.valor);
      } else {
        this.erro = false;
      }
    }
  },
  mounted() {
    console.log(`InputField montado: ${this.id}`);
  }
};
</script>
