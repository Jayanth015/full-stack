<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Default Timezone
     * --------------------------------------------------------------------------
     *
     * This value represents the default timezone that will be used when
     * displaying or parsing dates and times.
     *
     * @var string
     */
    public $appTimezone = 'UTC';

    /**
     * --------------------------------------------------------------------------
     * Default Locale
     * --------------------------------------------------------------------------
     *
     * This value represents the default locale that will be used when
     * displaying or parsing dates and times.
     *
     * @var string
     */
    public $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * JWT Configuration
     * --------------------------------------------------------------------------
     *
     * @var string
     */
    public $jwtSecret = 'your-super-secret-jwt-key-here-change-in-production';
    public $jwtAlgorithm = 'HS256';
    public $jwtExpiration = 3600;
}
