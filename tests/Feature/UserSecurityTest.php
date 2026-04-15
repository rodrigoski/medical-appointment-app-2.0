<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSecurityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_cannot_delete_themselves()
{
    $admin = User::factory()->create()->assignRole('admin');

    $response = $this->actingAs($admin)
                     ->delete(route('admin.users.destroy', $admin));

    // Verifica que sea redirigido y el usuario siga existiendo en la BD
    $response->assertStatus(302);
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
}
}
