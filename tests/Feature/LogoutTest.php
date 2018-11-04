<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
    	$user = factory(User::class)->create(['email' => 'user@test.com']);
    	$token = $user->generateToken();
    	$headers = ['Authorization' => "Bearer $token"];

    	$this->json('get', '/api/articles', [], $headers)->assertResponseStatus(200);
    	$this->json('post', '/api/logout', [], $headers)->assertResponseStatus(200);

    	$user = User::find($user->id);

    	$this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
    	$user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $user->api_token = null;
        $user->save();

        $this->json('get', '/api/articles', [], $headers)->assertResponseStatus(401);
    }
}
