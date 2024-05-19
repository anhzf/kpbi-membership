<?php

namespace App\Http\Controllers;

use App\Models\Accreditation;
use App\Models\College;
use App\Models\EducationProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccreditationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ENTITIES = [
            'college' => College::class,
            'program' => EducationProgram::class,
        ];

        /** @var \Illuminate\Support\ValidatedInput */
        $payload = Validator::make($request->all(), [
            'entity' => ['required', Rule::in(array_keys($ENTITIES))],
            'entity_id' => 'required|integer',
            'label' => 'required|string',
            'value' => ['required', Rule::in(Accreditation::VALUES)],
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
        ])->safe();

        $type = $ENTITIES[$payload->entity];

        $entity = $type::findOrFail($payload->entity_id);

        $accreditation = $entity->accreditations()->create($payload->except('entity', 'entity_id'));

        return response()->json(['data' => $accreditation->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function show(Accreditation $accreditation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accreditation $accreditation)
    {
        /** @var \Illuminate\Support\ValidatedInput */
        $payload = Validator::make($request->all(), [
            'label' => 'sometimes|string',
            'value' => ['sometimes', Rule::in(Accreditation::VALUES)],
            'valid_from' => 'sometimes|date',
            'valid_until' => 'sometimes|date',
        ])->safe();

        $accreditation->update($payload->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accreditation  $accreditation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accreditation $accreditation)
    {
        $accreditation->delete();
    }
}
