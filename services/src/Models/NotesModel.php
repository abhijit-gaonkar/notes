<?php

namespace Notes\Services\Models;

use Notes\Core\Models\AbstractModel;

class NotesModel extends AbstractModel
{
    function createNote($request, $userId)
    {
        $pdo = $this->di->get("pdoObject");

        $sql = "INSERT INTO notes(title,content,user_id)VALUES (
            :title,
            :content
            :userId)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $request['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $request['content'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        $stmt->execute();
    }

    function retrieveNote($userId, $notesId = null)
    {
        $pdo = $this->di->get("pdoObject");

        $sql = 'SELECT *
    FROM notes
    WHERE user_id = :userId AND notes = :notesId';
        $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':userId' => $userId, ':notesId' => $notesId));
    }

    function updateNote($request, $userId, $notesId)
    {
        $pdo = $this->di->get("pdoObject");

        $sql = "UPDATE movies SET title = :title,
            content = :content where user_id= :userId and notes_id= :notesId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $request['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $request['content'], PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        $stmt->execute();
    }

    function deleteNote($userId, $notesId)
    {
        $pdo = $this->di->get("pdoObject");

        $sql = "DELETE FROM movies WHERE user_id = :userId and id = :notesID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':notesId', $notesId, PDO::PARAM_INT);
        $stmt->execute();
    }

}