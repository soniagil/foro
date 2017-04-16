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
        $user = $this->defaultUser();

        $post = factory(Post::class)->make([
            'title' => 'Old title',
        ]);

        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }
}
