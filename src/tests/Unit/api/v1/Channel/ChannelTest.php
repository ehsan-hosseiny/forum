<?php


namespace Tests\Unit\api\v1\Channel;

use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test All Channels List Should Be Accessible
     */
    public function test_all_channel_list_should_be_accessable()
    {
        $response = $this->get(route('channel.all'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Create Channel
     */
    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channel.create'),[
           'name'=>'Laravel'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_channel_update_should_be_validate()
    {
        $response = $this->putJson(route('channel.update'),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_update_channel()
    {
        $channel = Channel::factory()->create([
            'name'=>'Laravel'
        ]);
        $response = $this->putJson(route('channel.update'),[
            'id'=>$channel->id,
            'name'=>'Vuejs'
        ]);
        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('Vuejs',$updatedChannel->name);
    }


    /**
     * test Delete Channel
     */
    public function test_delete_channel_should_be_validated()
    {
        $response = $this->deleteJson(route('channel.delete'),[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $channel = Channel::factory()->create();
        $response = $this->deleteJson(route('channel.delete'), [
            'id' => $channel->id]);
        $response->assertStatus(Response::HTTP_OK);

    }
}

