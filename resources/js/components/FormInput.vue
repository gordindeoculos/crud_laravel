<template>
  <div :class="wrapperClass">
    <label :for="id" class="form-label">
      {{ label }} <span v-if="required">*</span>
    </label>

    <input
      :type="type"
      :name="name"
      :id="id"
      class="form-control"
      :class="{ 'is-invalid': serverError || errorMessage }"
      :placeholder="placeholder"
      v-model="inputValue"
      :required="required"
      @blur="checkInput"
    />

    <div v-if="serverError" class="invalid-feedback">{{ serverError }}</div>
    <div v-else-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
  </div>
</template>

<script>
export default {
  name: 'FormInput',
  props: {
    label: { type: String, default: '' },
    type: { type: String, default: 'text' },
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    value: { type: String, default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    serverError: { type: String, default: '' }
  },
  data() {
    return {
      inputValue: this.value,
      errorMessage: ''
    }
  },
  methods: {
    checkInput() {
      const val = this.inputValue.trim();

      // Required
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.';
        return;
      }

      // Validação de e-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.';
        return;
      }

      this.errorMessage = '';
    },
    isValidEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }
  }
}
</script>
