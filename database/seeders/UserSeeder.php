<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(20)->create()
            ->each(function ($user) {
                \App\Models\Post::factory()->count(3)->create(
                    [
                        'user_id' => $user->id
                    ]
                )
                    ->each(function ($post) {
                        $tag_ids = range(1, 10);
                        shuffle($tag_ids);
                        $assignments = array_slice($tag_ids, 0, rand(1, 6)); // Each post will have at least 1 tag and up to 6 tags
                        foreach ($assignments as $tag_id) {
                            DB::table('post_tag')
                                ->insert(
                                    [
                                        'post_id' => $post->id,
                                        'tag_id' => $tag_id,
                                        'created_at' => Now(),
                                        'updated_at' => Now()
                                    ]
                                );
                        }
                    });
            });
    }
}
