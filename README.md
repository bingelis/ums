1. $ git clone https://github.com/bingelis/ums.git
2. $ composer install 
3. Add your database settings to app/config/parameters.yml
4. $ php bin/console doctrine:database:create
5. $ php bin/console doctrine:schema:update --force
6. $ php bin/console server:start
7. Login as admin:admin
