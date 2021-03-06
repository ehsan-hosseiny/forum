<?php


namespace Tests\Feature\api\v1\Thread;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscribeTest extends TestCase
{

    /** @test  */
    public function user_can_subscribe_to_a_channel()
    {
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->post(route('subscribe',[$thread]));
        $response->assertSuccessful();
        $response->assertJson(['message' => 'user subscribed successfully']);
    }

    /** @test  */
    public function user_can_unsubscribe_from_a_channel()
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->post(route('unSubscribe',[$thread]));
        $response->assertSuccessful();
        $response->assertJson(['message'=>'user unsubscribed successfully']);
    }

    /** @test  */
    public function notification_will_send_to_subscribers_of_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Notification::fake();
        $thread = Thread::factory()->create();

        $subscribe_response = $this->post(route('subscribe',[$thread]));
        $subscribe_response->assertSuccessful();
        $subscribe_response->assertJson(['message' => 'user subscribed successfully']);

        $answer_response = $this->post(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id
        ]);
        $answer_response->assertSuccessful();
        $answer_response->assertJson(['message' => 'answer submitted successfully']);

        Notification::assertSentTo($user,NewReplySubmitted::class);

    }
}

