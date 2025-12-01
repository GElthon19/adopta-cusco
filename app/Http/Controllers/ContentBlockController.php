<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blocks = ContentBlock::orderBy('label')->paginate(15);
        return view('admin.content_blocks.index', compact('blocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content_blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:100', 'unique:content_blocks,key', 'alpha_dash'],
            'label' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:text,textarea,html'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->has('is_active');

        ContentBlock::create($data);

        return redirect()->route('content-blocks.index')
            ->with('success', 'Bloque de contenido creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentBlock $contentBlock)
    {
        return view('admin.content_blocks.edit', compact('contentBlock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentBlock $contentBlock)
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:content_blocks,key,' . $contentBlock->id],
            'label' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:text,textarea,html'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->has('is_active');

        $contentBlock->update($data);

        return redirect()->route('content-blocks.index')
            ->with('success', 'Bloque de contenido actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentBlock $contentBlock)
    {
        $contentBlock->delete();

        return redirect()->route('content-blocks.index')
            ->with('success', 'Bloque de contenido eliminado exitosamente');
    }
}
