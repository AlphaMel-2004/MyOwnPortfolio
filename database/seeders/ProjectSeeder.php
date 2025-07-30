<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A full-featured e-commerce platform built with Laravel and Vue.js. Features include user authentication, product management, shopping cart, payment integration, and order tracking.',
                'category' => 'web',
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'Stripe API'],
                'features' => [
                    'User authentication and authorization',
                    'Product catalog with categories',
                    'Shopping cart functionality',
                    'Secure payment processing',
                    'Order management system',
                    'Admin dashboard'
                ],
                'images' => ['projects/ecommerce.jpg'],
                'demo_url' => 'https://demo-ecommerce.example.com',
                'source_url' => 'https://github.com/yourusername/ecommerce-platform',
                'is_published' => true
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A mobile-first task management application that helps users organize their work and personal tasks. Features include task categorization, reminders, and progress tracking.',
                'category' => 'mobile',
                'tech_stack' => ['React Native', 'Firebase', 'Redux', 'Node.js'],
                'features' => [
                    'Task creation and management',
                    'Categories and tags',
                    'Due date reminders',
                    'Progress tracking',
                    'Team collaboration',
                    'Offline support'
                ],
                'images' => ['projects/taskapp.jpg'],
                'demo_url' => 'https://taskapp.example.com',
                'source_url' => 'https://github.com/yourusername/task-management-app',
                'is_published' => true
            ],
            [
                'title' => 'AI Image Generator',
                'description' => 'An AI-powered image generation tool that creates unique artwork based on text descriptions. Uses advanced machine learning models to generate high-quality images.',
                'category' => 'ai',
                'tech_stack' => ['Python', 'TensorFlow', 'React', 'FastAPI', 'Docker'],
                'features' => [
                    'Text-to-image generation',
                    'Style transfer',
                    'Image enhancement',
                    'Batch processing',
                    'API integration',
                    'Custom model training'
                ],
                'images' => ['projects/ai-generator.jpg'],
                'demo_url' => 'https://ai-image.example.com',
                'source_url' => 'https://github.com/yourusername/ai-image-generator',
                'is_published' => true
            ],
            [
                'title' => 'Game Development Framework',
                'description' => 'A comprehensive game development framework that simplifies the creation of 2D and 3D games. Includes physics engine, asset management, and cross-platform support.',
                'category' => 'game',
                'tech_stack' => ['C++', 'OpenGL', 'SDL', 'Box2D', 'Lua'],
                'features' => [
                    '2D and 3D rendering',
                    'Physics simulation',
                    'Asset pipeline',
                    'Cross-platform support',
                    'Scripting system',
                    'Debug tools'
                ],
                'images' => ['projects/game-framework.jpg'],
                'demo_url' => 'https://game-framework.example.com',
                'source_url' => 'https://github.com/yourusername/game-framework',
                'is_published' => true
            ],
            [
                'title' => 'Desktop File Manager',
                'description' => 'A modern file management application for desktop with advanced features like cloud sync, file preview, and batch operations.',
                'category' => 'desktop',
                'tech_stack' => ['Electron', 'React', 'TypeScript', 'SQLite'],
                'features' => [
                    'File browsing and management',
                    'Cloud storage integration',
                    'File preview',
                    'Batch operations',
                    'Search functionality',
                    'Custom themes'
                ],
                'images' => ['projects/file-manager.jpg'],
                'demo_url' => 'https://file-manager.example.com',
                'source_url' => 'https://github.com/yourusername/desktop-file-manager',
                'is_published' => true
            ],
            [
                'title' => 'UI Design System',
                'description' => 'A comprehensive design system with reusable components, documentation, and design guidelines for creating consistent user interfaces.',
                'category' => 'design',
                'tech_stack' => ['Figma', 'React', 'Storybook', 'Sass'],
                'features' => [
                    'Component library',
                    'Design tokens',
                    'Accessibility guidelines',
                    'Documentation',
                    'Theme customization',
                    'Responsive components'
                ],
                'images' => ['projects/design-system.jpg'],
                'demo_url' => 'https://design-system.example.com',
                'source_url' => 'https://github.com/yourusername/ui-design-system',
                'is_published' => true
            ]
        ];

        foreach ($projects as $project) {
            Project::create([
                'title' => $project['title'],
                'slug' => Str::slug($project['title']),
                'description' => $project['description'],
                'category' => $project['category'],
                'tech_stack' => $project['tech_stack'],
                'features' => $project['features'],
                'images' => $project['images'],
                'demo_url' => $project['demo_url'],
                'source_url' => $project['source_url'],
                'is_published' => $project['is_published']
            ]);
        }
    }
} 