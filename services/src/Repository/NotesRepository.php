<?php

namespace Notes\Services\Repository;

use Notes\Core\Repository;
use Notes\Core\Database;
use PDO;

class NotesRepository implements Repository\NotesRepositoryInterface
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

    public function create($userId, $title, $content)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $sql = "INSERT INTO notes(title,content,user_id) VALUES(:title,:content,:userId)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    function update($userId, $id, $title, $content)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $sql = "UPDATE notes SET title = :title,content = :content,updated = now() where user_id=:userId and id=:notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function read($userId, $id)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM notes where user_id = ? and id = ?");
        if ($stmt->execute(array($userId, $id))) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    function readAll($userId)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM notes where user_id = ?");
        if ($stmt->execute(array($userId))) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    function delete($userId, $id)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $sql = "DELETE FROM notes WHERE user_id = :userId and id = :notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}