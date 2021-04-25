<?php

namespace Modules\Zones\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Zones\Entities\Zone;
use Modules\Zones\Http\Requests\CreateZoneRequest;
use Modules\Zones\Http\Requests\UpdateZoneRequest;
use Modules\Zones\Transformers\ZoneResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = Zone::onlyTrashed()->latest()->paginate(config('setting.paginate'));
            } else {
                $records = Zone::latest()->paginate(config('setting.paginate'));
            }
            if ($records->count() > 0) {
                return jsonResponse('', 'Zones', ZoneResource::collection($records), Response::HTTP_OK);
            } else {
                return jsonResponse('empty', 'Zones', '', Response::HTTP_OK);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', $request, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateZoneRequest $request)
    {
        try {
            $store = Zone::create($request->all());
            return jsonResponse("create_success", 'Zones', '', Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', $request, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        try {
            $record = Zone::find($id);
            if ($record) {
                return jsonResponse('', 'Zones', ZoneResource::make($record), Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Zones', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', '', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateZoneRequest $request, $id)
    {
        try {
            $record = Zone::find($id);
            if ($record) {
                $update = $record->update($request->except('_method', '_token'));
                return jsonResponse('update_success', 'Zones', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Zones', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', $request, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $record = Zone::find($id);
            if ($record) {
//                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return jsonResponse('delete_invalid', 'Zones', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->delete();
                return jsonResponse('delete_success', 'Zones', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Zones', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', '', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function restore($id)
    {
        try {
            $record = Zone::onlyTrashed()->find($id);
            if ($record) {
                $restore = $record->restore();
                return jsonResponse('restore_success', 'Zones', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Zones', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', '', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function forceDestroy($id)
    {
        try {
            $record = Zone::find($id);
            if ($record) {
//                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return jsonResponse('delete_invalid', 'Zones', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->forceDelete();
                return jsonResponse('force_delete_success', 'Zones', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Zones', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', '', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $record = Zone::find($id);
            if ($record) {
                $record->update([
                    'active' => $request->status
                ]);
                return jsonResponse('change_success', 'Zones', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Zones', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Zones', $request, Response::HTTP_BAD_REQUEST);
        }
    }
}
