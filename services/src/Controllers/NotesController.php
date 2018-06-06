<?php

namespace Notes\Services\Controllers;

use Notes\Core\Controllers\AbstractController;
use Notes\Core\Validators\JsonValidator;
use Notes\Services\Models;
use Notes\Services\Views;
use GuzzleHttp\Psr7\Response;
use Notes\Services\Errors;

class NotesController extends AbstractController
{
    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function createNote($request, $response, $args)
    {
        /** @var Models\NotesModel  $notesObj */
        $notesObj = $this->di->get(Models\NotesModel::class);
        
        /** @var JsonValidator $jsonValidator */
        $jsonValidator = $this->di->get('jsonValidator');

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        $schema = __DIR__ . "/../Schemas/Notes.json";
        if (!$jsonValidator->validate($schema, $request->getParsedBody())) {
            $status = 400;
            $response = new Response($status, $headers,
                Errors\Notes::UNABLE_TO_CREATE_NOTE(json_encode($jsonValidator->getErrors())));
            return $response;
        }

        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->di->get(Models\UserModel::class)->getUserIdFromEmail($bearerInfo["email"]);
        $noteIdentifier = $notesObj->createNote($request->getParsedBody(),$userIdentifier);
        $status = 201;
        $view = new Views\CreateSuccess();
        $view->note_identifier = $noteIdentifier;
        $response = new Response($status, $headers, json_encode($view));
        return $response;

    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function retrieveNote($request, $response, $args)
    {
        /** @var Models\NotesModel  $notesObj */
        $notesObj = $this->di->get(Models\NotesModel::class);
        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->di->get(Models\UserModel::class)->getUserIdFromEmail($bearerInfo["email"]);

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        if ($noteData = $notesObj->retrieveNote($userIdentifier, $args['notes_id'])) {
            $status = 200;

            $view = new Views\Note();
            $view->title = $noteData['title'];
            $view->content = $noteData['content'];
            $view->created = $noteData['created'];
            $view->last_updated = $noteData['updated'];

            $response = new Response($status, $headers, json_encode($view));
        } else {
            $status = 404;
            $response = new Response($status, $headers, json_encode(new Views\CreateSuccess()));
        }

        return $response;
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function updateNote($request, $response, $args)
    {
        /** @var Models\NotesModel  $notesObj */
        $notesObj = $this->di->get(Models\NotesModel::class);
        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->di->get(Models\UserModel::class)->getUserIdFromEmail($bearerInfo["email"]);

        /** @var JsonValidator $jsonValidator */
        $jsonValidator = $this->di->get('jsonValidator');
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        $schema = __DIR__ . "/../Schemas/Notes.json";
        if (!$jsonValidator->validate($schema, $request->getParsedBody())) {
            $status = 400;
            $response = new Response($status, $headers,
                Errors\Notes::UNABLE_TO_CREATE_NOTE(json_encode($jsonValidator->getErrors())));
            return $response;
        }

        if($notesObj->updateNote($request->getParsedBody(), $userIdentifier,$args['notes_id'])){
            $status = 200;
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        }else{
            $status = 404;
            $response = new Response($status, $headers);
            return $response;
        }
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function deleteNote($request, $response, $args)
    {
        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->di->get(Models\UserModel::class)->getUserIdFromEmail($bearerInfo["email"]);

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        $notesObj = $this->di->get(Models\NotesModel::class);
        if ($notesObj->retrieveNote($userIdentifier, $args['notes_id'])) {
            $notesObj->deleteNote($userIdentifier,$args['notes_id']);
            $status = 200;
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        } else {
            $status = 404;
            $headers = ['Content-Type' => 'application/json; charset=utf-8'];
            $response = new Response($status, $headers);
            return $response;
        }
    }

    /**
     * @param $request
     * @return array
     */
    private function getBearerInfo($request)
    {
        $params = [];
        if (preg_match("/Basic\s+(.*)$/i", $request->getHeaderLine("Authorization"), $matches)) {
            $explodedCredential = explode(":", base64_decode($matches[1]), 2);
            if (count($explodedCredential) == 2) {
                list($params["email"], $params["password"]) = $explodedCredential;
            }
        }
        return $params;
    }

}