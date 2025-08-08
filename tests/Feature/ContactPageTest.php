<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/contact');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_contact_page(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/contact');

        $response->assertStatus(200);
    }
}
