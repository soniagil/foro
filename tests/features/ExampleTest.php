<?php

class ExampleTest extends FeatureTestCase
{
    public function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
                'name' => 'Sonia Gil',
                'email' => 'soniagilbenitez@gmail.com',
            ]);

        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see('Sonia Gil')
            ->see('soniagilbenitez@gmail.com');
    }
}
