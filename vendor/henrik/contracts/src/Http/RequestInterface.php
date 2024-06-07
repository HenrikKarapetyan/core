<?php

namespace Henrik\Contracts\Http;

use Henrik\Contracts\Session\SessionInterface;
use Stringable;

interface RequestInterface extends Stringable
{
    public const HEADER_FORWARDED          = 0b000001; // When using RFC 7239
    public const HEADER_X_FORWARDED_FOR    = 0b000010;
    public const HEADER_X_FORWARDED_HOST   = 0b000100;
    public const HEADER_X_FORWARDED_PROTO  = 0b001000;
    public const HEADER_X_FORWARDED_PORT   = 0b010000;
    public const HEADER_X_FORWARDED_PREFIX = 0b100000;

    public const HEADER_X_FORWARDED_AWS_ELB = 0b0011010; // AWS ELB doesn't send X-Forwarded-Host
    public const HEADER_X_FORWARDED_TRAEFIK = 0b0111110; // All "X-Forwarded-*" headers sent by Traefik reverse proxy

    public const METHOD_HEAD    = 'HEAD';
    public const METHOD_GET     = 'GET';
    public const METHOD_POST    = 'POST';
    public const METHOD_PUT     = 'PUT';
    public const METHOD_PATCH   = 'PATCH';
    public const METHOD_DELETE  = 'DELETE';
    public const METHOD_PURGE   = 'PURGE';
    public const METHOD_OPTIONS = 'OPTIONS';
    public const METHOD_TRACE   = 'TRACE';
    public const METHOD_CONNECT = 'CONNECT';

    public const FORWARDED_PARAMS = [
        self::HEADER_X_FORWARDED_FOR   => 'for',
        self::HEADER_X_FORWARDED_HOST  => 'host',
        self::HEADER_X_FORWARDED_PROTO => 'proto',
        self::HEADER_X_FORWARDED_PORT  => 'host',
    ];

    /**
     * Names for headers that can be trusted when
     * using trusted proxies.
     *
     * The FORWARDED header is the standard as of rfc7239.
     *
     * The other headers are non-standard, but widely used
     * by popular reverse proxies (like Apache mod_proxy or Amazon EC2).
     */
    public const TRUSTED_HEADERS = [
        self::HEADER_FORWARDED          => 'FORWARDED',
        self::HEADER_X_FORWARDED_FOR    => 'X_FORWARDED_FOR',
        self::HEADER_X_FORWARDED_HOST   => 'X_FORWARDED_HOST',
        self::HEADER_X_FORWARDED_PROTO  => 'X_FORWARDED_PROTO',
        self::HEADER_X_FORWARDED_PORT   => 'X_FORWARDED_PORT',
        self::HEADER_X_FORWARDED_PREFIX => 'X_FORWARDED_PREFIX',
    ];

    /**
     * Creates a new request with values from PHP's super globals.
     */
    public static function createFromGlobals(): self;

    /**
     * Creates a Request based on a given URI and configuration.
     *
     * The information contained in the URI always take precedence
     * over the other information (server and parameters).
     *
     * @param string               $uri        The URI
     * @param string               $method     The HTTP method
     * @param array<mixed>         $parameters The query (GET) or request (POST) parameters
     * @param array<mixed>         $cookies    The request cookies ($_COOKIE)
     * @param array<mixed>         $files      The request files ($_FILES)
     * @param array<mixed>         $server     The server parameters ($_SERVER)
     * @param string|resource|null $content    The raw body data
     */
    public static function create(
        string $uri,
        string $method = 'GET',
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ): self;

    /**
     * Sets a callable able to create a Request instance.
     *
     * This is mainly useful when you need to override the Request class
     * to keep BC with an existing system. It should not be used for any
     * other purpose.
     *
     * @param ?callable $callable
     */
    public static function setFactory(?callable $callable): void;

    /**
     * Sets a list of trusted proxies.
     *
     * You should only list the reverse proxies that you manage directly.
     *
     * @param array<string> $proxies          A list of trusted proxies, the string 'REMOTE_ADDR' will be replaced with $_SERVER['REMOTE_ADDR']
     * @param int           $trustedHeaderSet A bit field of Request::HEADER_*, to set which headers to trust from your proxies
     */
    public static function setTrustedProxies(array $proxies, int $trustedHeaderSet): void;

    /**
     * Gets the list of trusted proxies.
     *
     * @return string[]
     */
    public static function getTrustedProxies(): array;

    /**
     * Gets the set of trusted headers from trusted proxies.
     *
     * @return int A bit field of Request::HEADER_* that defines which headers are trusted from your proxies
     */
    public static function getTrustedHeaderSet(): int;

    /**
     * Sets a list of trusted host patterns.
     *
     * You should only list the hosts you manage using regexs.
     *
     * @param array<string> $hostPatterns A list of trusted host patterns
     */
    public static function setTrustedHosts(array $hostPatterns): void;

    /**
     * Gets the list of trusted host patterns.
     *
     * @return string[]
     */
    public static function getTrustedHosts(): array;

    public static function normalizeQueryString(?string $qs): string;

    public static function enableHttpMethodParameterOverride(): void;

    public static function getHttpMethodParameterOverride(): bool;

    /**
     * Gets the mime types associated with the format.
     *
     * @param string $format
     *
     * @return string[]
     */
    public static function getMimeTypes(string $format): array;

    /**
     * Sets the parameters for this request.
     *
     * This method also re-initializes all properties.
     *
     * @param array<mixed>         $query      The GET parameters
     * @param array<mixed>         $request    The POST parameters
     * @param array<mixed>         $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array<mixed>         $cookies    The COOKIE parameters
     * @param array<mixed>         $files      The FILES parameters
     * @param array<mixed>         $server     The SERVER parameters
     * @param string|resource|null $content    The raw body data
     */
    public function initialize(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ): void;

    /**
     * Clones a request and overrides some of its parameters.
     *
     * @param array<mixed>|null $query      The GET parameters
     * @param array<mixed>|null $request    The POST parameters
     * @param array<mixed>|null $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array<mixed>|null $cookies    The COOKIE parameters
     * @param array<mixed>|null $files      The FILES parameters
     * @param array<mixed>|null $server     The SERVER parameters
     */
    public function duplicate(
        ?array $query = null,
        ?array $request = null,
        ?array $attributes = null,
        ?array $cookies = null,
        ?array $files = null,
        ?array $server = null
    ): self;

    public function overrideGlobals(): void;

    /**
     * @param string     $key
     * @param mixed|null $default
     */
    public function get(string $key, mixed $default = null): mixed;

    public function getSession(): SessionInterface;

    public function hasPreviousSession(): bool;

    public function hasSession(bool $skipIfUninitialized = false): bool;

    public function setSession(SessionInterface $session): void;

    /**
     * @internal
     *
     * @param callable(): SessionInterface $factory
     */
    public function setSessionFactory(callable $factory): void;

    /**
     * @return array<string>
     */
    public function getClientIps(): array;

    public function getClientIp(): ?string;

    /**
     * Returns current script name.
     */
    public function getScriptName(): string;

    public function getPathInfo(): string;

    public function getBasePath(): string;

    public function getBaseUrl(): string;

    /**
     * Gets the request's scheme.
     */
    public function getScheme(): string;

    public function getPort(): null|int|string;

    /**
     * Returns the user.
     */
    public function getUser(): ?string;

    /**
     * Returns the password.
     */
    public function getPassword(): ?string;

    public function getUserInfo(): ?string;

    public function getHttpHost(): string;

    public function getRequestUri(): string;

    public function getSchemeAndHttpHost(): string;

    public function getUri(): string;

    public function getUriForPath(string $path): string;

    public function getRelativeUriForPath(string $path): string;

    public function getQueryString(): ?string;

    public function isSecure(): bool;

    public function getHost(): string;

    /**
     * Sets the request method.
     *
     * @param string $method
     */
    public function setMethod(string $method): void;

    /**
     * @see getRealMethod()
     */
    public function getMethod(): string;

    /**
     * Gets the "real" request method.
     *
     * @see getMethod()
     */
    public function getRealMethod(): string;

    /**
     * Gets the mime type associated with the format.
     *
     * @param string $format
     */
    public function getMimeType(string $format): ?string;

    /**
     * Gets the format associated with the mime type.
     *
     * @param ?string $mimeType
     */
    public function getFormat(?string $mimeType): ?string;

    /**
     * Associates a format with mime types.
     *
     * @param string|string[] $mimeTypes The associated mime types (the preferred one must be the first as it will be used as the content type)
     * @param ?string         $format
     */
    public function setFormat(?string $format, array|string $mimeTypes): void;

    /**
     * @see getPreferredFormat
     *
     * @param ?string $default
     */
    public function getRequestFormat(?string $default = 'html'): ?string;

    /**
     * Sets the request format.
     *
     * @param ?string $format
     */
    public function setRequestFormat(?string $format): void;

    /**
     * @see Request::$formats
     */
    public function getContentTypeFormat(): ?string;

    /**
     * Sets the default locale.
     *
     * @param string $locale
     */
    public function setDefaultLocale(string $locale): void;

    /**
     * Get the default locale.
     */
    public function getDefaultLocale(): string;

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void;

    /**
     * Get the locale.
     */
    public function getLocale(): string;

    /**
     * Checks if the request method is of specified type.
     *
     * @param string $method Uppercase request method (GET, POST etc)
     */
    public function isMethod(string $method): bool;

    public function isMethodSafe(): bool;

    public function isMethodIdempotent(): bool;

    public function isMethodCacheable(): bool;

    public function getProtocolVersion(): ?string;

    /**
     * Returns the request body content.
     *
     * @param bool $asResource If true, a resource will be returned
     *
     * @return string|resource
     *
     * @psalm-return ($asResource is true ? resource : string)
     */
    public function getContent(bool $asResource = false);

    /**
     * Gets the decoded form or json request body.
     */
    public function getPayload(): InputBagInterface;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * @return array<string>
     */
    public function getETags(): array;

    public function isNoCache(): bool;

    /**
     * @param ?string $default
     */
    public function getPreferredFormat(?string $default = 'html'): ?string;

    /**
     * Returns the preferred language.
     *
     * @param string[] $locales An array of ordered available locales
     */
    public function getPreferredLanguage(?array $locales = null): ?string;

    /**
     * Gets a list of languages acceptable by the client browser ordered in the user browser preferences.
     *
     * @return string[]
     */
    public function getLanguages(): array;

    /**
     * Gets a list of charsets acceptable by the client browser in preferable order.
     *
     * @return string[]
     */
    public function getCharsets(): array;

    /**
     * Gets a list of encodings acceptable by the client browser in preferable order.
     *
     * @return string[]
     */
    public function getEncodings(): array;

    /**
     * Gets a list of content types acceptable by the client browser in preferable order.
     *
     * @return string[]
     */
    public function getAcceptableContentTypes(): array;

    /**
     * Returns true if the request is an XMLHttpRequest.
     *
     * It works if your JavaScript library sets an X-Requested-With HTTP header.
     * It is known to work with common JavaScript frameworks:
     *
     * @see https://wikipedia.org/wiki/List_of_Ajax_frameworks#JavaScript
     */
    public function isXmlHttpRequest(): bool;

    /**
     * Checks whether the client browser prefers safe content or not according to RFC8674.
     *
     * @see https://tools.ietf.org/html/rfc8674
     */
    public function preferSafeContent(): bool;

    /**
     * Indicates whether this request originated from a trusted proxy.
     *
     * This can be useful to determine whether or not to trust the
     * contents of a proxy-specific header.
     */
    public function isFromTrustedProxy(): bool;
}