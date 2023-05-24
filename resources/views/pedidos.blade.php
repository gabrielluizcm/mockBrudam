<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pedidos - Brudam</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="css/pedidos.css" />
</head>

<body>
    <div class="content">
        <h1>Pedidos</h1>

        <table class="table" id="tabelaPedidos">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Data de entrega</th>
                    <th scope="col">Valor do pedido</th>
                    <th scope="col">Valor do frete</th>
                    <th scope="col">Data de criação</th>
                    <th scope="col">Data da atualização</th>
                </tr>
            </thead>
            <tbody>
                <template id="templateRowPedido">
                    <tr>
                        <td>{id}</th>
                        <td>{cliente}</th>
                        <td>{data_entrega}</th>
                        <td>{valor_pedido}</th>
                        <td>{valor_frete}</th>
                        <td>{data_criacao}</th>
                        <td>{data_atualizacao}</th>
                    </tr>
                </template>
            </tbody>
        </table>
        <div class="loader">
            Buscando pedidos
            <div class="newtons-cradle">
                <div class="newtons-cradle__dot"></div>
                <div class="newtons-cradle__dot"></div>
                <div class="newtons-cradle__dot"></div>
                <div class="newtons-cradle__dot"></div>
            </div>
        </div>
    </div>
</body>
<script>
    window.onload = () => {
        const loader = document.querySelector('.loader');
        const endpoint = '{{ env('APP_URL') }}/api/pedidos';

        fetch(endpoint)
            .then(response => response.json())
            .then(data => renderPedidos(data))
            .catch(err => {
                console.error(err);
                alert('Não foi possível recuperar os pedidos');
            })
            .finally(() => {
                loader.remove();
            })
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
</script>

</html>
