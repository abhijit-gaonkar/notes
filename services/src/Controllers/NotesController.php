<?php

namespace Notes\Services\Controllers;

use Notes\Core\Controllers\AbstractController;

class NotesController extends AbstractController
{
    function createNote($request, $response, $args)
    {
        echo 'create';
    }

    function retrieveNote($request, $response, $args)
    {
        echo 'get';
    }

    function updateNote($request, $response, $args)
    {
        echo 'update';
    }

    function deleteNote($request, $response, $args)
    {
        echo 'delete';
    }

}