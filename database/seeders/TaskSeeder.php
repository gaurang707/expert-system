<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed 10 sample tasks.
     */
    public function run(): void
    {
        $tasks = [
            ['name' => 'Set up project', 'description' => 'Install dependencies and configure the local environment.', 'status' => 'completed'],
            ['name' => 'Design database', 'description' => 'Define the tables and relationships for the application.', 'status' => 'completed'],
            ['name' => 'Create product catalog', 'description' => 'Display products with their descriptions and prices.', 'status' => 'completed'],
            ['name' => 'Add product search', 'description' => 'Allow users to search products by name and description.', 'status' => 'inprogress'],
            ['name' => 'Build task list', 'description' => 'Display all tasks with their current status.', 'status' => 'inprogress'],
            ['name' => 'Create task form', 'description' => 'Add a form for creating tasks with validation.', 'status' => 'pending'],
            ['name' => 'Add task editing', 'description' => 'Allow users to update task details and status.', 'status' => 'pending'],
            ['name' => 'Add task deletion', 'description' => 'Allow users to delete tasks after confirmation.', 'status' => 'pending'],
            ['name' => 'Test application', 'description' => 'Verify the main application flows and fix any issues.', 'status' => 'pending'],
            ['name' => 'Write documentation', 'description' => 'Document setup instructions and application features.', 'status' => 'pending'],
        ];

        foreach ($tasks as $task) {
            Task::updateOrCreate(
                ['name' => $task['name']],
                ['description' => $task['description'], 'status' => $task['status'], 'user_id' => 1],
            );
        }
    }
}
