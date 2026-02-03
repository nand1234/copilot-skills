<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the skills.
     */
    public function index()
    {
        $skills = Skill::all();
        return response()->json($skills);
    }

    /**
     * Store a newly created skill in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation Logic
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:10',
        ]);

        // 2. Creation Logic
        $skill = Skill::create($validated);

        return response()->json($skill, 201);
    }

    /**
     * Display the specified skill.
     */
    public function show($id)
    {
        $skill = Skill::find($id);
        
        if (!$skill) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        return response()->json($skill);
    }

    /**
     * Update the specified skill in storage.
     */
    public function update(Request $request, $id)
    {
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $skill->update($request->all());

        return response()->json($skill);
    }

    /**
     * Remove the specified skill from storage.
     */
    public function destroy($id)
    {
        $skill = Skill::find($id);
        
        if ($skill) {
            $skill->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }

        return response()->json(['message' => 'Already gone or never existed'], 404);
    }
}