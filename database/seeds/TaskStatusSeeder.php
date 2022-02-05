<?php

use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'title' => 'Todo',
                'slug' => 'todo',
                'order' => 1,
            ],
            [
                'title' => 'In Progress',
                'slug' => 'in-progress',
                'order' => 2,
            ],
            [
                'title' => 'Completed',
                'slug' => 'completed',
                'order' => 3,
            ],
        ];

        foreach ($data as $status){
             \App\TaskStatus::updateOrCreate(['slug' => $status['slug']], ['title' =>  $status['title'], 'order' =>  $status['order']]);
        }
    }
}
