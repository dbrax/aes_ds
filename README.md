[![Latest Version on Packagist](https://img.shields.io/packagist/v/epmnzava/ae_ds.svg?style=flat-square)](https://packagist.org/packages/epmnzava/ae_ds)
[![Total Downloads](https://img.shields.io/packagist/dt/epmnzava/ae_ds.svg?style=flat-square)](https://packagist.org/packages/epmnzava/ae_ds)
![GitHub Actions](https://github.com/epmnzava/ae_ds/actions/workflows/main.yml/badge.svg)

## Installation

You can install the package via composer:

```bash
composer require epmnzava/ae_ds
```

## Usage

### get access token and refresh token

```php

        $ae = new AeDs($api_key,$api_secret,$code);
        $token=$ae->getAccessToken();

        //then store both token and refresh token on database or file to use later
```

### get categories

```php

        $ae = new AeDs($api_key,$api_secret,$code);
        $res = $ae->getCategories("en");
        // it will give list of categories
```

### get category

```php

        $ae = new AeDs($api_key,$api_secret,$code);

        $lang="en";
        $res = $ae->getCategoryById($categoryid,$lang);

          // it will give details of one category
```

### get products on feedname

```php

        $ae = new AeDs($api_key,$api_secret,$code);
        //used feedname tanzaniaselection for Tanzania targeted products   i.e $category_id=6 for home appliace
        $res = $ae->$ae->getItemListByFeedName("tanzaniaselection", $page_no, $page_size, $category_id);
        // it will give list of products on category_id , if no category id you will get all products
```

### get product

```php

        $ae = new AeDs($api_key,$api_secret,$code);
        $token = $ae->getRefreshToken($refresh_token);

        $res = $ae->getProduct($token, $product_id);
          // it will give you only one product with all details
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email epmnzava@gmail.com instead of using the issue tracker.

## Credits

- [Emmanuel paul Mnzava](https://github.com/epmnzava)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
