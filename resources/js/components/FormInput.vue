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
      :value="value"
      :required="required"
      @blur="checkRequired"
    />

    <!-- mensagem do Laravel -->
    <div v-if="serverError" class="invalid-feedback">{{ serverError }}</div>
    <!-- mensagem de validação do Vue -->
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
    serverError: { type: String, default: '' } // para receber erro do Laravel
  },
  data() {
    return {
      errorMessage: ''
    }
  },
  methods: {
    checkRequired(event) {
      if (this.required && !event.target.value.trim()) {
        this.errorMessage = 'Este campo é de preenchimento obrigatório.'
      } else {
        this.errorMessage = ''
      }
    }
  }
}
</script>
