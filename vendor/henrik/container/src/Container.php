<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 3/31/2018
 * Time: 10:34 AM.
 */
declare(strict_types=1);

namespace Henrik\Container;

use Henrik\Component\Component;
use Henrik\Container\Exceptions\KeyAlreadyExistsException;
use Henrik\Container\Exceptions\KeyNotFoundException;
use Henrik\Container\Exceptions\UndefinedModeException;

/**
 * Class Container.
 */
class Container extends Component implements ContainerInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $data = [];
    /**
     * @var ContainerModes
     */
    private ContainerModes $mode = ContainerModes::SINGLE_VALUE_MODE;

    /**
     * @param string $id
     *
     * @throws KeyNotFoundException
     *
     * @return mixed
     */
    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            return $this->data[$id];
        }

        throw new KeyNotFoundException($id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->data[$id]);
    }

    /**
     * @param string $id
     * @param mixed  $value
     *
     * @throws KeyAlreadyExistsException
     *
     * @return void
     */
    public function set(string $id, mixed $value): void
    {
        if ($this->mode == ContainerModes::SINGLE_VALUE_MODE) {

            if ($this->has($id)) {
                throw new KeyAlreadyExistsException($id);
            }

            $this->data[$id] = $value;

            return;

        }

        $this->data[$id][] = $value; // @phpstan-ignore-line
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id): void
    {
        unset($this->data[$id]);
    }

    /**
     * @return void
     */
    public function deleteAll(): void
    {
        $this->data = [];
    }

    /**
     * @return array<string, mixed>
     */
    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * @param ContainerModes $mode
     *
     * @throws UndefinedModeException
     */
    public function changeMode(ContainerModes $mode): void
    {
        if (!in_array($mode, ContainerModes::cases())) {
            throw new UndefinedModeException();
        }
        $this->mode = $mode;
    }
}