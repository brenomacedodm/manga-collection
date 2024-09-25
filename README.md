Visão Geral:
O projeto Manga Collection foi desenvolvido como um teste técnico para a empresa Capyba, com o objetivo de demonstrar habilidades em Laravel, desenvolvimento de APIs e boas práticas de desenvolvimento. A aplicação permite gerenciar informações sobre mangás, autores, gêneros, volumes e usuários.

Tecnologias Utilizadas
Laravel: Framework PHP para desenvolvimento web.
Swagger: Ferramenta para documentar APIs RESTful.
Pest: Framework de testes PHP para escrever testes concisos e expressivos.
Banco de dados: MySQL (ou outro banco de dados suportado pelo Laravel).

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
Testes: A aplicação possui uma cobertura de testes completa utilizando o framework Pest, garantindo a qualidade do código.

Como Executar o Projeto
Clonar o repositório:

git clone https://github.com/brenomacedodm/manga-collection.git manga-collection


Instalar as dependências:

cd manga-collection
composer install


Configurar o banco de dados: Copie o arquivo .env.example para .env e configure as informações do seu banco de dados.
Rodar as migrations:

php artisan migrate


Iniciar o servidor de desenvolvimento:

php artisan serve

Acessar a documentação da API: Acesse a URL da sua aplicação seguida de /api/documentation.

Para testes locais para a verificação de email utilizei o https://mailtrap.io
Foi utilizado o login com google. As credenciais utilizadas para teste estão no .env.example, mas caso não funcionem segue email e senha do gmail, para pegar novas credenciais.
email: mangacollection95@gmail.com
senha: senha123!