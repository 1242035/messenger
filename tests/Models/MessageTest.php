
<?php namespace Viauco\Messenger\Tests\Models;

use Viauco\Messenger\Models\Discussion;
use Viauco\Messenger\Models\Message;
use Viauco\Messenger\Models\Participation;
use Viauco\Messenger\Tests\TestCase;

/**
 * Class     MessageTest
 *
 * @package  Viauco\Messenger\Tests\Models
 */
class MessageTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_save_message_to_discussion()
    {
        /**
         * @var \Viauco\Messenger\Models\Message     $message
         * @var \Viauco\Messenger\Models\Discussion  $discussion
         */
        $message    = $this->factory->make(Message::class);
        $discussion = $this->factory->create(Discussion::class);

        $discussion->messages()->save($message);

        static::assertInstanceOf(Discussion::class, $message->discussion);
        static::assertSame($discussion->id, $message->discussion->id);
    }

    /** @test */
    public function it_can_save_multiple_messages_to_discussion()
    {
        /** @var  \Viauco\Messenger\Models\Discussion  $discussion */
        $messages   = $this->factory->of(Message::class)->times(3)->make();
        $discussion = $this->factory->create(Discussion::class);

        $discussion->messages()->saveMany($messages);

        static::assertCount(3, $discussion->messages);
    }

    /** @test */
    public function it_can_get_author()
    {
        /**
         * @var  \Viauco\Messenger\Tests\Stubs\Models\User  $user
         * @var  \Viauco\Messenger\Models\Message           $message
         * @var  \Viauco\Messenger\Models\Discussion        $discussion
         */
        $user       = $this->users->get(1);
        $message    = $this->factory->make(Message::class, [
            'participable_type' => $user->getMorphClass(),
            'participable_id'   => $user->getKey(),
        ]);
        $discussion = $this->factory->create(Discussion::class);

        $discussion->messages()->save($message);

        static::assertEquals(2, $message->author->id);
    }

    /** @test */
    public function it_can_get_the_recipients()
    {
        /**
         * @var  \Viauco\Messenger\Tests\Stubs\Models\User  $userOne
         * @var  \Viauco\Messenger\Tests\Stubs\Models\User  $userTwo
         * @var  \Viauco\Messenger\Tests\Stubs\Models\User  $userThree
         * @var  \Viauco\Messenger\Models\Discussion        $discussion
         * @var  \Viauco\Messenger\Models\Message           $message
         */
        $userOne    = $this->users->get(0);
        $userTwo    = $this->users->get(1);
        $userThree  = $this->users->get(2);

        $discussion = $this->factory->create(Discussion::class);
        $discussion->messages()->save(
            $message = $this->factory->make(Message::class, [
                'participable_type' => $userOne->getMorphClass(),
                'participable_id'   => $userOne->getKey(),
            ])
        );
        $discussion->participations()->saveMany([
            $this->factory->make(Participation::class, [
                'participable_type' => $userOne->getMorphClass(),
                'participable_id'   => $userOne->getKey(),
            ]),
            $this->factory->make(Participation::class, [
                'participable_type' => $userTwo->getMorphClass(),
                'participable_id'   => $userTwo->getKey(),
            ]),
            $this->factory->make(Participation::class, [
                'participable_type' => $userThree->getMorphClass(),
                'participable_id'   => $userThree->getKey(),
            ])
        ]);

        static::assertTrue($message->participations > $message->recipients);
        static::assertCount(3, $message->participations);
        static::assertCount(2, $message->recipients);

        foreach ($message->recipients as $recipient) {
            /** @var \Viauco\Messenger\Models\Participation $recipient */
            static::assertInstanceOf(Participation::class, $recipient);
        }
    }
}
