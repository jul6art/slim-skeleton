<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', ['.env.local', '.env']);
$dotenv->load();

return [
    'paths' => [
        'migrations' => 'src/Infrastructure/Migrations'
    ],
    'migration_base_class' => 'App\Infrastructure\Persistence\AbstractMigration',
    'default_database' => getenv('DATABASE_NAME'),
    'environments' => [
        'default_migration_table' => 'migration_version',
        'dev' => [
            'adapter' => 'mysql',
            'host' => getenv('DATABASE_HOST'),
            'name' => getenv('DATABASE_NAME'),
            'user' => getenv('DATABASE_USER'),
            'pass' => getenv('DATABASE_PASSWORD'),
            'port' => getenv('DATABASE_PORT')
        ]
    ]
];
