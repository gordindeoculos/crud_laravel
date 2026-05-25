<template>
    <form :action="action" method="POST">
        
        <!-- Token CSRF do Laravel -->
        <input type="hidden" name="_token" :value="csrf">

        <!-- Method spoofing do Laravel -->
        <input v-if="method.toUpperCase() !== 'POST'" type="hidden" name="_method" :value="method.toUpperCase()">

        <!-- Container geral do formulário -->
        <div class="conteudo-form">
            
            <div class="card">
                <div class="card-header">

                    <!-- Exibe o título recebido pela prop titulo -->
                    <h3 class="m-0">{{ titulo }}</h3>

                </div>

                <!-- Corpo do Card -->
                <div class="card-body bg-white">

                    <slot></slot>

                </div>

                <!-- Rodapé do Card -->
                <div class="card-footer">

                    <!-- Área dos botões -->
                    <div class="col-auto">
                        
                        <!-- Botão Voltar -->
                        <a :href="voltarUrl" class="btn btn-secondary me-2">Voltar</a>

                        <!-- Botão de Envio -->
                        <button type="submit" class="btn btn-primary">{{ botaoTexto }}</button>
                    </div>

                </div>
            </div>

        </div>
    </form>
</template>
<script>
export default {
    props: {
        action: {
            type: String,
            required: true
        },
        method: {
            type: String,
            default: 'POST'
        },
        voltarUrl: {
            type: String,
            required: true
        },
        titulo: {
            type: String,
            default: 'Formulário'
        },
        botaoTexto: {
            type: String,
            default: 'Salvar'
        }
    },
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        }
    }
}
</script>