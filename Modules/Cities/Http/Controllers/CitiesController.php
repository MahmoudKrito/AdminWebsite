<?php

namespace Modules\Cities\Http\Controllers;

use App\Http\Helper\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Cities\Entities\City;
use Modules\Cities\Http\Requests\CreateCityRequest;
use Modules\Cities\Http\Requests\UpdateCityRequest;
use Modules\Cities\Transformers\CityResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;


class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = City::onlyTrashed()->latest()->paginate(Setting::paginate);
            } else {
                $records = City::latest()->paginate(Setting::paginate);
            }
            if ($records->count() > 0) {
                return jsonResponse('', 'Cities', CityResource::collection($records)->response()->getData(true), Response::HTTP_OK);
            } else {
                return jsonResponse('empty', 'Cities', '', Response::HTTP_OK);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', $request, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCityRequest $request)
    {
        try {
            $store = City::create($request->all());
            return jsonResponse("create_success", 'Cities', '', Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', $request, Response::HTTP_BAD_REQUEST);
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
            $record = City::find($id);
            if ($record) {
                return jsonResponse('', 'Cities', CityResource::make($record), Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Cities', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', '', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCityRequest $request, $id)
    {
        try {
            $record = City::find($id);
            if ($record) {
                $update = $record->update($request->except('_method', '_token'));
                return jsonResponse('update_success', 'Cities', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Cities', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', $request, Response::HTTP_BAD_REQUEST);
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
            $record = City::find($id);
            if ($record) {
//                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return jsonResponse('delete_invalid', 'Cities', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->delete();
                return jsonResponse('delete_success', 'Cities', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Cities', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', '', Response::HTTP_BAD_REQUEST);
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
            $record = City::onlyTrashed()->find($id);
            if ($record) {
                $restore = $record->restore();
                return jsonResponse('restore_success', 'Cities', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Cities', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', '', Response::HTTP_BAD_REQUEST);
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
            $record = City::find($id);
            if ($record) {
//                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return jsonResponse('delete_invalid', 'Cities', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->forceDelete();
                return jsonResponse('force_delete_success', 'Cities', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Cities', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', '', Response::HTTP_BAD_REQUEST);
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
            $record = City::find($id);
            if ($record) {
                $record->update([
                    'active' => $request->status
                ]);
                return jsonResponse('change_success', 'Cities', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Cities', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Cities', $request, Response::HTTP_BAD_REQUEST);
        }
    }
}
