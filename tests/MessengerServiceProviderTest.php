<?php 
namespace Viauco\Messenger\Tests;

use Viauco\Messenger\MessengerServiceProvider;

/**
 * Class     MessengerServiceProviderTest
 *
 * @package  Viauco\Messenger\Tests
 */
class MessengerServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Viauco\Messenger\MessengerServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Functions
     | -----------------------------------------------------------------
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(MessengerServiceProvider::class);
    }

    public function tearDown(): void
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Viauco\Messenger\ServiceProvider::class,
            \Viauco\Messenger\PackageServiceProvider::class,
            \Viauco\Messenger\LaravelMessengerServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            \Viauco\Messenger\Contracts\Discussion::class,
            \Viauco\Messenger\Contracts\Message::class,
            \Viauco\Messenger\Contracts\Participation::class,
        ];

        static::assertSame($expected, $this->provider->provides());
    }
}
