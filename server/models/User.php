<?php
namespace Server\Models;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    public function __construct(?string $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function validate(): bool
    {
        if ($this->name == null || $this->email == null || $this->password == null) {
            return false;
        }

        if (empty($this->email || !filter_var($this->email, FILTER_VALIDATE_EMAIL))) {
            return false;
        }
        return true;
    }
}