<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /**
     * Display a listing of the skills.
     */
    public function index(): JsonResponse
    {
        // Added pagination; returning All records can crash your app if the list grows.
        return response()->json(Skill::paginate(15));
    }

    /**
     * Store a newly created skill in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:skills,name',
            'level' => 'required|integer|between:1,10',
        ]);

        $skill = Skill::create($validated);

        return response()->json($skill, 201);
    }

    /**
     * Display the specified skill.
     * Use Route Model Binding for cleaner code.
     */
    public function show(Skill $skill): JsonResponse
    {
        return response()->json($skill);
    }

    /**
     * Update the specified skill in storage.
     */
    public function update(Request $request, Skill $skill): JsonResponse
    {
        // FIX: Never use $request->all() in update. 
        // It allows users to inject data into columns you didn't intend to change.
        $validated = $request->validate([
            'name'  => 'string|max:255|unique:skills,name,' . $skill->id,
            'level' => 'integer|between:1,10',
        ]);

        $skill->update($validated);

        return response()->json($skill);
    }

    /**
     * Remove the specified skill from storage.
     */
    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}