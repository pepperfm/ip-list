<?php

namespace App\Http\Controllers\Api;

use App\Actions\StoreNetworkAddressesAction;
use App\Http\Requests\NetworkRequest;
use App\Http\Resources\NetworkResource;
use App\Models\Network;

class NetworkController
{
    public function index()
    {
        return NetworkResource::collection(Network::query()->with(['addresses'])->get());
    }

    /**
     * @param \App\Http\Requests\NetworkRequest $request
     * @param \App\Actions\StoreNetworkAddressesAction $action
     *
     * @return \App\Http\Resources\NetworkResource|\Illuminate\Http\JsonResponse
     */
    public function store(NetworkRequest $request, StoreNetworkAddressesAction $action)
    {
        try {
            \DB::beginTransaction();
            $network = Network::create(['name' => $request->input('name')]);
            if ($request->has('addresses_mask')) {
                $action->handle($request, $network);
            }
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        return NetworkResource::make($network);
    }

    public function show(Network $network)
    {
        return NetworkResource::make($network->load('addresses'));
    }

    public function update(NetworkRequest $request, Network $network)
    {
        $network->update($request->input('name'));

        return NetworkResource::make($network);
    }

    public function destroy(Network $network)
    {
        $network->delete();

        return response()->noContent();
    }
}
