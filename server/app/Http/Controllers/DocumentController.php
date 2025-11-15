<?php

namespace App\Http\Controllers;

use App\Http\Api;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $templateName = $request->query('template_name');

        if ($templateName) {
            $sortBy = $request->query('sort_by', 'created_at');
            $sortOrder = $request->query('sort_order', 'desc');
            $perPage = $request->query('per_page', 15);

            $documents = Document::where('template_name', $templateName)
                ->where('payload', 'like', '%' . $request->query('search', '') . '%')
                ->select([
                    'id',
                    'template_name',
                    'created_at',
                    'updated_at',
                    'payload->invoice_number as invoice_number',
                    'payload->receipt_to->name as member_name',
                ])
                ->orderBy($sortBy, $sortOrder)
                ->paginate($perPage)
                ->appends($request->query());

            return response()->json($documents);
        }

        return Api::message('`template_name` query parameter is required', 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return Api::data($document);
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
        $document->update([
            'payload' => $request->all(),
            'updated_by' => auth()->id(),
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
        return abort(404);
    }
}
