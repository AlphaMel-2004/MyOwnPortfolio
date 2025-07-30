<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function validateProject(Request $request, $isUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'technologies' => 'required|string',
            'project_image' => ($isUpdate ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ];
        return $request->validate($rules);
    }

    public function handleImageUpload(Request $request, $existingImagePath = null)
    {
        if ($request->hasFile('project_image')) {
            if ($existingImagePath) {
                Storage::disk('public')->delete($existingImagePath);
            }
            return $request->file('project_image')->store('projects', 'public');
        }
        return $existingImagePath;
    }

    public function createProject(array $data)
    {
        $data['technologies'] = array_map('trim', explode(',', $data['technologies']));
        return Project::create($data);
    }

    public function updateProject(Project $project, array $data)
    {
        $data['technologies'] = array_map('trim', explode(',', $data['technologies']));
        $project->update($data);
        return $project;
    }

    public function deleteProject(Project $project)
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        $project->delete();
    }
} 