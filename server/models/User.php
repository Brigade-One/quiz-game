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

    public function __construct(?string $id, ?string $name, string $email, string $password, ?UserRole $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function setID(string $id): void
    {
        $this->id = $id;
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
    public function toJSON()
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);
    }
    public static function fromJSON(string $json): User
    {

        $data = json_decode($json, true);

        $id = isset($data['id']) ? $data['id'] : null;
        $name = isset($data['name']) ? $data['name'] : null;
        $email = isset($data['email']) ? $data['email'] : null;
        $password = isset($data['password']) ? $data['password'] : null;
        $role = isset($data['role']) ? $data['role'] : UserRole::RegularUser;


        return new User(
            $id,
            $name,
            $email,
            $password,
            $role
        );
    }
}