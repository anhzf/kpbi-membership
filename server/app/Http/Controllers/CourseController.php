<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\EducationProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Course::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    // public function index(EducationProgram $educationProgram)
    {
        return EducationProgram::findOrFail($request->query('program_id'))?->courses ?? [];
        // return $educationProgram->courses;
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $payload = Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string',
            'credits' => 'required|integer',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'info.cpmk' => 'required|string',
            'lecturer' => 'required|string',
            'semester' => 'required|string',
            'education_program_id' => 'required|exists:App\Models\EducationProgram,id',
        ])->safe();

        /** @var EducationProgram */
        $program = EducationProgram::findOrFail($payload->education_program_id);

        $data = $request->except('education_program_id');
        $program->courses()->create($data);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'string',
            'code' => 'string',
            'credits' => 'integer',
            'description' => 'nullable|string',
            'info.cpmk' => 'string',
            'lecturer' => 'string',
            'semester' => 'string',
            'capacity' => 'integer',
        ]);

        $course->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
    }
}
