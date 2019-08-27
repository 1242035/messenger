<?php 
namespace Viauco\Messenger;

/**
 * Class     MessengerServiceProvider
 *
 * @package  Viauco\Messenger
 */
class MessengerServiceProvider extends PackageServiceProvider
{
    use EventMap;
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'messenger';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerConfig();
        
        $this->bindModels();
        
        $this->registerEvents();

    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->publishConfig();

        Messenger::$runsMigrations ? $this->loadMigrations() : $this->publishMigrations();

        $this->loadRoute();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\Discussion::class,
            Contracts\Message::class,
            Contracts\Participation::class,
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Bind the models.
     */
    private function bindModels()
    {
        $config   = $this->config();
        $bindings = [
            'discussions'    => Contracts\Discussion::class,
            'messages'       => Contracts\Message::class,
            'participations' => Contracts\Participation::class,
        ];

        foreach ($bindings as $key => $contract) 
        {
            $this->bind($contract, $config->get("{$this->package}.{$key}.model"));
        }
    }

    public function loadRoute() 
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
    }

    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
        foreach ($this->events as $event => $listeners) 
        {
            foreach ($listeners as $listener) 
            {
                $events->listen($event, $listener);
            }
        }
    }
}
