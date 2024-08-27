Sorteador de Times
Requisitos
Certifique-se de ter o Docker instalado em sua máquina. 

Clone o repositório com o comando: git clone https://github.com/liimadiego/team_randomizer.git

Acesse o diretório do projeto: cd sorteador-de-times

Caso necessário, altere a porta do servidor ngnix.

Construa e inicie os containers Docker: docker-compose up --build

Instale as dependências do Composer: docker-compose exec php composer install

Gere a chave de aplicação do Laravel: docker-compose exec php php artisan key:generate

Execute as migrações e o seed do banco de dados: docker-compose exec php php artisan migrate --seed

Instale as dependências do NPM: docker-compose exec php npm install

Inicie o servidor Laravel: docker-compose exec php php artisan serve

Você poderá acessar o projeto em http://localhost:<PORTA_CONFIGURADA>.
