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
class ProductCreationController {

    public function exec($request Request): JsonResponse
    {
        $product = new Product();
        
        File::upload($product, [
                new FileType([Type::JPEG]),
                new FileSize(2, Size::MB)
        ]); 
        // some other stuff
        echo $product->getImageFilename();
    }
}
```

> Keep in mind the field in your entity must be public.

-----
Keep in touch with me on [Twitter](https://twitter.com/slmdiar) or [LinkedIn](https://www.linkedin.com/in/diarselimi)