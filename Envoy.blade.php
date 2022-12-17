@include('vendor/autoload.php')

@servers(['main' => ['forge@46.101.212.181']])


@story('deploy', ['on' => 'main'])
    gitclone
    composer
    npm
    config_project
    run_tests
    set_current
    releases_clean
@endstory

@setup

    $releaseRotate = 5;
    $timezone = 'Europe/Moscow';
    $date = new datetime('now', new DateTimeZone($timezone));

    $gitBranch = 'EReutov/deploy';
    $gitRepository = 'git@github.com:EvgenyReutov/larablog.git';

    $on = 'main';
    $dirBase = '/home/forge/ereutov.ru';
    $testEnv = 'testing';
    $dirShared = $dirBase . '/shared';
    $dirCurrent = $dirBase . '/current';
    $dirReleases = $dirBase . '/releases';
    $dirCurrentRelease = $dirReleases . '/' . $date->format('YmdHis');
@endsetup

@task('gitclone', ['on' => 'main'])
    echo "# Gitclone task"
    cd ereutov.ru
    mkdir -p {{$dirCurrentRelease}}
    git clone --depth 1 -b {{$gitBranch}} {{$gitRepository}} {{$dirCurrentRelease}}

    echo "# Repository has been cloned"
@endtask

@task('composer', ['on' => $on])
    echo "# Composer task"

    cd {{$dirCurrentRelease}}
    composer install --no-interaction --quiet --prefer-dist --optimize-autoloader

    echo "# Composer dependencies have been installed"
@endtask

@task('npm', ['on' => $on])
    echo "# Npm task"
    cd {{$dirCurrentRelease}}
    npm install
    npm audit fix
    npm run build
    echo "# Npm dependencies have been installed"
@endtask

@task('config_project', ['on' => $on])
    echo "# Config project task";

    echo "# Linking storage directory";
    rm -rf {{$dirCurrentRelease}}/storage/app;
    cd {{$dirCurrentRelease}};
    ln -nfs {{$dirShared}}/storage/app storage/app;
    php artisan storage:link

    echo "# Linking .env file";
    cd {{$dirCurrentRelease}};
    ln -nfs {{$dirBase}}/.env .env;
    ln -nfs {{$dirBase}}/.env.testing .env.testing;

    echo "# Optimising installation";
    php artisan clear-compiled --env={{$env}};
    php artisan optimize --env={{$env}};
    php artisan config:cache --env={{$env}};
    php artisan cache:clear --env={{$env}};
@endtask

@task('set_current', ['on' => $on])
    echo '# Linking current release';
    ln -nfs {{$dirCurrentRelease}} {{$dirCurrent}};
@endtask

@task('releases_clean')
    purging=$(ls -dt {{$dirReleases}}/* | tail -n +{{$releaseRotate}});

    if [ "$purging" != "" ]; then
    echo "# Purging old releases: $purging;"
    rm -rf $purging;
    else
    echo "# No releases found for purging at this time";
    fi
@endtask

@task('run_tests', ['on' => $on])
    echo "# Run tests";
    cd {{$dirCurrentRelease}}
    php artisan test --env={{$testEnv}};
@endtask
