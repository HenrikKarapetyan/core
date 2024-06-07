<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 3/31/2018
 * Time: 1:47 PM.
 */
declare(strict_types=1);

namespace Henrik\Container;

/**
 * Interface ContainerInterface.
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * @param string $id
     *
     * @return mixed
     */
    public function get(string $id): mixed;

    /**
     * @param string $id
     * @param mixed  $value
     *
     * @return void
     */
    public function set(string $id, mixed $value): void;

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool;

    /**
     * @param string $id
     *
     * @return void
     */
    public function delete(string $id): void;

    /**
     * @return void
     */
    public function deleteAll(): void;

    /**
     * @return array<string, mixed>
     */
    public function getAll(): array;

    public function changeMode(ContainerModes $mode): void;
}