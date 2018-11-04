<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Article;
use App\User;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function testArticlesAreCreatedCorrectly()
    {
    	$user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $this->json('POST', '/api/articles', $payload, $headers)
        	->assertResponseStatus(201)
        	->seeJson(['id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum']);
    }

    public function testArticlesAreUpdatedCorrectly()
    {
    	$user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $article = factory(Article::class)->create([
        	'title' => 'First Article',
            'body' => 'First Body',
        ]);

        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
        	->assertResponseStatus(200)
        	->seeJson([
        		'id' => 1,
        		'title' => 'Lorem',
        		'body' => 'Ipsum',
        	]);
    }

    public function testArticlesAreDeletedCorrectly()
    {
    	$user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $article = factory(Article::class)->create([
            'title' => 'First Article',
            'body' => 'First Body',
        ]);

        $this->json('DELETE', '/api/articles/' . $article->id, [], $headers)
        	->assertResponseStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
    	factory(Article::class)->create([
            'title' => 'First Article',
            'body' => 'First Body'
        ]);

        factory(Article::class)->create([
            'title' => 'Second Article',
            'body' => 'Second Body'
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', '/api/articles', [], $headers)
        	->assertResponseStatus(200)
        	->seeJsonSubset([
        		[ 'title' => 'First Article', 'body' => 'First Body' ],
        		[ 'title' => 'Second Article', 'body' => 'Second Body' ]
        	])
        	->seeJsonStructure([
        		'*' => ['id', 'body', 'title', 'created_at', 'updated_at'],
        	]);
    }
}
