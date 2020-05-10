<?php


namespace App\Model\User;


interface UserInterface
{
    public function getId();
    public function setId($id): void;
    public function getEmail(): ?string;
    public function setEmail(?string $email): void;
}