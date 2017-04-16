<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
    	// Having
    	$user = $this->defaultUser([
    		'name' => 'Sonia Gil',
    	]);

    	$post = factory(Post::class)->make([
    		'title' => 'Como instalar Laravel',
    		'content' => 'Este es el contenido del post',
    	]);

    	$user->posts()->save($post);

    	// Cuando el usuario visite la página del post...
    	$this->visit(route('posts.show', $post))
    		->seeInElement('h1', $post->title)
    		->see($post->content)
    		->see($user->name);
    }
}
