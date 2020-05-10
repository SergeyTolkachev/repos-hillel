<?php


namespace App\Repository\User;


use App\Model\User\{User, UserInterface};

final class PdoUserRepository implements UserRepositoryInterface
{
    private \PDO $pdo;

    /**
     * PdoUserRepository constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find($id): UserInterface
    {
        $sql = 'select * from `users` where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new User($data['id'], $data['email']);
    }

    public function delete(UserInterface $user): void
    {
        $sql = 'delete from `users` where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $user->getId());
        $stmt->execute();
    }

    public function save(UserInterface $user): void
    {
        if ($user->getId()){
            $sql = 'update `users` set email = :email where id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $user->getId());
            $stmt->bindValue(':email', $user->getEmail());
            $stmt->execute();
        } else {
            $sql = 'insert into `users` set email = :email';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $user->getEmail());
            $stmt->execute();
            $sql = 'select last_insert_id()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $user->setId($result['last_insert_id()']);
        }
    }

}