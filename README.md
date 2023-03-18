# File Upload Wrapper

The File Upload Wrapper is a PHP library that simplifies file uploads by providing a set of easy-to-use classes that handle common validation and processing tasks. 
With this library, you can:

- Validate uploaded files with ease
- Process uploaded files with targeted validations for specific fields
- Simplify the file upload process with a set of easy-to-use classes

# Getting Started

To use the library, follow these steps:

1. Install the library using Composer:

```sh
composer require didslm/file-upload-wrapper
```

2. Import the classes you need:

```php
use Didslm\FileUpload\Uploader;
use Didslm\FileUpload\UploaderInterface;
use Didslm\FileUpload\File;
use Didslm\FileUpload\Validation\FileSize;
use Didslm\FileUpload\Validation\FileType;
use Didslm\FileUpload\Validation\Dimension;
use Didslm\FileUpload\FieldValidation;
use Didslm\FileUpload\Attributes\Image;
use Didslm\FileUpload\Attributes\Document;
use Didslm\FileUpload\Exceptions\FileUploadException;
```

3. Use the `upload()` method to handle file uploads for your entity:

```php
class Product {
    #[Image(requestField: "request_field", dir: "/public")]
    private string $image;
    
    #[Image(requestField: "profile_field", dir: "/public")]
    private string $profile;
    
    // ...
}

$product = new Product();

Uploader::upload($product, [
    new FileType([File::JPEG]),
    new FileSize(2, File::MB)
]);

```

4. The same exmaple you can do via Dependency Injection:

```php
class ProductController {
    public function __construct(private UploaderInterface $uploader){}
    
    public function upload(Request $request)
    {
        $product = new Product();
        
        $this->uploader->upload($product, [
            new FileType([File::IMAGES]),
            new FileSize(2, File::MB)
        ]);
    }
}
```

At the end of this document you can see how to configure in Laravel or Symfony.

----

# Examples

### Handling File Uploads for an Entity

The following code shows an example of how to use the library to handle file uploads for an entity:

```php
class Product {
    //...
    #[Image(requestField: "request_field", dir: "/public")]
    private string $image;
    
    #[Image(requestField: "profile_field", dir: "/public")]
    private string $profile;
    
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

In this example, the `Product` class has two properties `image` and `profile` that are decorated with the `Image` attribute. 

### Types

In the following example you will see a list of available Attribute types:

```php
#[new Image(requestName: 'file_upload_field', dir: '/upload/dir')]
#[new Document(requestName: 'cv_file', dir: '/upload/dir')]
#[new Video(requestName: 'video_file', dir: '/upload/dir')]
```

The `Image` attribute provides metadata to the library to process the files correctly during the upload.

The `Document` attribute provides metadata to the library to process the files correctly during the upload.

The `Video` attribute provides metadata to the library to process the files correctly during the upload.

The `upload()` method is then called on the `Uploader` class with the `Product` object and an array of validation rules as its parameters.

```php
$product = new Product();

Uploader::upload($product, [
    new FileType([File::JPEG]),
    new FileSize(2, File::MB)
]);

echo $product->getImageFilename();

```

# Handling Exceptions

The library provides a `FileUploadException` class that all exceptions thrown by the library extend. This means that you can catch all exceptions using `FileUploadException` in a try-catch block, as shown below:
```php
try {
    Uploader::upload($product, [
        new FileType([File::PNG]),
        new FileSize(2, File::MB)
    ]);
} catch (FileUploadException $e) {
    // handle exception
}
```

# Validation

The library provides several validation classes that you can use to validate uploaded files. These classes can be passed as parameters to the `upload()` method to specify the validation rules for the files being uploaded.


### Type

The `FileType` class is used to check the file type. You can specify the types of files allowed by passing an array of file types to the constructor. For example:

```php
new FileType([File::PNG, File::JPEG, File::GIF])
```

### Size

The `FileSize` class is used to validate the file size. You can specify the maximum file size allowed by passing the size in bytes to the constructor. Alternatively, you can use the Size class to specify the size in a more readable format. For example:
```php
new FileSize(2, File::MB)
new FileSize(200, File::KB)

```

### Dimension

The `Dimension` class is used to validate the dimensions of images. You can specify the maximum width and height of the image by passing them as parameters to the constructor. For example:
```php
new Dimension(200, 200)
```

### Targeted Validations

You can also target specific fields in your entity with a set of validations. 
To do this, you can use the `FieldValidations` class, which takes the request field name as it's first parameter and an array of validation rules as its second parameter. Here's an example:

```php
$profileValidations = new FieldValidations("profile_field", [
    new Dimension(200, 200),
    new FileSize(2, File::MB)
]);

Uploader::upload($product, [
    new FileType([File::PNG, File::JPEG, File::GIF]),
    $profileValidations,
]);
```

In the example above, we are specifying a set of validation checks that apply to the profile field in the Product entity. These checks will only be applied to the profile image uploaded by the user.

# Frameworks Implementation 

The library is framework agnostic, which means that you can use it with any framework.

The following sections show how to configure the library in some of the most popular frameworks.

## Symfony 

In your Symfony app you can easily configure the library in your `services.yaml` file:

```yaml
services:
    Didslm\FileUpload\:
        resource: '../vendor/didslm/file-upload-wrapper/src/*'
```

## Laravel

In your Laravel app you can easily configure the library in your `AppServiceProvider.php` file:

```php
public function register()
{
    $this->app->bind(UploaderInterface::class, function (){
         return UploaderFactory::create();
    });
}
```

-----
Handling file uploads can be a complicated and error-prone task, but with this library, you can simplify the process and focus on building the features that matter. If you have any questions or feedback, feel free to reach out to the author on [Twitter](https://twitter.com/slmdiar) or [LinkedIn](https://linkedin.com/in/diarselimi).