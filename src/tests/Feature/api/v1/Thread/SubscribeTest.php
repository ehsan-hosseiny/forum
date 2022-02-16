<?php


namespace Tests\Feature\api\v1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}

