<?php

namespace Notes\Services\Controllers;

use Notes\Core\Controllers\AbstractController;
use Notes\Services\Models;
use Notes\Services\Views;
use GuzzleHttp\Psr7\Response;

class NotesController extends AbstractController
{
    function createNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->createNote()) {

        } else {
            $status = 400;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }
    }

    function retrieveNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->retrieveNote()) {
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        } else {

        }
    }

    function updateNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->updateNote()) {

        } else {
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }
    }

    function deleteNote($request, $response, $args)
    {
        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->deleteNote()) {

        } else {
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }
    }

}