<?php


namespace App\Services;


use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiImageValidation
{
    private $validator;
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function image_validate($path): \Symfony\Component\Validator\ConstraintViolationListInterface
    {
        $file = new \Symfony\Component\HttpFoundation\File\File($path);
        return $this->validator->validate(
            $file,
            [
                new NotBlank([
                    'message' => 'Please select file to upload!'
                ]),
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/*'
                    ],
                    'maxSizeMessage' => 'Oops! Image is bigger than what I expected!',
                    'mimeTypesMessage' => 'This file is not an image!'
                ]),

            ]
        );
    }
}