<?php

namespace Notes\Services\Controllers;

use Notes\Core\Controllers\AbstractController;
use Notes\Services\Models;
use Notes\Services\Views;
use GuzzleHttp\Psr7\Response;
use Notes\Services\Errors;

class NotesController extends AbstractController
{
    function createNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);

        $jsonValidator = $this->di->get('jsonValidator');

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        $schema = __DIR__  . "/../Schemas/Notes.json";
        if (!$jsonValidator->validate($schema, $request->getParsedBody())) {
            $status = 400;
            $response = new Response($status, $headers, Errors\Notes::UNABLE_TO_CREATE_NOTE($jsonValidator->getErrors()));
            return $response;
        }

        if ($notesObj->createNote($request->getParsedBody(),1)) {
            $status = 201;
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }
    }

    function retrieveNote($request, $response, $args)
    {
        $userId = 1;
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->retrieveNote($userId)) {
            $status = 200;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        } else {
            //TODO: return 404 if note is not found
            //TODO: return 403 if note does not belong to the user
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }
    }

    function updateNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->updateNote($request->getParsedBody(),1,1)) {

        } else {
            //TODO: return 403 if note does not belong to user.
            //TODO: return 404 if note is not found
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }
    }

    function deleteNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->deleteNote(1,1)) {
            //TODO: return 200 if note is deleted succesfully
        } else {
            //TODO: return 403 if note does not belong to user
            //TODO: return 404 if note does not belong to user
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers);
            return $response;
        }
    }

}