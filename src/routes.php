<?php

use Notes\Services\Controllers;
use Notes\Services\Models;

// RoutesMo
$app->post('/notes', Controllers\NotesController::class . ':createNote') ;

$app->put('/notes', Controllers\NotesController::class . ':updateNote');

$app->get('/notes', Controllers\NotesController::class . ':retrieveNote');

$app->delete('/notes', Controllers\NotesController::class . ':deleteNote');