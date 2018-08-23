<?php

namespace App\Http\Controllers;

use App\Order;
use App\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderControlloer extends Controller
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
            'petId' => 'required|Integer|exists:pets,id',
            'status' => 'required|string|in:placed,approved,delivered',
            'quantity' => 'required|Integer|min:1',
            'shipDate' => 'required|date|after:now',
            'complete' => 'required|Boolean',
        ]);

        $pet = Pet::findOrFail($validatedData['petId']);

        if ($pet->status !== 'available') {
            return response()->json('Pet is not available for purchase', 400);
        }

        // Crate pet using transaction to be more consistent if there is any error happening in between
        DB::transaction(function () use ($validatedData, $pet, &$order) {
            $order = new Order($validatedData);
            $order->pet()->save($pet); // TODO: Need to be fixed
            $order->save();
            $pet->status = 'pending';
            $pet->save();
        });

        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
