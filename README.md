# File Upload Wrapper

This library will make it easier for you to handle file uploads.

Example:

```php

class Product {
    //...
    #[Image(requestField: "request_field", dir: "/public")]
    private string $image;
    
    public function getImageFilename(): string
    {
        return $this->image;
    }
}
```

```php
class ProductCreationController {

    public function exec($request Request): JsonResponse
    {
        $product = new Product();
        
        File::upload($product, [
                new FileType([FileType::JPEG]),
                new FileSize(2, Size::MB)
        ]); 
        // some other stuff
        echo $product->getImageFilename();
    }
}
```