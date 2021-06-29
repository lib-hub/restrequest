# RestRequest

[![PHP version](https://img.shields.io/badge/PHP-7.4-787CB5.svg?style=flat&logo=PHP)](https://docs.npmjs.com)
[![Project version](https://img.shields.io/badge/Version-0.0.1-informational.svg?style=flat)]()

A PHP curl wrapper to make it easier to create RESTFul request with PHP.

# Install
```JSON
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/lib-hub/restrequest"
    }
  ],
  "require": {
    "lib-hub/restrequest": "dev-master"
  }
}
```

# Use

Basic example
```php
$productsRequest = new RestRequest("BaseURL");

$productsRequest->post("payload"); // create new product
$productsRequest->put("1", "data"); // update first product
$productsRequest->patch("1", "data"); // edit first product
$productsRequest->delete("1"); // delete first product
$productsRequest->get(); // get all products
$productsRequest->get("1"); // get first product
```