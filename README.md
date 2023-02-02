
1) npm install

2) composer update

4) npm run admin-prod ## for build css

5) docker run --name mysqldb -v mysqldbvol:/var/lib/mysql -p 3306:3306 -e MYSQL_USER=mysql -e MYSQL_PASSWORD=mysql -e MYSQL_DATABASE=rms -e MYSQL_ROOT_PASSWORD=Sup3rs3cr3t -d mysql/mysql-server:latest
        
4) when database has been connect -> run command sql

5) CREATE DATABASE rms;

6) php artisan migrate:fresh --seed

7) php artisan serve

8) account superadmin@RMS.com , nge1717nge

![alt text](https://github.com/riskywerawat/ce-restaurant-poc/blob/main/table_entity.PNG?raw=true)

