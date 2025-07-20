<template>
  <div class="mb-3">
    <label :for="id" class="form-label">{{ label }}<span v-if="requerido">*</span></label>
    <input
      :id="id"
      :type="tipo"
      :name="id"
      class="form-control"
      :class="{ 'is-invalid': erro }"
      :placeholder="placeholder"
      v-model="valor"
      @blur="validarCampo"
    />
    <div v-if="erro" class="invalid-feedback">
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
    mensagemErro: String,
    valorInicial: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      valor: this.valorInicial,
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
