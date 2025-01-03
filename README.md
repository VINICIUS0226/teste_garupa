Passos para Execução do Sistema
1. Clone o Repositório
   Se você ainda não clonou o repositório, faça isso com o comando abaixo:

bash
Copiar código
git clone https://github.com/seu-usuario/financeflow-laravel.git
cd financeflow-laravel
2. Instalar as Dependências do Backend
   Execute o comando para instalar as dependências do backend usando o Composer:

bash
Copiar código
composer install
3. Instalar as Dependências do Frontend
   Instale as dependências do frontend (caso esteja usando Vue.js ou outra tecnologia JS):

bash
Copiar código
npm install
4. Configurar o Banco de Dados
   Certifique-se de que você tem o PostgreSQL instalado e configurado corretamente. Depois de configurar o banco de dados e preencher as variáveis do .env, crie o banco de dados garupa ou use a configuração que preferir.

5. Rodar as Migrações
   Para rodar as migrações e criar as tabelas necessárias no banco de dados, execute o comando:

bash
Copiar código
php artisan migrate
Se você precisar rodar os seeders para popular o banco com dados iniciais (por exemplo, dados de usuários ou transferências), use o comando abaixo:

bash
Copiar código
php artisan db:seed
Caso tenha seeders específicos para rodar, você pode especificar o seeder diretamente:

bash
Copiar código
php artisan db:seed --class=SeederName
6. Gerar a Chave de Aplicação
   Caso ainda não tenha gerado a chave de aplicação, execute o comando:

bash
Copiar código
php artisan key:generate
Isso irá gerar a chave para encriptação de sessões e outras funcionalidades.

7. Compilar os Assets
   Se o seu projeto utiliza frontend com Vue.js ou outras tecnologias, compile os assets:

bash
Copiar código
npm run dev
Para produção, você pode rodar:

bash
Copiar código
npm run prod
8. Iniciar o Servidor Laravel
   Por fim, inicie o servidor local do Laravel:

bash
Copiar código
php artisan serve
Isso vai rodar o aplicativo localmente no endereço http://localhost:8000.


Configuração do Arquivo .env
O arquivo .env contém todas as variáveis de ambiente necessárias para o funcionamento do Laravel. Abaixo está o conteúdo que você deve ter no seu arquivo .env para que o sistema utilize o banco de dados PostgreSQL e outras configurações.

Conteúdo do Arquivo .env:
env
Copiar código
APP_NAME=FinanceFlow
APP_ENV=local
APP_KEY=base64:pECDWkftS67akHZdzASAekYeVoJOdGK87fkFduabSnA=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=garupa
DB_USERNAME=postgres
DB_PASSWORD=admin

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
Explicação das Configurações:
Banco de Dados: Estamos usando o PostgreSQL com as configurações fornecidas:

DB_CONNECTION=pgsql: Define o banco de dados como PostgreSQL.
DB_HOST=127.0.0.1: Endereço do servidor de banco de dados (localhost).
DB_PORT=5432: Porta padrão do PostgreSQL.
DB_DATABASE=garupa: Nome do banco de dados.
DB_USERNAME=postgres: Usuário do banco de dados.
DB_PASSWORD=admin: Senha do banco de dados.
Configuração de Localidade: A localidade padrão está configurada para en.

Sessões e Cache: Usamos banco de dados para armazenar sessões e cache.

Mail e Redis: Configurações padrões para Redis e o mailer.
