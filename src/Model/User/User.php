<?php


namespace App\Model\User;


final class User implements UserInterface
{
    /**
    * @param int|null|object
    */
    private $id;

    private ?string $email;

    /**
     * User constructor.
     * @param int|null|object $id
     * @param string|null $email
     */
    public function __construct($id, ?string $email)
    {
        $this->setId($id);
        $this->setEmail($email);
    }

    /**
     * @return int|null|object
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null|object $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

}