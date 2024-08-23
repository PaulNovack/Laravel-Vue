php artisan create-project taskapp
cd taskapp
composer require fakerphp/faker
npm install
npm install vue@latest vue-loader@next
npm i @vitejs/plugin-vue
npm install --save @headlessui/vue @heroicons/vue sortablejs vuedraggable
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

composer require laravel/pint --dev
composer require nunomaduro/larastan --dev

If there are issues running php artisan test as I had remove node_modules and re-install
rm -rf node_modules
npm install
npm run build

php artisan test

npm install --save-dev eslint prettier eslint-plugin-vue eslint-plugin-prettier eslint-config-prettier
