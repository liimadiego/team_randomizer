Sorteador de Times - (Pode ser acessado em http://18.224.23.111/)
Requisitos
Certifique-se de ter o Docker instalado em sua máquina. 

Clone o repositório com o comando: ~ git clone https://github.com/liimadiego/team_randomizer.git

Acesse o diretório do projeto: ~ cd sorteador-de-times

Caso necessário, altere a porta do servidor ngnix.

Construa e inicie os containers Docker: ~ docker-compose up --build

Copie o arquivo .env.example para .env com o comando: ~ docker-compose exec php cp .env.example .env

Instale as dependências do Composer: ~ docker-compose exec php composer install

Gere a chave de aplicação do Laravel: ~ docker-compose exec php php artisan key:generate

Execute as migrações e o seed do banco de dados: ~ docker-compose exec php php artisan migrate --seed

Execute as migrações do banco de dados de teste: ~ docker-compose exec php php artisan migrate --env=testing

Instale as dependências do NPM: ~ docker-compose exec php npm install

Inicie o servidor Laravel: ~ docker-compose exec php php artisan serve

Você poderá acessar o projeto em http://localhost:<PORTA_CONFIGURADA>.
