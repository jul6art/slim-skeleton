composer install --no-suggest
yarn install
npx webpack --mode=production
php vendor/bin/phinx migrate -c app/phinx.php

