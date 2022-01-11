<?php


namespace Tests\Unit\Http\Controllers\API\V01\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User is not validate can not register
     */
    public function test_register_should_be_validate()
    {
        $response = $this->post('api\v1\auth\register');
        $response->assertStatus(404);
    }

    /**
     * New User can register
     */
    public function test_new_user_can_register()
    {
        $response = $this->postJson('api/v1/auth/register', [
            'name' => 'Ehsan',
            "email" => "ehsanhossini@gmail.com",
            "password" => "demo12345"
        ]);
        $response->assertStatus(201);
    }


}

