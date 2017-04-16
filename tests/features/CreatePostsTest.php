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
			->seeInElement('#field_title .help-block', 'El campo título es obligatorio')
			->seeInElement('#field_content .help-block', 'El campo contenido es obligatorio');

		// default.blade.php -> vista del componente Styde/Html
		// donde se especifica que el id empieza por "field_" seguido
		// del nombre. En nuestro caso field_title y field_content
	}
}