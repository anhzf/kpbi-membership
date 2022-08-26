<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipRequest;
use App\Models\College;
use App\Models\EducationProgram;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $relations = ['educationProgram:id,name,degree,college_id,external_link', 'educationProgram.college:id,name,short_name'];
        $fields = ['id', 'education_program_id'];
        $hide = ['education_program.college_id', 'education_program_id'];
        return Membership::with($relations)->get($fields)->makeHidden($hide);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @todo Validate if user exists, if already then continue but send message to prefer using existing user
     * @todo Find matching college if not found then create new college
     * @todo If program within college not found then create new program otherwise will fails
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembershipRequest $request)
    {
        abort(404);

        $data = $request->safe();

        /** @var User */
        $user = User::where('email', $data->email)->first() ?? User::create([
            'name' => 'No name',
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        // Find match college, if not found, create new college
        /** @var College */
        $college = College::where('name', $data->college_name)->first() ?? College::create([
            'name' => $data->college_name,
            'short_name' => $data->college_short_name,
        ]);

        Validator::make($data->only('program_name'), [
            'program_name' => Rule::unique(EducationProgram::class)->where('college_id', $college->id),
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
