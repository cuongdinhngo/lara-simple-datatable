# Laravel Simple Datatable

Laravel Simple Datatable enhances the accessibility of data in HTML tables

[https://github.com/cuongnd88/lara-simple-datatable](https://github.com/cuongnd88/lara-simple-datatable)

1-Install `cuongnd88/lara-simple-datatable` using Composer.

```php
$ composer require cuongnd88/lara-simple-datatable
```

2-Add the following service provider in `config/app.php`

```php
<?php
// config/app.php
return [
    // ...
    'aliases' => [
        . . . .
        'SimpleDatatable' => Cuongnd88\LaraSimpleDatatable\Facades\SimpleDatatableFacade::class,
    ],
    // ...
];
```

You can modify the `Simple Datatable` interface by copying its components to your local config directory:

```php
php artisan vendor:publish --provider="Cuongnd88\LaraSimpleDatatable\LaraSimpleDatatableServiceProvider"
```

## Sample Usage

Let start `code less` with [Laravel Simple Datatable](https://github.com/cuongdinhngo/lara-colab/blob/4eb67f2f116f129a372667a8f5c981c52d6611b9/alpha/app/Http/Controllers/User/UserController.php#L41)

```php
....
use SimpleDatatable;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = SimpleDatatable::buildQuery(User::query())
                    ->setPerPage(10)
                    ->addIncrement(function($value) {
                        return "#{$value["increment"]}";
                    })
                    ->editColumn('id', function($value) {
                        return "[{$value["id"]}]";
                    })
                    ->editColumn('name', 'user.partials.name')
                    ->addColumn('action', 'user.partials.action')
                    ->make();

        return view('user.index', ['users' => $users]);
    }
}
```

_`buildQuery(Builder $query)`: set Query build._

_`setPerPage(int $perPage)` is to set quantity of items per page._

_`addIncrement($callback)` is to add increment number._

_`editColumn(string $key, $callback|$view)` is to edit existed column._

_`addColumn(string $key, $callback|$view)` is to add mroe column._

_`make()` is to make simple datatable._


Simple Datatable makes your job more easier to render view by using `@simpleDatatable` and `@simplePaginator`

[index.blade.php](https://github.com/cuongdinhngo/lara-colab/blob/4eb67f2f116f129a372667a8f5c981c52d6611b9/alpha/resources/views/user/index.blade.php#L1)

```
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Simple Datatable</div>

                <div class="card-body">
                    @simpleDatatable(['data' => $users, 'view' => simple_table_view('users')])
                    @endsimpleDatatable

                    @simplePaginator(['data' => $users, 'appends' => ['name' => 'cuong.ngo']])
                    @endsimplePaginator
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

```


_`@simpleDatatable(array $result)`: $result must has key `data` for content and key `view` for setting views._

_`@simplePaginator(array $result)`: $result must has key `data` for content and key `appends` is optional for your extend data (ex: http://localhost:8080/users?name=cuong.ngo&page=10)._

_`simple_table_view(string $view)`: is to set table headers which is loaded from [simple-datatable.php](https://github.com/cuongdinhngo/lara-colab/blob/master/alpha/config/simple-datatable.php) in config folder ._


```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default paginator view
    |--------------------------------------------------------------------------
    |
    */
    'paginator_view' => 'components.simple-datatable.default-bootstrap-4',

    /*
    |--------------------------------------------------------------------------
    | Default simple paginator view
    |--------------------------------------------------------------------------
    |
    */
    'simple_paginator_view' => 'components.simple-datatable.default-bootstrap-4',

    /*
    |--------------------------------------------------------------------------
    | Default makeup for simple table view
    |--------------------------------------------------------------------------
    |
    */
    'default_table_makeup' => 'table-striped table-hover',

    /*
    |--------------------------------------------------------------------------
    | Setting views for specified datatable
    |--------------------------------------------------------------------------
    |
    */
    'views' => [
        'users' => [
            'items' => [
                'increment' => '#',
                'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
                'action' => '',
            ],
        ],
    ],
];
```

- To modify the view of column, you can create blade file as `addColumn('action', 'user.partials.action')`

[user.partials.action](https://github.com/cuongdinhngo/lara-colab/blob/master/alpha/resources/views/user/partials/action.blade.php)

```php
<a href="user/{{$id}}">Edit</a> | <a href="user/{{$id}}/remove">Remove</a>
```

- You also modify the view of whole table, you can see at [simple-datatable.blade.php](https://github.com/cuongdinhngo/lara-colab/blob/master/alpha/resources/views/components/simple-datatable/simple-datatable.blade.php)

```php
@php
$makeup = $view['makeup'] ?? '';
$keys = array_keys($view['items']);
$headLabels = array_values($view['items']);
@endphp
<table class="table {{$makeup}}">
    <thead>
        <tr>
            @foreach ($headLabels as $label)
                <th scope="col">{{$label}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                @foreach ($keys as $key)
                    <td>{{ $item[$key] ?? '' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
```
