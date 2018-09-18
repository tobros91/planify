<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'planify');

// Project repository
set('repository', 'git@github.com:tobros91/planify.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

set('default_stage', 'production');

host('tobiasrosengren.se')
    ->user('tobias')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->stage('production')
    ->set('deploy_path', '/var/www/planify.tobiasrosengren.se');

// Tasks

task('pwd', function () {
    $result = run('cd '.get('deploy_path').' && pwd');
    writeln("Current dir: $result");
});

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
