<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipRequest;
use App\Models\College;
use App\Models\EducationProgram;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        $data = $request->safe();

        DB::transaction(function () use ($data) {
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

            $programPayload = Validator::make(['name' => $data->program_name], [
                'name' => Rule::unique(EducationProgram::class, 'name')->where('college_id', $college->id),
            ], [
                'name.unique' => 'Program already exists in the college',
            ])->validate();

            /** @var EducationProgram */
            $program = EducationProgram::create([
                ...$programPayload,
                'degree' => $data->degree,
                'college_id' => $college->id,
            ]);

            $program->heads()->create([
                'user_id' => $user->id,
            ]);

            Membership::create([
                'period_end' => Carbon::now(),
                'education_program_id' => $program->id,
            ]);
        });
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $member)
    {
        return $member->loadFullProfile();
    }

    /**
     * Display the current authenticated resource.
     *
     * @todo handle many programs
     * @return \Illuminate\Http\Response
     */
    public function showMy(Request $request)
    {
        $program = $request->user()->headProgramOf->last()->program;
        $member = Membership::where('education_program_id', $program->id)->first();
        return $this->show($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Membership  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $member)
    {
        /** @var \App\Models\User */
        $user = $request->user();

        // Check if $member program is head by the user
        if ($member->educationProgram->heads->where('user_id', $user->id)->isEmpty()) {
            return response('Unauthorized', 401);
        }

        $payload = Validator::make($request->all(), [
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ])->safe();

        $member->educationProgram->college
            ->addMedia($payload->img)
            ->toMediaCollection('logo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Membership  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $member)
    {
        //
    }
}
