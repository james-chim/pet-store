<?php

namespace App\Http\Controllers;

use App\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $validatedData = $request->validate([
            'name' => 'required|string',
            'status' => 'required|string|in:available,pending,sold',
            'photoUrls' => 'array',
            'photoUrls.*' => 'string',
            'tags.*.id' => 'required|distinct|exists:tags,id',
        ]);

        // Crate pet using transaction to be more consistent if there is any error happening in between
        DB::transaction(function () use ($validatedData, &$pet) {
            $pet = Pet::create($validatedData);

            if (isset($validatedData['tags'])) {
                $tagsId = array_column($validatedData['tags'], 'id');
                $pet->tags()->attach($tagsId);
            }

        });

        return response()->json($pet, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
