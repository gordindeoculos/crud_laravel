<template>
    <div class="mb-3 col-6">
        <label class="form-label">E-mail</label>
        <input class="form-control" type="text" v-model="email" placeholder="Informe seu e-mail" @blur="validar">
        <p v-if="erro" class="text-danger small mt-1">{{ erro }}</p>
        <button class="btn btn-primary mt-2" @click="validar">Enviar</button>
    </div>
</template>

<script>
export default {
    props: {
        required: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            email: '',
            erro: ''
        }
    },
    methods: {
        validar() {
            if (this.required && !this.email.trim()) {
                this.erro = 'Este campo é obrigatório.';
            } else {
                this.erro = '';
            }
        }
    }
}
</script>
