<?php

namespace Henrik\Contracts\Http;

use ArrayIterator;
use BackedEnum;

interface ParameterBagInterface
{
    /**
     * @param string|null $key
     *
     * @return array<string, mixed>
     */
    public function all(?string $key = null): array;

    /**
     * Returns the parameter keys.
     *
     * @return string[]
     */
    public function keys(): array;

    /**
     * Replaces the current parameters by a new set.
     *
     * @param array<string, mixed> $parameters
     */
    public function replace(array $parameters = []): void;

    /**
     * Adds parameters.
     *
     * @param array<string, mixed> $parameters
     */
    public function add(array $parameters = []): void;

    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value): void;

    /**
     * Returns true if the parameter is defined.
     *
     * @param string $key
     */
    public function has(string $key): bool;

    /**
     * Removes a parameter.
     *
     * @param string $key
     */
    public function remove(string $key): void;

    /**
     * Returns the alphabetic characters of the parameter value.
     *
     * @param string $key
     * @param string $default
     */
    public function getAlpha(string $key, string $default = ''): string;

    /**
     * Returns the alphabetic characters and digits of the parameter value.
     *
     * @param string $key
     * @param string $default
     */
    public function getAlnum(string $key, string $default = ''): string;

    /**
     * Returns the digits of the parameter value.
     *
     * @param string $key
     * @param string $default
     */
    public function getDigits(string $key, string $default = ''): string;

    /**
     * Returns the parameter as string.
     *
     * @param string $key
     * @param string $default
     */
    public function getString(string $key, string $default = ''): string;

    /**
     * Returns the parameter value converted to integer.
     *
     * @param string $key
     * @param int    $default
     */
    public function getInt(string $key, int $default = 0): int;

    /**
     * Returns the parameter value converted to boolean.
     *
     * @param string $key
     * @param bool   $default
     */
    public function getBoolean(string $key, bool $default = false): bool;

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
     * Filter key.
     *
     * @param int              $filter  FILTER_* constant
     * @param int|array<mixed> $options Flags from FILTER_* constants
     * @param string           $key
     * @param mixed|null       $default
     *
     * @see https://php.net/filter-var
     */
    public function filter(
        string $key,
        mixed $default = null,
        int $filter = \FILTER_DEFAULT,
        array|int $options = []
    ): mixed;

    /**
     * Returns an iterator for parameters.
     *
     * @return ArrayIterator<string, mixed>
     */
    public function getIterator(): ArrayIterator;

    /**
     * Returns the number of parameters.
     */
    public function count(): int;
}