<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Routing configuration.
 */
class Routing extends BaseConfig
{
    /**
     * The default namespace to use for controllers.
     */
    public string $defaultNamespace = 'App\Controllers';

    /**
     * The default controller to use when no controller is specified in the URI.
     */
    public string $defaultController = 'Home';

    /**
     * The default method to use when no method is specified in the URI.
     */
    public string $defaultMethod = 'index';

    /**
     * Whether to translate URI dashes to underscores.
     */
    public bool $translateURIDashes = false;

    /**
     * The controller/method to use when no route is found.
     */
    public ?string $override404 = null;

    /**
     * Whether to use auto routing.
     */
    public bool $autoRoute = false;

    /**
     * Whether to use auto routing (improved).
     */
    public bool $autoRouteImproved = false;

    /**
     * Whether to prioritize route definitions over auto routing.
     */
    public bool $prioritize = false;

    /**
     * An array of files that will be autoloaded when the app starts.
     */
    public array $routeFiles = [
        APPPATH . 'Config/Routes.php',
    ];

    /**
     * Whether to restrict controller names to only those within the current module.
     */
    public bool $moduleRestriction = false;

    /**
     * Whether to use controller attributes for routing.
     */
    public bool $useControllerAttributes = false;

    /**
     * If TRUE, a route parameters like `(:any)` can match multiple segments.
     * Required for CodeIgniter 4.5+
     */
    public bool $multipleSegmentsOneParam = false;
}