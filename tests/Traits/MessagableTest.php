<?php 
namespace Viauco\Messenger\Tests\Traits;

use Viauco\Messenger\Models\{
    Discussion, Message, Participation
};
use Viauco\Messenger\Tests\TestCase;
use Illuminate\Support\Carbon;

/**
 * Class     MessagableTest
 *
 * @package  Viauco\Messenger\Tests\Traits
 */
class MessagableTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_should_get_all_discussions_with_new_messages()
    {
        /** @var  \Viauco\Messenger\Models\Discussion  $discussionOne */
        $discussionOne = $this->factory->create(Discussion::class);

        $discussionOne->participations()->saveMany([
            $this->factory->make(Participation::class),
            $this->factory->make(Participation::class, ['participable_id' => 2])
        ]);

        $discussionOne->messages()->saveMany([
            $this->factory->make(Message::class, ['participable_id' => 2]),
        ]);

        /** @var  \Viauco\Messenger\Models\Discussion  $discussionTwo */
        $discussionTwo = factory(Discussion::class)->create();
        $discussionTwo->participations()->saveMany([
            $this->factory->make(Participation::class, ['participable_id' => 3, 'last_read' => Carbon::yesterday()]),
            $this->factory->make(Participation::class, ['participable_id' => 2])
        ]);
        $discussionTwo->messages()->saveMany([
            $this->factory->make(Message::class, ['participable_id' => 2])
        ]);

        /** @var  \Viauco\Messenger\Tests\Stubs\Models\User  $user */
        $user        = $this->users->first();
        $discussions = $user->discussionsWithNewMessages();

        static::assertSame(1, $discussions->first()->id);
        static::assertSame(1, $user->newMessagesCount());
    }

    /** @test */
    public function it_should_get_participant_discussions()
    {
        /**
         * @var  \Viauco\Messenger\Tests\Stubs\Models\User  $user
         * @var  \Viauco\Messenger\Models\Discussion        $discussion
         */
        $user = $this->users->first();

        $discussion = $this->factory->create(Discussion::class);
        $discussion->participations()->saveMany([
            $this->factory->make(Participation::class, ['participable_id' => $user->getKey()]),
            $this->factory->make(Participation::class, ['participable_id' => 2])
        ]);

        static::assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->discussions);
        static::assertCount(1, $user->discussions);

        $firstDiscussion = $user->discussions->first();

        static::assertInstanceOf(Discussion::class, $firstDiscussion);
    }

    /** @test */
    public function it_can_get_all_messages()
    {
        /** @var  \Viauco\Messenger\Tests\Stubs\Models\User  $user */
        $user = $this->users->first();

        static::assertCount(0, $user->messages);

        $this->factory->of(Message::class)->times($count = 3)->create([
            'participable_id' => $user->getKey(),
        ]);

        $user->load(['messages']);

        static::assertCount($count, $user->messages);
    }

    /** @test */
    public function it_can_get_participants()
    {
        /** @var  \Viauco\Messenger\Tests\Stubs\Models\User  $user */
        $user = $this->users->first();

        static::assertCount(0, $user->participations);

        $this->factory->of(Participation::class)->times($count = 5)->create([
            'participable_id' => $user->getKey(),
        ]);

        $user->load(['participations']);

        static::assertCount($count, $user->participations);

        foreach ($user->participations as $participation) {
            /** @var  \Viauco\Messenger\Models\Participation  $participation */
            static::assertSame($user->getKey(), $participation->participable->getKey());
        }
    }
}
