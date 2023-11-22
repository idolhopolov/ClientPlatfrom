<?php

declare(strict_types=1);

namespace App\Application\User\Command\SignUp\Input\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SignUpUserPayload
{
    public function __construct(
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    #[Assert\NotBlank(['message' => 'Email cannot be blank'])]
    #[Assert\Email(['message' => 'Email must be valid'])]
    #[Assert\Length([
            'min' => 2, 'minMessage' => 'Email should be at least 2 characters long',
            'max' => 100, 'maxMessage' => 'Email can be up to 100 characters long']
    )]
    public string $email;

    #[Assert\NotBlank(['message' => 'Name cannot be blank'])]
    #[Assert\Length([
            'min' => 2, 'minMessage' => 'Name should be at least 2 characters long',
            'max' => 100, 'maxMessage' => 'Name can be up to 100 characters long']
    )]
    public string $firstName;

    #[Assert\NotBlank(['message' => 'Surname cannot be blank.'])]
    #[Assert\Length([
        'min' => 2,
        'minMessage' => 'Surname should be at least 2 characters long.',
        'max' => 100,
        'maxMessage' => 'Surname can be up to 100 characters long.'
    ])]
    public string $lastName;

    #[Assert\NotBlank(['message' => 'Password cannot be blank.'])]
    #[Assert\Length([
        'min' => 6,
        'minMessage' => 'Password should be at least 6 characters long',
        'max' => 100,
        'maxMessage' => 'Password can be up to 100 characters long'
    ])]
    public string $password;
}