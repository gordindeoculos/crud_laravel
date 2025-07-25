<template>
  <div class="mb-3">
    <label :for="id" class="form-label">{{ label }}<span v-if="requerido">*</span></label>
    <input :id="id" :type="tipo" :name="id" class="form-control" :class="{ 'is-invalid': erro }"
      :placeholder="placeholder" v-model="valor" @blur="validarCampo" />
    <div v-if="erro" class="invalid-feedback">
      {{ mensagemParaExibir }}
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
    mensagemErro: String,         // mensagem do backend (via Blade)
    mensagemErroPadrao: String,   // mensagem estática local (client-side)
    valorInicial: {
      type: String,
      default: ''
    }
  },

  data() {
    return {
      valor: this.valorInicial,
      erro: false,
      erroLocal: false // erro client-side
    };
  },

  computed: {
    mensagemParaExibir() {
      // Prioridade: mensagem do backend > mensagem local (client-side)
      if (this.mensagemErro && this.mensagemErro.length > 0) {
        return this.mensagemErro;
      }
      if (this.erroLocal) {
        return this.mensagemErroPadrao || 'Campo inválido';
      }
      return '';
    }
  },

  methods: {
    validarCampo() {
      if (this.requerido && this.valor.trim() === '') {
        this.erroLocal = true;
        this.erro = true;
        return;
      }

      if (this.tipo === 'email' && this.valor.trim() !== '') {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        this.erroLocal = !regex.test(this.valor);
        this.erro = this.erroLocal;
      } else {
        this.erroLocal = false;
        this.erro = false;
      }
    }
  },

  watch: {
    mensagemErro(newVal) {
      // Se mensagem do backend mudar, atualiza o erro para exibir
      this.erro = !!newVal && newVal.length > 0;
    }
  },

  mounted() {
    // Se já tem mensagem do backend ao montar, marca erro para exibir
    this.erro = !!this.mensagemErro && this.mensagemErro.length > 0;
    console.log(`InputField montado: ${this.id}`);
  }
};
</script>
