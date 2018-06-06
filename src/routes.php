<?php

use Notes\Services\Controllers;
use Notes\Services\Models;

// RoutesMo
$app->post('/notes', Controllers\NotesController::class . ':createNote') ;

$app->put('/notes/{notes_id}', Controllers\NotesController::class . ':updateNote');

$app->get('/notes/{notes_id}', Controllers\NotesController::class . ':retrieveNote');

$app->delete('/notes/{notes_id}', Controllers\NotesController::class . ':deleteNote');