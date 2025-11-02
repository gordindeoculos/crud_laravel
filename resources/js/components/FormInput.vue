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
      :maxlength="maxlength"
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
    type: { type: String, default: 'text' }, // text, email, tel, number, etc.
    name: { type: String, required: true },
    id: { type: String, required: true },
    placeholder: { type: String, default: '' },
    required: { type: Boolean, default: false },
    value: { type: [String, Number], default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    serverError: { type: String, default: '' },
    min: { type: [String, Number], default: null },
    max: { type: [String, Number], default: null },
    step: { type: [String, Number], default: null },
    maxlength: { type: [String, Number], default: null },
    pattern: { type: String, default: null },
    title: { type: String, default: null }
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
      if (this.maxlength === 2) return '.{2}' // ex: UF
      return this.pattern
    },
    inputTitle() {
      if (this.type === 'tel')
        return 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999'
      if (this.maxlength === 2)
        return 'O campo deve conter exatamente 2 caracteres'
      return this.title
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

      // Email
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.'
        return
      }

      // Telefone
      if (this.type === 'tel' && val && !this.isValidPhone(val)) {
        this.errorMessage = 'Digite um telefone no formato correto: (99) 9999-9999 ou (99) 99999-9999.'
        return
      }

      // Número
      if (this.type === 'number' && val && isNaN(val)) {
        this.errorMessage = 'Por favor, insira um número válido.'
        return
      }

      // UF (2 caracteres)
      if (this.maxlength === 2 && val && val.length !== 2) {
        this.errorMessage = 'O campo deve conter exatamente 2 caracteres.'
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
