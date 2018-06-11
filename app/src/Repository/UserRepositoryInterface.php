<?php

namespace Notes\Core\Repository;

interface UserRepositoryInterface
{
    function getUserIdFromEmail($email);

}