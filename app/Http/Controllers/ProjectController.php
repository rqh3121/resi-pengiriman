<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_proyek' => 'nullable|string|max:100|unique:projects,no_proyek',
            'judul_proyek' => 'required|string|max:255',
            'spk' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'spmk' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'bakn' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $data = [
            'no_proyek' => $request->no_proyek,
            'judul_proyek' => $request->judul_proyek,
        ];

        foreach (['spk', 'spmk', 'bakn'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('project_docs', 'public');
            }
        }

        Project::create($data);
        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'no_proyek' => 'nullable|string|max:100|unique:projects,no_proyek,' . $project->id,
            'judul_proyek' => 'required|string|max:255',
            'spk' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'spmk' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'bakn' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $data = [
            'no_proyek' => $request->no_proyek,
            'judul_proyek' => $request->judul_proyek,
        ];

        foreach (['spk', 'spmk', 'bakn'] as $field) {
            if ($request->hasFile($field)) {
                if ($project->$field) {
                    Storage::disk('public')->delete($project->$field);
                }
                $data[$field] = $request->file($field)->store('project_docs', 'public');
            }
        }

        $project->update($data);
        return redirect()->route('projects.index')->with('success', 'Proyek berhasil diperbarui');
    }

    public function destroy(Project $project)
    {
        // hapus semua file terkait
        foreach (['spk', 'spmk', 'bakn'] as $field) {
            if ($project->$field) {
                Storage::disk('public')->delete($project->$field);
            }
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proyek dihapus');
    }
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}