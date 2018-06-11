<?php

namespace Notes\Services\Controllers;

use Notes\Core;
use Notes\Core\Validators\JsonValidator;
use Notes\Services\Repository;
use Notes\Services\Views;
use GuzzleHttp\Psr7\Response;
use Notes\Services\Errors;

class NotesController
{
    /** @var Repository\NotesRepository $userRepository */
    public $notesRepository;

    /** @var Repository\UserRepository $userRepository */
    public $userRepository;

    /** @var JsonValidator $jsonValidator */
    public $jsonValidator;

    public function __construct(
        Repository\NotesRepository $notesRepository,
        Repository\UserRepository $userRepository,
        JsonValidator $jsonValidator
    ) {
        $this->notesRepository = $notesRepository;
        $this->userRepository = $userRepository;
        $this->jsonValidator = $jsonValidator;
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function createNote($request, $response)
    {
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        $schema = __DIR__ . "/../Schemas/Notes.json";
        if (!$this->jsonValidator->validate($schema, $request->getParsedBody())) {
            $status = 400;
            $response = new Response($status, $headers,
                Errors\Notes::UNABLE_TO_CREATE_NOTE(json_encode($this->jsonValidator->getErrors())));
            return $response;
        }

        $bearerInfo = $this->getBearerInfo($request);

        $requestData = $request->getParsedBody();
        $userIdentifier = $this->userRepository->getUserIdFromEmail($bearerInfo["email"]);
        $noteIdentifier = $this->notesRepository->create($userIdentifier, $requestData["title"],
            $requestData["content"]);

        $status = 201;
        $view = new Views\CreateSuccess();
        $view->note_identifier = $noteIdentifier;
        $response = new Response($status, $headers, json_encode($view), '1.1');
        return $response;

    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function retrieveNote($request, $response, $notes_id)
    {
        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->userRepository->getUserIdFromEmail($bearerInfo["email"]);

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        if ($noteData = $this->notesRepository->read($userIdentifier, $notes_id)) {
            $status = 200;

            $view = new Views\Note();
            $view->id = $noteData['id'];
            $view->title = $noteData['title'];
            $view->content = $noteData['content'];
            $view->created = $noteData['created'];
            $view->last_updated = $noteData['updated'];

            $response = new Response($status, $headers, json_encode($view));
        } else {
            $status = 404;
            $response = new Response($status, $headers);
        }

        return $response;
    }
    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function retrieveAllNotes($request, $response)
    {
        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->userRepository->getUserIdFromEmail($bearerInfo["email"]);

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        if ($noteData = $this->notesRepository->readAll($userIdentifier)) {
            $status = 200;

            $view = [];

            for($i=0;$i<count($noteData);$i++){
                $noteView = new Views\Note();
                $noteView->id = $noteData[$i]['id'];
                $noteView->title = $noteData[$i]['title'];
                $noteView->content = $noteData[$i]['content'];
                $noteView->created = $noteData[$i]['created'];
                $noteView->last_updated = $noteData[$i]['updated'];
                $view[] = $noteView;
            }

            $response = new Response($status, $headers, json_encode($view));
        } else {
            $status = 404;
            $response = new Response($status, $headers);
        }

        return $response;
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return Response
     */
    function updateNote($request, $response, $notes_id)
    {
        $bearerInfo = $this->getBearerInfo($request);

        $userIdentifier = $this->userRepository->getUserIdFromEmail($bearerInfo["email"]);

        $requestData = $request->getParsedBody();

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        $schema = __DIR__ . "/../Schemas/Notes.json";
        if (!$this->jsonValidator->validate($schema, $requestData)) {
            $status = 400;
            $response = new Response($status, $headers,
                Errors\Notes::UNABLE_TO_CREATE_NOTE(json_encode($this->jsonValidator->getErrors())));
            return $response;
        }

        if ($this->notesRepository->update($userIdentifier, $notes_id, $requestData["title"], $requestData["content"])
        ) {
            $status = 200;
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        } else {
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
    function deleteNote($request, $response, $notes_id)
    {
        $bearerInfo = $this->getBearerInfo($request);
        $userIdentifier = $this->userRepository->getUserIdFromEmail($bearerInfo["email"]);

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];

        if ($this->notesRepository->read($userIdentifier, $notes_id)) {
            $this->notesRepository->delete($userIdentifier, $notes_id);
            $status = 200;
            $response = new Response($status, $headers, json_encode(new Views\Success()));
            return $response;
        } else {
            $status = 404;
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