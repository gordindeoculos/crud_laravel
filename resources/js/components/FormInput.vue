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
      :pattern="inputPattern"
      :title="inputTitle"
      :min="min"
      :max="max"
      :step="step"
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
    type: { type: String, default: 'text' }, // "text", "email", "tel", "number"
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    value: { type: [String, Number], default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    serverError: { type: String, default: '' },
    min: { type: [String, Number], default: null },
    max: { type: [String, Number], default: null },
    step: { type: [String, Number], default: null }
  },
  data() {
    return {
      inputValue: this.value,
      errorMessage: ''
    }
  },
  computed: {
    inputPattern() {
      if (this.type === 'tel') return '\\(\\d{2}\\) \\d{4,5}-\\d{4}'
      return null
    },
    inputTitle() {
      if (this.type === 'tel')
        return 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999'
      return null
    }
  },
  methods: {
    checkInput() {
      const val = String(this.inputValue).trim()

      // Required
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
        return
      }

      // Validação e-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.'
        return
      }

      // Validação telefone
      if (this.type === 'tel' && val && !this.isValidPhone(val)) {
        this.errorMessage = 'Digite um telefone no formato correto.'
        return
      }

      // Validação número
      if (this.type === 'number' && val && isNaN(val)) {
        this.errorMessage = 'Por favor, insira um número válido.'
        return
      }

      this.errorMessage = ''
    },

    isValidEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return re.test(email)
    },

    isValidPhone(phone) {
      const re = /^\(\d{2}\) \d{4,5}-\d{4}$/
      return re.test(phone)
    }
  }
}
</script>
