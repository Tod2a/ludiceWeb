<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// Config

set('repository', 'git@github.com:Tod2a/ludiceWeb.git');
set('ssh_multiplexing', false);
set('keep_releases', 5);

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('test')
    ->set('remote_user', 'ludice')
    ->set('deploy_path', '/data/ludice/app')
    ->set('hostname', 'tst.ludice.app')
    ->set('branch', 'staging');

host('prod')
    ->set('remote_user', 'ludice')
    ->set('deploy_path', '/data/ludice/app')
    ->set('hostname', 'ludice.app')
    ->set('branch', 'master');

// Tasks

// Define custom tasks similar to npm:install for running `npm run build` command

set('bin/npm', function () {
    return which('npm');
});

task('npm:run_build', function () {
    run("cd {{release_path}} && {{bin/npm}} run build");
});


// Hooks

after('artisan:migrate', 'npm:install');
after('npm:install', 'npm:run_build');


after('deploy:failed', 'deploy:unlock');
