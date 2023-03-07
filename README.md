# File Upload Wrapper

This library will make it easier for you to handle file uploads.

Example:

```php
class Product {
    //...
    #[Image(requestField: "request_field", dir: "/public")]
    public string $image;
    
    public function getImageFilename(): string
    {
        return $this->image;
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

-----
Keep in touch with me on [Twitter](https://twitter.com/slmdiar) or [LinkedIn](https://www.linkedin.com/in/diarselimi)