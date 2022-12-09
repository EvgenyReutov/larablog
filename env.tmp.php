@servers(['main' => ['forge@46.101.212.181']])

@task('migrate', ['on' => 'main'])
php artisan migrate --force
@endtask

@task('deploy', ['on' => 'main'])
cd ~/ereutov.ru
php artisan down
git checkout EReutov/deploy
git pull
composer install -no-dev --no-interation --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader

php artisan cache:clear
php artisan config:cache
npm install --production
npm run build
php artisan up
@endtask


@story('deploy')
deploy
@endstory

//https://rdevelab.ru/blog/no-category/post/laravel-app-deploy-with-envoy
