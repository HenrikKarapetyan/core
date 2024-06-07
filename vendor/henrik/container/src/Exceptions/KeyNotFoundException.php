<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/1/2018
 * Time: 8:37 AM.
 */
declare(strict_types=1);

namespace Henrik\Container\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class KeyNotFoundException extends Exception implements NotFoundExceptionInterface
{
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('Item by this key `%s` not found', $id);
        parent::__construct($message, $code, $previous);
    }
}