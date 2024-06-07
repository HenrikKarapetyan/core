<?php

namespace Henrik\Contracts\Filesystem;

interface FilesystemInterface
{
    /**
     * @param string $path
     * @param int    $mode
     *
     * @throws FileSystemExceptionInterface
     *
     * @return void
     */
    public static function mkdir(string $path, int $mode = 0o775): void;

    /**
     * @param string      $directory
     * @param string|null $fileExtension
     * @param ?string[]   $excludedPaths
     *
     * @return string[]
     */
    public static function getFilesFromDirectory(string $directory, ?string $fileExtension, ?array $excludedPaths = []): array;

    /**
     * @param string        $directory
     * @param string        $namespace
     * @param string[]|null $excludedPaths
     *
     * @return string[]
     */
    public static function getPhpClassesFromDirectory(string $directory, string $namespace, ?array $excludedPaths = []): array;

    /**
     * @param string      $path
     * @param int         $mode
     * @param string|null $content
     *
     * @return void
     */
    public static function createFile(string $path, int $mode = 0o664, ?string $content = null): void;

    /**
     * @param string $directory
     *
     * @return void
     */
    public static function deleteDirectory(string $directory): void;

    /**
     * @param string $file
     *
     * @return void
     */
    public static function deleteFile(string $file): void;

    /**
     * @param string $source
     * @param string $destination
     *
     * @return void
     */
    public static function copyFile(string $source, string $destination): void;

    /**
     * @param string $source
     * @param string $destination
     *
     * @return void
     */
    public static function moveFile(string $source, string $destination): void;

    /**
     * @param string        $source
     * @param string        $destination
     * @param string|null   $fileExtension
     * @param string[]|null $excludedPaths
     *
     * @return void
     */
    public static function copyDirectory(string $source, string $destination, ?string $fileExtension, ?array $excludedPaths = []): void;

    /**
     * @param string        $source
     * @param string        $destination
     * @param string|null   $fileExtension
     * @param string[]|null $excludedPaths
     *
     * @return void
     */
    public static function moveDirectory(string $source, string $destination, ?string $fileExtension = null, ?array $excludedPaths = []): void;
}