window.onload = () => {
    buscaPedidos();
}

function renderPedidos(pedidos) {
    const template = document.querySelector('#templateRowPedido');
    const tabelaPedidos = document.querySelector('#tabelaPedidos');
    const bodyTabelaPedidos = tabelaPedidos.querySelector('tbody');

    pedidos.forEach(pedido => {
        const clone = template.content.cloneNode(true);
        const tdElements = clone.querySelectorAll('td');
        tdElements[0].textContent = pedido.id;
        tdElements[1].textContent = pedido.cliente;
        tdElements[2].textContent = pedido.data_entrega;
        tdElements[3].textContent = formataValor(pedido.valor_pedido);
        tdElements[4].textContent = formataValor(pedido.valor_frete);
        tdElements[5].textContent = pedido.data_criacao;
        tdElements[6].textContent = pedido.data_atualizacao;

        bodyTabelaPedidos.appendChild(clone);
    })
}

function formataValor(valor) {
    const BRL = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    return BRL.format(valor);
}

function submitNovoPedido() {
    const form = document.querySelector('#formNovoPedido');
    const formData = new FormData(form);
    const endpoint = `${BASE_URL}/api/pedido`;

    axios.post(endpoint, formData)
        .then(response => {
            Toastify({
                text: 'Pedido salvo com sucesso. Os dados gerados podem ser verificados no Console.',
                duration: 3000
            }).showToast();
            console.log(response.data);

            atualizaPedidos();
        })
        .catch(err => {
            Toastify({
                text: 'Não foi possível salvar o pedido. Verifique detalhes no Console',
                duration: 3000
            }).showToast();
            console.error(err);
        })
}

function buscaPedidos() {
    const loader = document.querySelector('.loader');
    const endpoint = `${BASE_URL}/api/pedidos`;

    axios.get(endpoint)
        .then(response => {
            renderPedidos(response.data)
        })
        .catch(err => {
            console.error(err);
            Toastify({
                text: 'Não foi possível recuperar os pedidos.',
                duration: 3000
            }).showToast();
        })
        .finally(() => {
            loader.classList.add('hidden');
        });
}

function atualizaPedidos() {
    const loader = document.querySelector('.loader');
    const bodyTabelaPedidos = document.querySelector('#tabelaPedidos tbody');

    $('#modalNovoPedido').modal('hide');
    bodyTabelaPedidos.innerHTML = '';
    loader.classList.remove('hidden');
    buscaPedidos();
}
