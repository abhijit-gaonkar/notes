<?php

namespace Notes\Core\Repository;

interface NotesRepositoryInterface
{
    function create($userId, $title, $content);

    function update($userId, $id, $title, $content);

    function read($userId, $id);

    function readAll($userId);

    function delete($userId, $id);
}