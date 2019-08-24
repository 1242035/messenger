<?php 
namespace Viauco\Messenger;

use Viauco\Messenger\Exceptions\PackageException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Class     PackageServiceProvider
 *
 * @package  Viauco\Messenger
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor = 'viauco';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = '';

    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = false;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->basePath = $this->resolveBasePath();
    }

    /**
     * Resolve the base path of the package.
     *
     * @return string
     */
    protected function resolveBasePath()
    {
        return dirname(
            (new ReflectionClass($this))->getFileName(), 2
        );
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get config folder.
     *
     * @return string
     */
    protected function getConfigFolder()
    {
        return realpath($this->getBasePath().DIRECTORY_SEPARATOR.'config');
    }

    /**
     * Get config key.
     *
     * @return string
     */
    protected function getConfigKey()
    {
        return Str::slug($this->package);
    }

    /**
     * Get config file path.
     *
     * @return string
     */
    protected function getConfigFile()
    {
        return $this->getConfigFolder().DIRECTORY_SEPARATOR."{$this->package}.php";
    }

    /**
     * Get config file destination path.
     *
     * @return string
     */
    protected function getConfigFileDestination()
    {
        return config_path("{$this->package}.php");
    }

    /**
     * Get the base database path.
     *
     * @return string
     */
    protected function getDatabasePath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'database';
    }

    /**
     * Get the migrations path.
     *
     * @return string
     */
    protected function getMigrationsPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
    }

    /**
     * Get the base resources path.
     *
     * @return string
     */
    protected function getResourcesPath()
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.'resources';
    }

    /**
     * Get the base views path.
     *
     * @return string
     */
    protected function getViewsPath()
    {
        return $this->getResourcesPath().DIRECTORY_SEPARATOR.'views';
    }

    /**
     * Get the destination views path.
     *
     * @return string
     */
    protected function getViewsDestinationPath()
    {
        return resource_path('views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.$this->package);
    }

    /**
     * Get the translations path.
     *
     * @return string
     */
    protected function getTranslationsPath()
    {
        return $this->getResourcesPath().DIRECTORY_SEPARATOR.'lang';
    }

    /**
     * Get the destination views path.
     *
     * @return string
     */
    protected function getTranslationsDestinationPath()
    {
        return resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.$this->package);
    }

    /* -----------------------------------------------------------------
     |  Main MethoDIRECTORY_SEPARATOR
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->checkPackageName();
    }

    /* -----------------------------------------------------------------
     |  Package MethoDIRECTORY_SEPARATOR
     | -----------------------------------------------------------------
     */

    /**
     * Register configs.
     *
     * @param  string  $separator
     */
    protected function registerConfig($separator = '.')
    {
        $this->multiConfigs
            ? $this->registerMultipleConfigs($separator)
            : $this->mergeConfigFrom($this->getConfigFile(), $this->getConfigKey());
    }

    /**
     * Register all package configs.
     *
     * @param  string  $separator
     */
    private function registerMultipleConfigs($separator = '.')
    {
        foreach (glob($this->getConfigFolder().'/*.php') as $configPath) {
            $this->mergeConfigFrom(
                $configPath, $this->getConfigKey().$separator.basename($configPath, '.php')
            );
        }
    }

    /**
     * Register commanDIRECTORY_SEPARATOR service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider|string  $provider
     */
    protected function registerCommanDIRECTORY_SEPARATOR($provider)
    {
        if ($this->app->runningInConsole())
            $this->app->register($provider);
    }

    /**
     * Publish the config file.
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->getConfigFile() => $this->getConfigFileDestination()
        ], 'config');
    }

    /**
     * Publish the migration files.
     */
    protected function publishMigrations()
    {
        $this->publishes([
            $this->getMigrationsPath() => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Publish and load the views if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishViews($load = true)
    {
        $this->publishes([
            $this->getViewsPath() => $this->getViewsDestinationPath()
        ], 'views');

        if ($load) $this->loadViews();
    }

    /**
     * Publish and load the translations if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishTranslations($load = true)
    {
        $this->publishes([
            $this->getTranslationsPath() => $this->getTranslationsDestinationPath()
        ], 'lang');

        if ($load) $this->loadTranslations();
    }

    /**
     * Publish the factories.
     */
    protected function publishFactories()
    {
        $this->publishes([
            $this->getDatabasePath().DIRECTORY_SEPARATOR.'factories' => database_path('factories'),
        ], 'factories');
    }

    /**
     * Publish all the package files.
     *
     * @param  bool  $load
     */
    protected function publishAll($load = true)
    {
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishViews($load);
        $this->publishTranslations($load);
        $this->publishFactories();
    }

    /**
     * Load the views files.
     */
    protected function loadViews()
    {
        $this->loadViewsFrom($this->getViewsPath(), $this->package);
    }

    /**
     * Load the translations files.
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom($this->getTranslationsPath(), $this->package);
    }

    /**
     * Load the migrations files.
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Check package name.
     *
     * @throws \Arcanedev\Support\Exceptions\PackageException
     */
    private function checkPackageName()
    {
        if (empty($this->vendor) || empty($this->package))
            throw new PackageException('You must specify the vendor/package name.');
    }
}
