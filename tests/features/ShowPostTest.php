<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
    	// Having
    	$user = $this->defaultUser([
    		'name' => 'Sonia Gil',
    	]);

    	$post = $this->createPost([
    		'title' => 'Como instalar Laravel',
    		'content' => 'Este es el contenido del post',
            'user_id' => $user->id
    	]);

    	// Cuando el usuario visite la página del post...
    	$this->visit($post->url)
    		->seeInElement('h1', $post->title)
    		->see($post->content)
    		->see($user->name);
    }

    // urls obsoletas redirigen a las nuevas (por ejemplo,
    // si se cambia el título de un post)
    public function test_old_urls_are_redirected()
    {
        // Having
        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }
}
