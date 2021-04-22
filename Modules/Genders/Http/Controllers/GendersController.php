<?php

namespace Modules\Genders\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Genders\Entities\Gender;
use Modules\Genders\Http\Requests\CreateGenderRequest;
use Modules\Genders\Http\Requests\UpdateGenderRequest;
use Modules\Genders\Transformers\GenderResource;
use Throwable;

class GendersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = Gender::onlyTrashed()->latest()->paginate(9);
            } else {
                $records = Gender::latest()->paginate(9);
            }
            if ($records->count() > 0) {
                return response()->json(
                    [
                        'message' => __('Returned Successfully'),
                        'data' => GenderResource::collection($records)->response()->getData(true)
                    ], 200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateGenderRequest $request)
    {
        try {
            $store = Gender::create($request->all());
            if ($store) {
                return response()->json(['message' => __('Inserted Successfully'), 'data' => ''],200);
            } else {
                return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request],400);
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
            $record = Gender::find($id);
            if ($record) {
                return response()->json(['message' => __('Changed Successfully'), 'data' => GenderResource::make($record)],200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateGenderRequest $request, $id)
    {
        try {
            $record = Gender::find($id);
            if ($record) {
                $update = $record->update($request->except('_method', '_token'));
                if ($update) {
                    return response()->json(['message' => __('Updated Successfully'), 'data' => ''],200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request],400);
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
            $record = Gender::find($id);
            if ($record) {
                $del = $record->delete();
                if ($del) {
                    return response()->json(['message' => __('Deleted Successfully'), 'data' => ''],200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
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
            $record = Gender::onlyTrashed()->find($id);
            if ($record) {
                $restore = $record->restore();
                if ($restore) {
                    return response()->json(['message' => __('Restored Successfully'), 'data' => ''],200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
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
            $record = Gender::find($id);
            if ($record) {
                $del = $record->forceDelete();
                if ($del) {
                    return response()->json(['message' => __('Force Deleted Successfully'), 'data' => ''],200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''],400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
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
            $record = Gender::find($id);
            if ($record) {
                $record->update([
                    'active' => $request->status
                ]);
                return response()->json(['message' => __('Changed Successfully'), 'data' => ''],200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request],400);
        }
    }
}
