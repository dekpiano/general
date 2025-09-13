<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Routing extends BaseConfig
{
    /**
     * The default namespace to use for controllers.
     *
     * @var string
     */
    public $defaultNamespace = 'App\\Controllers';

    /**
     * An array of files that will be autoloaded when the app starts.
     *
     * @var array
     */
    public $routeFiles = [];

    /**
     * Whether to translate URI dashes to underscores.
     *
     * @var bool
     */
    public $translateURIDashes = false;

    /**
     * The default controller to use when no controller is specified in the URI.
     *
     * @var string
     */
    public $defaultController = 'Home';

    /**
     * The default method to use when no method is specified in the URI.
     *
     * @var string
     */
    public $defaultMethod = 'index';

    /**
     * Whether to use auto routing.
     *
     * @var bool
     */
    public $autoRoute = false;

    /**
     * Whether to use auto routing (improved).
     *
     * @var bool
     */
    public $autoRouteImproved = false;
}