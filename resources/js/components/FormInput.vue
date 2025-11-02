<template>
  <div :class="wrapperClass">
    <label :for="id" class="form-label">
      {{ label }}
      <span v-if="required">*</span>
    </label>

    <input
      :type="type"
      :name="name"
      :id="id"
      class="form-control"
      :class="{ 'is-invalid': errorMessage }"
      :placeholder="placeholder"
      v-model="inputValue"
      :pattern="inputPattern"
      :title="inputTitle"
      :maxlength="maxlength"
      :required="required"
      @blur="checkInput"
    />

    <div v-if="errorMessage" class="invalid-feedback">{{ errorMessage }}</div>
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
    value: { type: [String, Number], default: '' },
    wrapperClass: { type: String, default: 'col-12 col-sm-6 col-md-8' },
    pattern: { type: String, default: null },
    title: { type: String, default: null },
    maxlength: { type: [String, Number], default: null },
  },
  data() {
    return {
      inputValue: this.value,
      errorMessage: '',
    }
  },
  computed: {
    inputPattern() {
      if (this.type === 'tel') return '\\(\\d{2}\\) \\d{4,5}-\\d{4}'
      const max = Number(this.maxlength)
      if (!Number.isNaN(max) && max > 0) return `.{${max}}`
      return this.pattern || null
    },
    inputTitle() {
      if (this.type === 'tel')
        return 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999'
      const max = Number(this.maxlength)
      if (!Number.isNaN(max) && max > 0)
        return `O campo deve conter exatamente ${max} caracteres`
      return this.title || null
    },
  },
  watch: {
    value(newVal) {
      this.inputValue = newVal
    },
  },
  methods: {
    checkInput() {
      const val = String(this.inputValue || '').trim()

      // Requerido
      if (this.required && !val) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
        return
      }

      // E-mail
      if (this.type === 'email' && val && !this.isValidEmail(val)) {
        this.errorMessage = 'Por favor, insira um e-mail válido.'
        return
      }

      // Telefone
      if (this.type === 'tel' && val && !this.isValidPhone(val)) {
        this.errorMessage = 'Digite um telefone no formato (99) 9999-9999 ou (99) 99999-9999.'
        return
      }

      // Número
      if (this.type === 'number' && val && isNaN(val)) {
        this.errorMessage = 'Por favor, insira um número válido.'
        return
      }

      // Verificação de tamanho exato (ex.: Estado com 2 caracteres)
      const max = Number(this.maxlength)
      if (!Number.isNaN(max) && max > 0 && val && val.length !== max) {
        this.errorMessage = `O campo deve conter exatamente ${max} caracteres.`
        return
      }

      this.errorMessage = ''
    },

    isValidEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return regex.test(email)
    },

    isValidPhone(phone) {
      const regex = /^\(\d{2}\) \d{4,5}-\d{4}$/
      return regex.test(phone)
    },
  },
}
</script>
