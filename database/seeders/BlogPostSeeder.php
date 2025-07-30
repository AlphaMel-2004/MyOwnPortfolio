<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'content' => 'Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.',
                'featured_image' => null,
            ],
            [
                'title' => 'The Art of Web Design',
                'content' => 'Web design is the process of creating websites. It encompasses several different aspects, including webpage layout, content production, and graphic design. While the terms web design and web development are often used interchangeably, web design is technically a subset of the broader category of web development.',
                'featured_image' => null,
            ],
            [
                'title' => 'Mastering JavaScript',
                'content' => 'JavaScript is a programming language that enables interactive web pages. It is an essential part of web applications that can be used to add dynamic behavior and special effects to web pages. JavaScript is a client-side scripting language, which means the source code is processed by the client\'s web browser rather than on the web server.',
                'featured_image' => null,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'featured_image' => $post['featured_image'],
                'is_published' => true,
            ]);
        }
    }
}
