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

class ThreadTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function all_threads_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function thread_should_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->get(route('threads.show',[$thread->slug]));
        $response->assertStatus(Response::HTTP_OK);

    }

    /** @test */
    public function thread_should_be_validate()
    {
        $response = $this->postJson(route('threads.store'),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function can_create_thread()
    {
//        $this->withExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('threads.store'),[
            'title' => 'Foo',
            'content' => 'Bar',
            'channel_id' => Channel::factory()->create()->id,

        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


}

