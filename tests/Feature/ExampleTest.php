<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testLogin(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testRegister(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testForgotPassWord(): void
    {
        $response = $this->get('/forget-password');

        $response->assertStatus(200);
    }

    public function testUnauthentified()
    {
        $response = $this->get("/"); //On se connecte à la racine du site
        $response->assertStatus(302); // On est redirigé
        $response->assertRedirect("/login"); // On est bien redirigé vers la route de connexion
    }
}
