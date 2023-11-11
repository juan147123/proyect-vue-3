## necesita
-- php 8
-- node 16

## comandos ejecucion
-- npm install
-- composer install
-- php artisan migrate
-- php artisan serve
-- npm run dev 

# Creación de proyecto

```
> laravel new "nombre de proyecto" --jet
```

-   Seleccionar las opciones según requiera.

# Uso de NVM (seleccionar la versión de node)

-   instalar nvm https://github.com/nvm-sh/nvm
-   crear un archivo .nvmrc en la raíz del proyecto y agregar la version que usara el proyecto

```
v16
```

-   para seleccionar la version se debe correr en una consola bash

```
nvm use `cat .nvmrc`
```
npm install --save bootstrap
npm install --save @popperjs/core
# Generar modelo desde la base de datos con Krlove

-   php artisan krlove:generate:model Business --table-name=business --namespace=App\Models --output-path=Models

# Generar patron repository

-   php artisan make:provider RepositoryServiceProvider
-   composer dump-autoload
-   agregar en config/app.php

````
    'providers' => [
    // ...
    App\Providers\RepositoryServiceProvider::class,
    ],
    ```
````
