
# mockBrudam

  

Projeto em Laravel gerado com 
```console
composer create-project
```
 como parte de teste técnico.

## Montagem
### Clonagem
Clone o repositório localmente usando o seguinte comando no terminal
```console
$ git clone git@github.com:gabrielluizcm/mockBrudam.git
```
### Build 
Após acessar o diretório da aplicação com `$ cd mockBrudam`
- Instale as dependências via Composer
```console
$ composer install
```
- Crie o container Docker para execução da aplicação e base de dados local
```console
$ docker-compose up -d
```
### *.env*
O arquivo *.env* deve ser gerado a partir do modelo *.env.example*, e requer as seguintes alterações para acessar o banco no Docker e executar a aplicação corretamente
```
APP_URL=http://localhost:8000
...
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```
Apesar de não ser boa prática incluir credenciais no repositório, informo-as aqui por tratar-se de um banco local de homologação.

### Banco de dados
As estruturas do banco foram definidas utilizando *Migrations*, então, para montar as tabelas e suas colunas, basta executar o comando migrate do *Artisan* dentro do container *Docker* gerado
```console
$ docker exec mockbrudam-app-1 php artisan migrate
```
Após gerar as estruturas, vamos usar o *Seeding* do Laravel para gerar registros na tabela de ***Clientes***, necessária para gerar os pedidos
```console
$ docker exec mockbrudam-app-1 php artisan db:seed
```

### Chave da Aplicação
Com isso, resta apenas gerar a chave da aplicação com 
```console
$ php artisan key:generate
```
terminamos as configurações para rodar a aplicação, que pode ser acessada em [localhost:8000](http://localhost:8000)

## Uso
A *home* da aplicação contém uma tabela simples que carrega via *axios* os dados dos pedidos armazenados no banco de dados. 

Através do botão ***Novo pedido*** é possível abrir o *Modal* com o formulário para criação, onde deverá ser selecionado o cliente, além de informar a data de entrega, valor do pedido e valor do frete. **Todos** os campos são obrigatórios, caso algum não seja preenchido (ou preenchido incorretamente, como texto no campo de valor) a API retornará erro e não cadastrará o pedido.

Caso ocorra um erro na criação, será informado via *toast* e gerará um *log* de erro no *Console*. De forma similar, ao criar um pedido com sucesso, este também será informado via *toast*, fechando automaticamente o *Modal* e atualizando a lista de pedidos, além de também gerar *log* no *Console* exibindo os dados inseridos no banco.
