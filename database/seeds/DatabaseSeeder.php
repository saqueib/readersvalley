<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call the php artisan migrate:refresh using Artisan
        $this->command->call('migrate:refresh');
        $this->command->warn("Data cleared, starting from blank database.");

        $tags = [
            'PHP',
            'Python',
            'Java',
            'JavaScript',
            'Ruby',
            'ReactJS',
            'Laravel',
            'Symphony',
            'VueJS',
            'AngularJS',
            'MySQL',
            'Testing',
            'ML',
            'Elixir',
            'TailwindCSS',
            'Erlang',
            'Go',
        ];

        foreach ($tags as $tag) {
            factory(\App\Tag::class)->create(['name' => $tag, 'slug' => str_slug($tag)]);
        }

        factory(\App\User::class)->create([
            'email' => 'admin@example.com',
            'username' => 'admin',
            'name' => 'Saquein Ansari'
        ]);

        $tags = \App\Tag::pluck('id');

        // admin posts
        factory(\App\Post::class, rand(6, 19))->create(['user_id' => 1])->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(rand(1,5))->toArray());
        });

        // other users post
        factory(\App\Post::class, 25)->create()->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(rand(1,5))->toArray());
        });

        $this->command->info('admin@example.com is the login id with "secret" password.');
    }
}
