<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $this->projectService->validateProject($request);
        try {
            $validated['image_path'] = $this->projectService->handleImageUpload($request);
            $project = $this->projectService->createProject($validated);
            return response()->json([
                'success' => true,
                'message' => 'Project added successfully',
                'project' => $project
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Project $project)
    {
        return response()->json([
            'id' => $project->id,
            'title' => $project->title,
            'description' => $project->description,
            'technologies' => $project->technologies,
            'image' => $project->image_path,
            'project_url' => $project->project_url,
            'github_url' => $project->github_url,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->projectService->validateProject($request, true);
        try {
            $validated['image_path'] = $this->projectService->handleImageUpload($request, $project->image_path);
            $project = $this->projectService->updateProject($project, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'project' => [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'technologies' => $project->technologies,
                    'image' => $project->image_path,
                    'project_url' => $project->project_url,
                    'github_url' => $project->github_url,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Project $project)
    {
        try {
            $this->projectService->deleteProject($project);
            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting project: ' . $e->getMessage()
            ], 500);
        }
    }
} 