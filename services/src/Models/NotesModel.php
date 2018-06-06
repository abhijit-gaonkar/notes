<?php

namespace Notes\Services\Models;

use Notes\Core\Models\AbstractModel;

use \PDO;

class NotesModel extends AbstractModel
{
    function createNote($request, $userId)
    {
        $pdo = $this->di->get("pdoObject")->getConnection();

        $sql = "INSERT INTO notes(title,content,user_id) VALUES(:title,:content,:userId)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $request['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $request['content'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        //TODO: try catch and return 500 if issue with execution
        try {
            $result = $stmt->execute();
        } catch (\PDOException $e) {

        }

    }

    function retrieveNote($userId, $notesId = 1)
    {
        /** @var \PDO $pdo */
        $pdo = $this->di->get("pdoObject")->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM notes where user_id = ? and id = ?");
        if ($stmt->execute(array($userId, $notesId))) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                print_r($row);
            }
        }
    }

    function updateNote($request, $userId, $notesId)
    {
        $pdo = $this->di->get("pdoObject")->getConnection();

        $sql = "UPDATE movies SET title = :title,content = :content where user_id= :userId and notes_id= :notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $request['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $request['content'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        //TODO: try catch and return 500 if issue with execution
        $stmt->execute();
    }

    function deleteNote($userId, $notesId)
    {
        $pdo = $this->di->get("pdoObject")->getConnection();

        $sql = "DELETE FROM movies WHERE user_id = :userId and id = :notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        //TODO: try catch and return 500 if issue with execution
        $stmt->execute();
    }

}