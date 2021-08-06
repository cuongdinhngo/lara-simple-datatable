# Laravel Simple Datatable

Laravel Simple Datatable enhances the accessibility of data in HTML tables

[https://github.com/cuongnd88/lara-simple-datatable](https://github.com/cuongnd88/lara-simple-datatable)


```php
php artisan vendor:publish --provider="Cuongnd88\LaraSimpleDatatable\LaraSimpleDatatableServiceProvider"
```

`app\config.php`

```php
. . . .
    'aliases' => [
        . . . .
        'SimpleDatatable' => Cuongnd88\LaraSimpleDatatable\Facades\SimpleDatatableFacade::class,
    ],
```