<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'technologies' => 'required|string',
            'project_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        try {
            $imagePath = $request->file('project_image')->store('projects', 'public');
            $project = Project::create([
                'title' => $request->title,
                'category' => $request->category,
                'description' => $request->description,
                'technologies' => array_map('trim', explode(',', $request->technologies)),
                'image_path' => $imagePath,
                'project_url' => $request->project_url,
                'github_url' => $request->github_url,
                'is_published' => true,
            ]);
            return redirect()->route('portfolio')->with('success', 'Project added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error adding project: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'technologies' => 'required|string',
            'project_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'category' => $request->category,
                'description' => $request->description,
                'technologies' => array_map('trim', explode(',', $request->technologies)),
                'project_url' => $request->project_url,
                'github_url' => $request->github_url,
            ];
            if ($request->hasFile('project_image')) {
                if ($project->image_path) {
                    Storage::disk('public')->delete($project->image_path);
                }
                $data['image_path'] = $request->file('project_image')->store('projects', 'public');
            }
            $project->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'project' => $project
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
            // Delete project image
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }

            $project->delete();

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

    public function publicPortfolio()
    {
        $projects = \App\Models\Project::latest()->get();
        return view('portfolio', compact('projects'));
    }
} 