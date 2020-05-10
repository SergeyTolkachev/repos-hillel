<?php


namespace App\Repository\User;


use MongoDB\BSON\ObjectId;
use App\Model\User\{User, UserInterface};
use MongoDB\Client;

final class MongoUserRepository implements UserRepositoryInterface
{
    private Client $client;

    /**
     * MongoUserRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function find($id): UserInterface
    {
        $collection = $this->client->blog->users;
        $data = $collection->findOne(['_id' => new ObjectId($id)]);
        return new User($data->_id, $data->email);
    }

    public function delete(UserInterface $user): void
    {
        $collection = $this->client->blog->users;
        $collection->deleteOne(['_id' => $user->getId()]);
    }

    public function save(UserInterface $user): void
    {
        $collection = $this->client->blog->users;
        if($user->getId()){
            $collection->updateOne(['_id' => $user->getId()], [ '$set' =>['email' => $user->getEmail()]]);
        }else {
            $result=$collection->insertOne(['email' => $user->getEmail()]);
            $user->setId($result->getInsertedId());
        }
    }


}