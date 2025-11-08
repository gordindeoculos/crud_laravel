document.addEventListener('DOMContentLoaded', () => {
    // ### Faz a validação dos campos de preenchimento obrigatório ###
    const requiredInputs = document.querySelectorAll('input[required]');

    // Aplica o evento 'blur' a cada input
    requiredInputs.forEach(input => {
        input.addEventListener('blur', () => {
            // Verifica se o campo está vazio
            if (input.value.trim() === '') {
                // Remove mensagem de erro duplicada, se houver
                removeErrorMessage(input);

                // Adiciona mensagem de erro
                addErrorMessage(input, `O campo ${input.previousElementSibling.textContent.replace('*', '').trim()} é obrigatório`);
                input.classList.add('is-invalid');
            } else {
                // Remove a mensagem de erro, se existir
                removeErrorMessage(input);
                input.classList.remove('is-invalid');
            }
        });
    });

    // ### Faz a validação do E-mail ###
    const emailInput = document.getElementById('email');

    if (emailInput) {
        emailInput.addEventListener('blur', () => {
            const emailValue = emailInput.value.trim();

            // Regex para validar o formato do e-mail
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Verifica se o campo está vazio
            if (emailValue === '') {
                // Remove mensagem de erro duplicada, se houver
                removeErrorMessage(emailInput);

                // Adiciona mensagem de erro
                addErrorMessage(emailInput, 'O campo E-mail é obrigatório.');
            }
            // Verifica se o e-mail é inválido
            else if (!emailRegex.test(emailValue)) {
                // Remove mensagem de erro duplicada, se houver
                removeErrorMessage(emailInput);

                // Adiciona mensagem de erro
                addErrorMessage(emailInput, 'Insira um e-mail válido.');
            } else {
                // Remove mensagem de erro e a classe inválida
                removeErrorMessage(emailInput);
            }
        });
    }

    // ### Faz a validação da sigla do estado exigindo 2 caracateres ###
    const estadoInput = document.getElementById('estado');

    if (estadoInput) {
        estadoInput.addEventListener('blur', () => {
            const estadoValue = estadoInput.value.trim();

            // Verifica se o campo está vazio
            if (estadoValue === '') {
                removeErrorMessage(estadoInput);
                addErrorMessage(estadoInput, 'O campo Estado é obrigatório.');
            }
            // Verifica se o campo possui exatamente 2 caracteres
            else if (estadoValue.length !== 2) {
                removeErrorMessage(estadoInput);
                addErrorMessage(estadoInput, 'O campo deve conter exatamente 2 caracteres.');
            } else {
                // Remove a mensagem de erro, se existir
                removeErrorMessage(estadoInput);
            }
        });
    }

    // Função para adicionar uma mensagem de erro
    function addErrorMessage(input, message) {
        if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
            input.insertAdjacentHTML(
                'afterend',
                `<div class="invalid-feedback">${message}</div>`
            );
        }
        input.classList.add('is-invalid');
    }

    // Função para remover a mensagem de erro
    function removeErrorMessage(input) {
        if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
            input.nextElementSibling.remove();
        }
        input.classList.remove('is-invalid');
    }
});