<?php

$app->post('/notes', ['\\Notes\\Services\\Controllers\\NotesController','createNote']) ;

$app->put('/notes/{notes_id}', ['\\Notes\\Services\\Controllers\\NotesController','updateNote']);

$app->get('/notes/{notes_id}', ['\\Notes\\Services\\Controllers\\NotesController','retrieveNote']);

$app->get('/notes', ['\\Notes\\Services\\Controllers\\NotesController','retrieveAllNotes']);

$app->delete('/notes/{notes_id}', ['\\Notes\\Services\\Controllers\\NotesController','deleteNote']);