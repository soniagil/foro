<?php

class CreatePostsTest extends FeatureTestCase
{
	public function test_a_user_create_a_post()
	{
		// Having (teniendo esta información...)
		$user = $this->defaultUser();
		$title = 'Esta es una pregunta';
		$content = 'Este es el contenido';
		// ...y un usuario conectado...
		$this->actingAs($user);

		// When (...cuando visita la ruta para crear un post,
		// escribe un título y un contenido y presiona Publicar...)
		$this->visit(route('posts.create'))
			->type($title, 'title')
			->type($content, 'content')
			->press('Publicar');

		// Then (...entonces deberíamos ver cambios en la base de datos...)
		$this->seeInDatabase('posts', [
			'title' => $title,
			'content' => $content,
			'pending' => true,
			'user_id' => $user->id
		]);

		// ...y el usuario es redirigido al detalle del post
		$this->see($title);
	}

	public function test_creating_a_post_requires_authentication()
	{
		// When (cuando visitamos esta ruta sin estar logueados...)
		$this->visit(route('posts.create'));

		// Then (...nos lleva a la vista para hacer login)
		$this->seePageIs(route('login'));
	}

	public function test_create_post_form_validation()
	{
		$this->actingAs($this->defaultUser())
			->visit(route('posts.create'))
			->press('Publicar')
			->seePageIs(route('posts.create'))
			->seeErrors([
				'title' => 'El campo título es obligatorio',
				'content' => 'El campo contenido es obligatorio'
			]);

			// seeErrors() -> método personalizado
	}
}