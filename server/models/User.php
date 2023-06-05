<?php

namespace Server\Models;
use Server\Models\UserRole;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;

    public function __construct(?string $id, string $name, string $email, string $password, UserRole $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
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
    public function setRole(UserRole $role): void
    {
        $this->role = $role;
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getRole(): UserRole
    {
        return $this->role;
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
