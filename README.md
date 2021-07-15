# php-gravityzone-api
This package aims to provide a PHP API for the BitDefender Gravityzone REST API.
It supports all documented functions and is fully tested.

## Structure
```
src/
tests/
vendor/
```

## Install

Via Composer

```bash
$ composer require indiana-university/php-gravityzone-api
```

## Usage

```php
use IndianaUniversity\GravityZone\GravityZone;

$gz = new GravityZone(
    'gravityzone.example.net',
    'your api key goes here'
);

$quaratinedItems = $gz->getQuarantineItemsList('virtualmachines');
foreach ($quarantinedItems as $item) {
    print_r($item);
}
```

## Change log
Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed
recently

## Testing
```bash
$ composer test
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) and 
[CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## License
The BSD 3 Clause (BSD-3-Clause). Please see [License File](LICENSE.md) for more
information