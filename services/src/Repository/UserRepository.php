<?php

namespace Notes\Services\Repository;

use Notes\Core\Repository;
use Notes\Core\Database;

class UserRepository implements Repository\UserRepositoryInterface
{
    private $connection;

    public function __construct()
    {
        /** @var \PDO $this ->connection */
        $this->connection = Database\ConnectDb::getInstance()->getConnection();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getUserIdFromEmail($email)
    {
        /** @var \PDO $pdo */
        $pdo = $this->getConnection();

        $stmt = $pdo->prepare("SELECT id FROM user where email = ?");
        if ($stmt->execute(array($email))) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['id'];
        }
    }

}