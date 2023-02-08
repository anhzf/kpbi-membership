<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\EducationProgram;
use Illuminate\Http\Request;

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
    {
        return EducationProgram::find($request->query('program_id'))->courses;
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreCourseRequest $request)
    {
        $request->validated();
        /** @var EducationProgram */
        $program = EducationProgram::find($request->get('education_program_id'));

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
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
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
