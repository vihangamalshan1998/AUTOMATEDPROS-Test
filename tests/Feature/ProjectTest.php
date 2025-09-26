<?php
namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * Test that an admin can create a project.
     */
    public function test_admin_can_create_project()
    {
        // Create a user with 'admin' role
        $manager = User::factory()->create(['role' => 'admin']);
        $admin   = User::factory()->create(['role' => 'admin']);

        // Payload to send in the POST request
        $payload = [
            'title'       => 'New Project',
            'description' => 'Project description',
            'start_date'  => now()->format('Y-m-d'), // Or any valid date
            'end_date' => now()->addWeek()->format('Y-m-d'), // 1 week later
        ];

        // Perform the API request as the admin
        $this->actingAs($manager, 'sanctum')
            ->postJson('/api/projects', $payload)
            ->assertStatus(201) // Expecting HTTP 201 Created
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'title', 'description', 'created_at', 'updated_at'],
            ]);
    }
}
