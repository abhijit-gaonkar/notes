<?php

namespace Notes\Services\Models;

use Notes\Core\Models\AbstractModel;
use \PDO;

class NotesModel extends AbstractModel
{
    /**
     * @param $request
     * @param $userId
     * @return string
     */
    function createNote($request, $userId)
    {
        /** @var \PDO $pdo */
        $pdo = $this->di->get("pdoObject")->getConnection();

        $sql = "INSERT INTO notes(title,content,user_id) VALUES(:title,:content,:userId)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $request['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $request['content'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        //TODO: try catch and return 500 if issue with execution
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    /**
     * @param $request
     * @param $userId
     * @return string
     */
    function retrieveNote($userId, $notesId)
    {
        /** @var \PDO $pdo */
        $pdo = $this->di->get("pdoObject")->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM notes where user_id = ? and id = ?");
        if ($stmt->execute(array($userId, $notesId))) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * @param $request
     * @param $userId
     * @return string
     */
    function updateNote($request, $userId, $notesId)
    {
        /** @var \PDO $pdo */
        $pdo = $this->di->get("pdoObject")->getConnection();

        $sql = "UPDATE notes SET title = :title,content = :content,updated = now() where user_id=:userId and id=:notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $request['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $request['content'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        //TODO: try catch and return 500 if issue with execution
        return $stmt->execute();
    }

    /**
     * @param $request
     * @param $userId
     * @return string
     */
    function deleteNote($userId, $notesId)
    {
        /** @var \PDO $pdo */
        $pdo = $this->di->get("pdoObject")->getConnection();

        $sql = "DELETE FROM notes WHERE user_id = :userId and id = :notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        //TODO: try catch and return 500 if issue with execution
        return $stmt->execute();
    }

}