<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pedidos - Brudam</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="css/pedidos.css" />
</head>

<body>
    <div class="content">
        <h1>
            Pedidos
            <button type="button" data-toggle="modal" data-target="#modalNovoPedido">Novo pedido</button>
        </h1>
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
    </div>

    <div class="modal fade" id="modalNovoPedido" tabindex="-1" aria-labelledby="modalNovoPedidoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNovoPedidoLabel">Novo pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNovoPedido">
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cliente">Cliente</label>
                                    <select name="id_cliente" id="id_cliente" class="form-control">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="data_entrega">Data de entrega</label>
                                    <input type="date" name="data_entrega" id="data_entrega" class="form-control" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="valor_pedido">Valor do pedido</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" name="valor_pedido" id="valor_pedido"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="valor_frete">Valor do frete</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="number" name="valor_frete" id="valor_frete" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="submitNovoPedido()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
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
            const endpoint = '{{ env('APP_URL') }}/api/pedido';

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
            const endpoint = '{{ env('APP_URL') }}/api/pedidos';

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
    </script>
</body>


</html>
