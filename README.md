<p align="center">
    <a href="https://devinthehood.com"><img src="https://github.com/jul6art/slim-skeleton/blob/master/assets/img/logo.png?raw=true" alt="logo dev in the hood"></a>
</p>

<p align="center">
    <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License"></a>
    <a href="https://github.com/jul6art/slim-skeleton" target="_blank"><img src="https://img.shields.io/static/v1?label=stable&message=v1+coming+soon&color=orange" alt="Version"></a>
</p>

jul6art/slim-skeleton
=====================
Base slim project
-----------------

> :warning: Work in progress so keep calm. The good news: this is maintained!

Requirements
------------

* **php** >= 7.4
* **mysql**
* **composer**
* **yarn**

Includes
--------

* **<a href="https://github.com/vlucas/phpdotenv" target="_blank">dotenv</a>**
* **<a href="https://github.com/slimphp/Twig-View" target="_blank">twig</a>**
* **<a href="https://github.com/nette/finder" target="_blank">finder</a>**
* **<a href="https://github.com/fullpipe/twig-webpack-extension" target="_blank">webpack</a>**
* **<a href="https://github.com/illuminate/database" target="_blank">illuminate</a>**
* **swiftmailer**

Commands
--------

Available commands (see **hook_local.sh** file)

Composer

```console
$ composer install --no-suggest
```

Yarn

```console
yarn install
```

Webpack

```console
npx webpack --mode=development
```

Drop database

```console
$ composer cli skeleton:database:drop
```

Migrations (located in **src/Infrastructure/Migrations** directory)

```console
$ vendor/bin/phinx create MyFirstMigration -c app/phinx.php   ## generate a migration
$ vendor/bin/phinx migrate -c app/phinx.php                   ## migrate
```

Fixtures (located in **src/Infrastructure/Fixtures** directory and declare in **settings.php** in fixtures section)

```console
$ composer cli skeleton:fixtures:load
```

Commands must be placed in **src/Application/Command** directory and implement **src/Application/Command/CommandInterface**

```php
<?php

namespace App\Application\Command;

use RuntimeException;

/**
 * Class SampleCommand
 * @package App\Application\Command
 */
class SampleCommand extends AbstractCommand
{
    /**
     * @param $args
     * @return int
     */
    public function command($args): int
    {
        $this->info('Creating sample');

        // Access items in container
        $settings = $this->container->get('settings');

        // Throw if no arguments provided
        if (empty($args)) {
            throw new RuntimeException("ERROR! No arguments passed to command");
        }

        $this->write("Argument 0: {$args[0]}");

        $this->success('Sample successfully created');

        return 0;
    }
}
```

Declare your command in **settings.php** in commands section.

```php
$containerBuilder->addDefinitions([
    'commands' => [
        'skeleton:sample' => SampleCommand::class,
    ],
]);
```

You can now call that command with composer

```console
$ composer cli skeleton:sample arg1 arg2
```

License
-------

The Slim Skeleton is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

&copy; 2019 [dev in the hood](https://devinthehood.com)
