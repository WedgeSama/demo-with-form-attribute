<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Form\Attribute\AsFormType;
use Symfony\Component\Form\Attribute\Type;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Assert;

#[AsFormType]
final class UserProfileDTO
{
    #[Type(options: [
        'label' => 'label.username',
        'disabled' => true,
    ])]
    public ?string $username = null;

    #[Type(options: [
        'label' => 'label.fullname',
    ])]
    #[Assert\NotBlank]
    public ?string $fullName = null;

    #[Type(EmailType::class, [
        'label' => 'label.email',
    ])]
    #[Assert\Email]
    public ?string $email = null;

    public static function fromEntity(User $entity): self
    {
        $dto = new self();

        $dto->username = $entity->getUsername();
        $dto->email = $entity->getEmail();
        $dto->fullName = $entity->getFullName();

        return $dto;
    }

    public function populateEntity(User $entity): User
    {
        $entity->setUsername($this->username);
        $entity->setEmail($this->email);
        $entity->setFullName($this->fullName);

        return $entity;
    }
}
