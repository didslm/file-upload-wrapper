# File Upload Wrapper

This library will make it easier for you to handle file uploads.

Example:

```php
class Product {
    //...
    #[Image(requestField: "request_field", dir: "/public")]
    public string $image;
    
    #[Image(requestField: "profile", dir: "/public", required: false)]
    public string $profile;
    
    public function getImageFilename(): string
    {
        return $this->image;
    }
    
    public function getProfileFilename(): string
    {
        return $this->profile;
    }
}
```

```php
$product = new Product();

File::upload($product, [
        new FileType([Type::JPEG]),
        new FileSize(2, Size::MB)
]);

echo $product->getImageFilename();
```

> Keep in mind the field in your entity must be public.


### Example of wrapping in a try catch
All the exceptions that can be thrown are extending the main `FileUploadException` class.

```php
try {
    File::upload($product, [
        new FileType([Type::PNG]),
        new FileSize(2, Size::MB)
    ]);
} catch (FileUploadException $e) {
    // handle exception
}
```

### Validation
Currently, there are the following checks that you can use 


`Type`

Check for file types (png, jpg, gif)
```php
new FileType([Type::PNG, Type::JPEG, Type::GIF])
```


`Size`

Validates if the file is less than the specified size.
```php
new FileSize(2, Size::MB)
new FileSize(200, Size::KB)
```


`Dimension`

Validates if the dimensions of the images are not bigger than specified
```php
new Dimension(200, 200)
```

### Specific file validation

This shows you how you can target a group of validations into a specific field in your entity.
```php
$profileValidations = new FieldValidations("profile", [
    new Dimension(200, 200)
]);

File::upload($product, [
    new FileType([Type::PNG, Type::JPEG, Type::GIF]),
    new FileSize(2, Size::MB),
    $profileValidations,
])
```

```php

-----
Keep in touch with me on [Twitter](https://twitter.com/slmdiar) or [LinkedIn](https://www.linkedin.com/in/diarselimi)