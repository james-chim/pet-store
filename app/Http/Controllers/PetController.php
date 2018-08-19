<?php

namespace App\Http\Controllers;

use App\Pet;
use App\Category;
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

    public function validateStoreUpdateRequest(Request $request, bool $isUpdate) {
        return $request->validate([
            'id' => ($isUpdate ? 'required|' : '') . 'integer',
            'name' => 'required|string',
            'status' => 'required|string|in:available,pending,sold',
            'category' => 'required',
            'category.id' => 'exists:categories,id',
            'photoUrls' => 'present|array', // require the array to be present but can be empty
            'photoUrls.*' => 'string',
            'tags.*.id' => 'required|distinct|exists:tags,id',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $this->validateStoreUpdateRequest($request, false);

        // Crate pet using transaction to be more consistent if there is any error happening in between
        DB::transaction(function () use ($validatedData, &$pet) {
            $pet = new Pet($validatedData);

            if (isset($validatedData['category'])) {
                $category = Category::find($validatedData['category']['id']);
                 $pet->category()->associate($category);
                // to prevent another query to database, experimentation
                // $pet->category_id = $validatedData['category']['id'];
            }

            $pet->save();

            // Only associate tags with the pet if tags property exists
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAllByTag(Request $request)
    {
        $validatedData = $request->validate([
            'tags' => 'required|string'
        ]);
        $tags = explode(', ', $validatedData['tags']);
//        $a = Pet::with('category')->with('tags')
//            ->whereIn('tags.name', $tags)->get();
        $result = Pet::with('category')->with('tags')
            ->whereHas('tags', function($query) use ($tags) {
                $query->whereIn('name', $tags);
            })->get();
        return response()->json($result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $petId
     * @return \Illuminate\Http\Response
     */
    public function show($petId)
    {
        return response()->json(Pet::with('category')->with('tags')->findOrFail($petId), 200);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $validatedData = $this->validateStoreUpdateRequest($request, true);

        // Crate pet using transaction to be more consistent if there is any error happening in between
        DB::transaction(function () use ($validatedData, &$pet) {
            $pet = Pet::findOrFail($validatedData['id']);
            $pet->fill($validatedData);

            $pet->category()->dissociate();

            if (isset($validatedData['category'])) {
                $category = Category::find($validatedData['category']['id']);
                $pet->category()->associate($category);
                // to prevent another query to database, experimentation
                // $pet->category_id = $validatedData['category']['id'];
            }

            $pet->save();

            // Only associate tags with the pet if tags property exists
            $tagsId = [];
            if (isset($validatedData['tags'])) {
                $tagsId = array_column($validatedData['tags'], 'id');
            }
            $pet->tags()->sync($tagsId);
        });

        return response()->json($pet, 200);
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
