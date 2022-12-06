## ECサイト注文フォーム

## ダウンロード方法

git clone

git clone https://github.com/codawi/laravel_ec.git

もしくはzipファイルでダウンロードしてください

## インストール方法

- cd laravel_ec
- composer install または composer update
- npm install
- npm run dev

.env.example をコピーして .env ファイルを作成

.envファイルの中の下記をご利用の環境に合わせて変更してください。

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-ec
DB_USERNAME=ec-test
DB_PASSWORD=password123

XAMPP/MAMPまたは他の開発環境でDBを起動した後に

php artisan migrate:fresh --seed

と実行してください。(データベーステーブルとダミーデータが追加されればOK)

最後に
php artisan key:generate
と入力してキーを生成後、

ターミナルを2つ立ち上げ
npm run dev の後、
php artisan serve
で簡易サーバーを立ち上げ、表示確認してください。