フリーマーケットアプリ 環境構築  

Dockerビルド  

git clone git@github.com:takuyakurikuri/flea-market.git  
docker-compose up -d --build  
<!-- MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.ymlファイルを編集して下さい。 -->

Laravel環境構築  

docker-compose exec php bash  
composer install  
.env.exampleファイルから.envを作成し、環境変数を変更して下さい  
php artisan key:generate  
php artisan migrate  
php artisan storage:link  
php artisan db:seed  

使用技術  
PHP7.4.9  
laravel8.0  
mysql8.0  
mailhog  

ER図
![0B276292-9B6C-4A86-800B-EAF08438C65C](https://github.com/user-attachments/assets/71fe59b9-8b9f-4fe4-952f-42f6455bedd3)



URL 開発環境：http://localhost/  
phpMyAdmin：http://localhost:8080/  
mailhog：http://localhost:8025/  
