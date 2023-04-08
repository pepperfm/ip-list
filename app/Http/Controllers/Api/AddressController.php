<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;

class AddressController
{
    public function index()
    {
        return AddressResource::collection(Address::all());
    }

    public function store(AddressRequest $request)
    {
        return AddressResource::make(Address::create($request->validated()));
    }

    public function show(Address $address)
    {
        return AddressResource::make($address);
    }

    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return AddressResource::make($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return response()->noContent();
    }
}
