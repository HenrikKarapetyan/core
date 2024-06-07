<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/1/2018
 * Time: 8:42 AM.
 */
declare(strict_types=1);

namespace Henrik\Container\Exceptions;

use Throwable;

class KeyAlreadyExistsException extends ContainerException
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('"%s" id is already exists please choose another name', $id);
        parent::__construct($message, $code, $previous);
    }
}