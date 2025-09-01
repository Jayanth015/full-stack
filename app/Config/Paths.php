<?php

namespace Config;

/**
 * Paths
 *
 * Holds the paths that are used by the system to
 * locate the main directories, app, system, etc.
 *
 * This is typically used within the app's Config/bootstrap.php
 * file to define the paths to the system and app directories.
 */
class Paths
{
    /**
     * The path to the application directory.
     *
     * @var string
     */
    public $appDirectory = __DIR__ . '/../../app';

    /**
     * The path to the project root directory.
     *
     * @var string
     */
    public $rootDirectory = __DIR__ . '/../..';

    /**
     * The path to the system directory.
     *
     * @var string
     */
    public $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * The path to the writable directory.
     *
     * @var string
     */
    public $writableDirectory = __DIR__ . '/../../writable';

    /**
     * The path to the tests directory.
     *
     * @var string
     */
    public $testsDirectory = __DIR__ . '/../../tests';

    /**
     * The path to the view directory.
     *
     * @var string
     */
    public $viewDirectory = __DIR__ . '/../../app/Views';
}
