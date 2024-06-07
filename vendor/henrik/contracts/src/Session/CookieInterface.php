<?php

declare(strict_types=1);

namespace Henrik\Contracts\Session;

use Stringable;

interface CookieInterface extends Stringable
{
    /**
     * @param int $expire
     */
    public function setExpire(int $expire): self;

    /**
     * @param bool $expireSessionCookies
     *
     * @return bool
     */
    public function isExpired(bool $expireSessionCookies = false): bool;

    /**
     * @param string $name
     */
    public function setName(string $name): self;

    /**
     * @param string $value
     */
    public function setValue(string $value): self;

    /**
     * @param string $path
     */
    public function setPath(string $path): self;

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): self;

    /**
     * @param bool $secure
     */
    public function setSecure(bool $secure): self;

    /**
     * @param bool $httpOnly
     */
    public function setHttpOnly(bool $httpOnly): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return int
     */
    public function getExpire(): int;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getDomain(): string;

    /**
     * @return bool
     */
    public function isSecure(): bool;

    /**
     * @return bool
     */
    public function isHttpOnly(): bool;
}