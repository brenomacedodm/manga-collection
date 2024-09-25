Visão Geral:
O projeto Manga Collection foi desenvolvido como um teste técnico para a empresa Capyba, com o objetivo de demonstrar habilidades em Laravel, desenvolvimento de APIs e boas práticas de desenvolvimento. A aplicação permite gerenciar informações sobre mangás, autores, gêneros, volumes e usuários.

Aviso:
    Envio de email não está funcionando em produção pois não adquiri um domínio.

Tecnologias Utilizadas
    Laravel: Framework PHP para desenvolvimento web.
    Swagger: Ferramenta para documentar APIs RESTful.
    Pest: Framework de testes PHP para escrever testes concisos e expressivos.
    Banco de dados utilizado: MySQL.

Estrutura do Projeto

A aplicação possui as seguintes entidades principais:
    Author: Representa um autor de mangá.
    Collection: Representa uma coleção de mangás.
    Genre: Representa um gênero de mangá.
    Manga: Representa um mangá.
    MangaVolume: Representa um volume de um mangá.
    Publisher: Representa uma editora.
    User: Representa um usuário da aplicação.

Funcionalidades
    Gerenciamento de mangás: Cadastrar, editar, excluir e buscar mangás por diversos critérios.
    Gerenciamento de autores, gêneros e editoras: Cadastrar, editar e excluir informações sobre autores, gêneros e editoras.
    Relações entre entidades: As entidades possuem relacionamentos entre si, como um autor pode ter vários mangás, um mangá pode pertencer a vários gêneros, etc.
    Usuários: Cadastro, login e gerenciamento de perfis de usuários.
    Coleções: Usuários podem criar suas próprias coleções de mangás.
    Documentação da API: A API RESTful da aplicação é completamente documentada utilizando Swagger, facilitando a integração com outras aplicações.
    Testes: A aplicação possui uma cobertura de testes Pest, garantindo a qualidade do código.

Como Executar o Projeto:

Clonar o repositório:
    git clone https://github.com/brenomacedodm/manga-collection.git manga-collection


Instalar as dependências:
    cd manga-collection
    composer install



Rodar as migrations:
    php artisan migrate
    php artisan migrate --database=manga-collection-test

Iniciar o servidor de desenvolvimento:
    php artisan serve

Acessar a documentação da API: Acesse a URL da sua aplicação (127.0.0.1:8000) seguida de /api/documentation.

Para testes locais para a verificação de email utilizei o https://mailtrap.io
Foi utilizado o login com google. As credenciais utilizadas para teste estão no .env.example, mas caso não funcionem segue email e senha do gmail, para pegar novas credenciais.
email: mangacollection95@gmail.com
senha: senha123!

Configurar o banco de dados: 
    Copie o arquivo .env.example para .env e configure as informações do seu banco de dados.

Instalação do Banco de dados local: 

Download do XAMPP:
    Acesse o site oficial do XAMPP: https://www.apachefriends.org/index.html
    Selecione a versão adequada para o seu sistema operacional (Windows, macOS ou Linux) e a arquitetura (32 bits ou 64 bits).
    Clique no botão de download.

Execução do Instalador:
    Localize o arquivo baixado e execute-o.
    Siga as instruções do instalador. As opções padrão geralmente são suficientes para a maioria dos usuários.
    Importante: Marque a opção para instalar o MySQL durante a instalação.

Iniciando os Serviços:
    Após a instalação, abra o painel de controle do XAMPP.
    Inicie os serviços Apache e MySQL clicando nos botões correspondentes.

Verificando a Instalação:
    Abra um navegador e digite http://localhost para acessar a página inicial do Apache.
    Acesse o phpMyAdmin digitando http://localhost/phpmyadmin. Você será solicitado a inserir suas credenciais. O usuário padrão é root e a senha geralmente é em branco na primeira instalação.