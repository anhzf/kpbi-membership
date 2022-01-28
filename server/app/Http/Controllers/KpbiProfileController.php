<?php

namespace App\Http\Controllers;

use App\Models\kpbi_profile;
use App\Http\Requests\Storekpbi_profileRequest;
use App\Http\Requests\Updatekpbi_profileRequest;

class KpbiProfileController extends APIController
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
     * @param  \App\Http\Requests\Storekpbi_profileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storekpbi_profileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kpbi_profile  $kpbi_profile
     * @return \Illuminate\Http\Response
     */
    public function show(kpbi_profile $kpbi_profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatekpbi_profileRequest  $request
     * @param  \App\Models\kpbi_profile  $kpbi_profile
     * @return \Illuminate\Http\Response
     */
    public function update(Updatekpbi_profileRequest $request, kpbi_profile $kpbi_profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kpbi_profile  $kpbi_profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(kpbi_profile $kpbi_profile)
    {
        //
    }
}
