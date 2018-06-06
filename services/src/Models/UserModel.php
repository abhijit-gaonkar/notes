<?php

namespace Notes\Services\Models;

use Notes\Core\Models\AbstractModel;

use \PDO;

class UserModel extends AbstractModel
{

    /**
     * @param $email
     *
     * @return array
     */
    function getUserIdFromEmail($email)
    {
        /** @var \PDO $pdo */
        $pdo = $this->di->get("pdoObject")->getConnection();

        $stmt = $pdo->prepare("SELECT id FROM user where email = ?");
        if ($stmt->execute(array($email))) {
            $result =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
    }
}