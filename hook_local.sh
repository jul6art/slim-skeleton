composer install --no-suggest
yarn install
npx webpack --mode=development

composer cli skeleton:database:drop
php vendor/bin/phinx migrate -c app/phinx.php
