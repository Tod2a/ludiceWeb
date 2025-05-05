<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/Tod2a/ludiceWeb.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('tst.ludice.app')
    ->set('remote_user', 'ludice')
    ->set('deploy_path', '/data/ludice/app');

// Hooks

after('deploy:failed', 'deploy:unlock');
