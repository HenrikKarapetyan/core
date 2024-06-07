<?php

namespace Henrik\Contracts\Http;

use BackedEnum;

interface InputBagInterface extends ParameterBagInterface
{
    public function get(string $key, mixed $default = null): null|bool|float|int|string;

    /**
     * Replaces the current input values by a new set.
     *
     * @param array<mixed> $inputs
     */
    public function replace(array $inputs = []): void;

    /**
     * Adds input values.
     *
     * @param array<mixed> $inputs
     */
    public function add(array $inputs = []): void;

    /**
     * @param string                                  $key
     * @param string|int|float|bool|array<mixed>|null $value
     *
     * @return void
     */
    public function set(string $key, mixed $value): void;

    /**
     * Returns the parameter value converted to an enum.
     *
     * @template T of \BackedEnum
     *
     * @param string          $key
     * @param class-string<T> $class
     * @param BackedEnum|null $default
     *
     * @return BackedEnum|null
     */
    public function getEnum(string $key, string $class, ?BackedEnum $default = null): ?BackedEnum;

    /**
     * Returns the parameter value converted to string.
     *
     * @param string $key
     * @param string $default
     */
    public function getString(string $key, string $default = ''): string;

    public function filter(string $key, mixed $default = null, int $filter = \FILTER_DEFAULT, mixed $options = []): mixed;
}