<?php

namespace Notes\Services\Errors;

use Notes\Core\Errors\ErrorMessage;

class Notes
{
    public static function UNABLE_TO_CREATE_NOTE($message)
    {
        return new ErrorMessage('Notes-001', sprintf('Unable to create note: %s', $message));
    }

    public static function UNABLE_TO_UPDATE_NOTE($message)
    {
        return new ErrorMessage('Notes-002', sprintf('Unable to update note: %s', $message));
    }

    public static function UNABLE_TO_GET_NOTE($message)
    {
        return new ErrorMessage('Notes-003', sprintf('Unable to retrieve note: %s', $message));
    }

    public static function UNABLE_TO_DELETE_NOTE($message)
    {
        return new ErrorMessage('Notes-003', sprintf('Unable to delete note: %s', $message));
    }

}