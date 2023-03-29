<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank]
    private ?string $name = null;

    #[Assert\Email]
    private ?string $email = null;

    #[Assert\Length(min: 5)]
    #[Assert\NotBlank]
    private ?string $subject = null;

    #[Assert\Length(min: 10)]
    #[Assert\NotBlank]
    private ?string $message = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Contact
     */
    public function setName(?string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     * @return Contact
     */
    public function setSubject(?string $subject): Contact
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }
}
