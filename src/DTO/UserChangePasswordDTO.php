<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Form\Attribute\AsFormType;
use Symfony\Component\Form\Attribute\Type;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[AsFormType]
final class UserChangePasswordDTO implements PasswordAuthenticatedUserInterface
{
    #[Type(PasswordType::class, [
        'label' => 'label.current_password',
        'attr' => [
            'autocomplete' => 'off',
        ],
    ])]
    #[UserPassword]
    public ?string $oldPassword = null;

    /**
     * @todo
     * Need to remove {@see \Symfony\Component\Form\Extension\PasswordHasher\EventListener\PasswordHasherListener::assertNotMapped}
     * to work. Will be done in a dedicated PR.
     */
    #[Type(RepeatedType::class, [
        'type' => PasswordType::class,
        'first_options' => [
            'hash_property_path' => 'password',
            'label' => 'label.new_password',
        ],
        'second_options' => [
            'label' => 'label.new_password_confirm',
        ],
    ])]
    #[NotBlank]
    #[Length(min: 5, max: 128)]
    public ?string $newPassword = null;

    public ?string $password = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function populateEntity(User $entity): User
    {
        $entity->setPassword($this->password);

        return $entity;
    }
}
