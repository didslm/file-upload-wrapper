# File Upload Wrapper

The File Upload Wrapper is a PHP library that simplifies file uploads by providing a set of easy-to-use classes that handle common validation and processing tasks. The library provides an `upload()` method that takes an entity object and an array of validation rules, and then performs file uploads while also applying the specified validations.

# Examples

### Handling File Uploads for an Entity

The following code shows an example of how to use the library to handle file uploads for an entity:

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

In this example, the `Product` class has two properties `image` and `profile` that are decorated with the `Image` attribute. 
The `Image` attribute provides metadata to the library to process the files correctly during the upload.

The `upload()` method is then called on the `File` class with the `Product` object and an array of validation rules as its parameters.

```php
$product = new Product();

File::upload($product, [
    new FileType([Type::JPEG]),
    new FileSize(2, Size::MB)
]);

echo $product->getImageFilename();

```

# Handling Exceptions

The library provides a `FileUploadException` class that all exceptions thrown by the library extend. This means that you can catch all exceptions using `FileUploadException` in a try-catch block, as shown below:
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

# Validation

The library provides several validation classes that you can use to validate uploaded files. These classes can be passed as parameters to the upload() method to specify the validation rules for the files being uploaded.


### Type

The `FileType` class is used to check the file type. You can specify the types of files allowed by passing an array of file types to the constructor. For example:

```php
new FileType([Type::PNG, Type::JPEG, Type::GIF])
```

### Size

The `FileSize` class is used to validate the file size. You can specify the maximum file size allowed by passing the size in bytes to the constructor. Alternatively, you can use the Size class to specify the size in a more readable format. For example:
```php
new FileSize(2, Size::MB)
new FileSize(200, Size::KB)

```

### Dimension

The `Dimension` class is used to validate the dimensions of images. You can specify the maximum width and height of the image by passing them as parameters to the constructor. For example:
```php
new Dimension(200, 200)
```

### Targeted Validations

You can also target specific fields in your entity with a set of validations. To do this, you can use the FieldValidations class, which takes the field name as its first parameter and an array of validation rules as its second parameter. Here's an example:

```php
$profileValidations = new FieldValidations("profile", [
    new Dimension(200, 200),
    new FileSize(2, Size::MB)
]);

File::upload($product, [
    new FileType([Type::PNG, Type::JPEG, Type::GIF]),
    $profileValidations,
]);
```

In the example above, we are specifying a set of validation checks that apply to the profile field in the Product entity. These checks will only be applied to the profile image uploaded by the user.

-----

Handling file uploads can be a complicated and error-prone task, but with this library, you can simplify the process and focus on building the features that matter. If you have any questions or feedback, feel free to reach out to the author on Twitter or LinkedIn.