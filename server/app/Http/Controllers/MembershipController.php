<?php

namespace App\Http\Controllers;

use App\Enums\AcademicDegree;
use App\Http\Api;
use App\Http\Requests\StoreMembershipRequest;
use App\Models\College;
use App\Models\EducationProgram;
use App\Models\Enums\CollegeType;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isActive = !!json_decode($request->query('active', true));
        $relations = ['educationProgram:id,name,degree,college_id,external_link', 'educationProgram.college:id,name,short_name'];
        $fields = ['id', 'education_program_id'];
        $hide = ['education_program.college_id', 'education_program_id'];
        return Membership::active($isActive)
            ->with($relations)->get($fields)->makeHidden($hide);
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
        $program = $request->user()->headOf()->program;
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

        // TODO: Move this logic into guard/gate/policy/related
        // Check if $member program is head by the user
        if ($member->educationProgram->heads->where('user_id', $user->id)->isEmpty()) {
            return response('Unauthorized', 401);
        }

        // TODO: refactor same logic into a method
        switch ($request->_entity) {
            case 'college':
                $payload = Validator::make($request->all(), [
                    'name' => 'sometimes|string',
                    'short_name' => 'sometimes|string',
                    'type' => ['sometimes', Rule::enum(CollegeType::class)],
                    'city' => 'sometimes|string',
                    'state' => 'sometimes|string',
                    'street_address' => 'sometimes|string',
                    'img' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                ])->safe();

                $college = $member->educationProgram->college;

                if (isset($payload?->img)) {
                    $college->addMedia($payload->img)
                        ->toMediaCollection('logo');
                }

                $COLLEGE_ATTRS = ['name', 'short_name', 'type', 'city', 'state', 'street_address'];

                foreach ($COLLEGE_ATTRS as $attr) {
                    if (isset($payload->$attr)) {
                        $college->$attr = $payload->$attr;
                    }
                }

                $college->save();

                break;

            case 'program':
                $payload = Validator::make($request->all(), [
                    'name' => 'sometimes|string',
                    'degree' => ['sometimes', Rule::enum(AcademicDegree::class)],
                    'department' => 'sometimes|string',
                    'faculty' => 'sometimes|string',
                    'email' => 'sometimes|email',
                    'phone_number' => 'sometimes|string',
                    'external_link' => 'sometimes|url',
                    'img' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                ])->safe();

                $program = $member->educationProgram;

                if (isset($payload?->img)) {
                    $program->addMedia($payload->img)
                        ->toMediaCollection('logo');
                }

                $PROGRAM_ATTRS = ['name', 'degree', 'department', 'faculty', 'email', 'phone_number', 'external_link'];

                foreach ($PROGRAM_ATTRS as $attr) {
                    if (isset($payload->$attr)) {
                        $program->$attr = $payload->$attr;
                    }
                }

                $program->save();

                break;

            default:
                return response('Invalid entity', 400);
        }
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

    public function listRequest(Membership $membership)
    {
        return $membership->requests()->get();
    }

    public function showCertificate(Membership $member)
    {
        throw new HttpException(501, 'Not implemented');

        $script = base_path('node-apps/get-pdf.mjs');
        $command = "node {$script} " . env('APP_URL') . "/document/pembayaran/{$member->id}";

        $descriptorSpec = [
            0 => ['pipe', 'r'],  // stdin is a pipe that the child will read from
            1 => ['pipe', 'w'],  // stdout is a pipe that the child will write to
            2 => ['pipe', 'w']   // stderr is a pipe that the child will write to
        ];

        $process = proc_open($command, $descriptorSpec, $pipes, null, null);

        if (!is_resource($process)) {
            return response()->json(['error' => 'Unable to execute the command'], 500);
        }

        $output = '';

        while (!(feof($pipes[1]) || feof($pipes[2]))) {
            $buffer = fread($pipes[1], 8192); // Read 8KB at a time
            $errBuffer = fread($pipes[2], 8192); // Read 8KB at a time
            if ($buffer !== false) {
                error_log($buffer);
                $output .= $buffer;
            }
            if ($errBuffer !== false) {
                error_log($errBuffer);
            }
        }

        // Close pipes
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        // Terminate the process and get the status
        $status = proc_get_status($process);
        if ($status['running']) {
            proc_terminate($process);
        }

        return response($output)->header('Content-Type', 'application/pdf');
    }

    public function bill(Membership $member)
    {
        return $member->bill();
    }

    public function listInvoice(Membership $membership) {
        return Api::data($membership->invoices()->get());
    }
}
