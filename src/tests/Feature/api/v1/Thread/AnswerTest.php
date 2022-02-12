<?php


namespace Tests\Feature\api\v1\Thread;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AnswerTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function can_get_all_answers()
    {
        $response = $this->get(route('answers.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function create_answer_should_be_validate()
    {
        $response = $this->postJson(route('answers.store'),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }

    /** @test */
    public function can_submit_new_answer_for_thread()
    {
//        $this->withoutExceptionHandling();
        $thread = Thread::factory()->create();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['message' => 'answer submitted successfully']);
        $this->assertTrue($thread->answers()->where('content', 'Foo')->exists());
    }

    /** @test */
    public function update_answer_should_be_validate()
    {
        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answers.update',$answer),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    /** @test */
    public function can_update_own_answer_of_thread()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'content' => 'Foo',
            'user_id' => $user->id
        ]);
        $response = $this->putJson(route('answers.update',[$answer]), [
            'content' => 'Bar',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            ['message' => 'answer updated successfully']
        );
        $answer->refresh();
        $this->assertEquals('Bar',$answer->content);
    }

    /** @test  */
    public function can_delete_own_answer()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->delete(route('answers.destroy',[$answer]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            ['message' => 'answer deleted successfully']
        );

        $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereContent($answer->content)->exists());
    }
}

