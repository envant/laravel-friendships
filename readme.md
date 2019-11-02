# Laravel Friendships – WIP. Don't use in production

Add friendships to your Laravel application

## Installation

Install package through Composer

``` bash
$ composer require envant/friendships
```

You can publish the migration with:

``` bash
$ php artisan vendor:publish --provider="Envant\Friendships\FriendshipsServiceProvider" --tag="migrations"
```

After the migration has been published you can create the table by running the migrations:

``` bash
$ php artisan migrate
```

You can publish the config with:

``` bash
$ php artisan vendor:publish --provider="Envant\Friendships\FriendshipsServiceProvider" --tag="config"
```

## Usage
To be written

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Boris Lepikhin][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.