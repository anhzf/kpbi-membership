<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return response()->json([
            'data' => [
                'id' => $document->id,
                'template_name' => $document->template_name,
                'payload' => $document->payload,
                'created_at' => $document->created_at,
                'updated_at' => $document->updated_at,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'payload' => 'required|array',
        ]);

        $document->update([
            'payload' => $request->payload,
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'data' => [
                'id' => $document->id,
                'template_name' => $document->template_name,
                'payload' => $document->payload,
                'created_at' => $document->created_at,
                'updated_at' => $document->updated_at,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
