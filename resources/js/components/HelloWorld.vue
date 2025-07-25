<template>
    <div>
        <h1>Olá, {{ nome }}</h1>
        <input type="text" v-model="nome" placeholder="Digite seu nome">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                nome: 'Visitante'
            };
        },
        mounted() {
            console.log('Componente Hello World foi montado.')
        }
    }
</script>
