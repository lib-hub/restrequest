# RestRequest

[![PHP version](https://img.shields.io/badge/PHP-7.4-787CB5.svg?style=flat&logo=PHP)](https://docs.npmjs.com)
[![Composer version](https://img.shields.io/badge/Composer-latest-787CB5.svg?style=flat&logo=composer)]()
[![Project version](https://img.shields.io/badge/Version-1.0.1-informational.svg?style=flat)]()

A PHP curl wrapper to make it easier to create RESTFul requests with PHP.

# Install
`composer require lib-hub/restrequest`

# Use

Basic example
```php
$productsRequest = new RestRequest($baseUrl . "/product");

$productsRequest->post("payload"); // create new product
$productsRequest->put("1", "data"); // update first product
$productsRequest->patch("1", "data"); // edit first product
$productsRequest->delete("1"); // delete first product
$productsRequest->get(); // get all products
$productsRequest->get("1"); // get first product
```
