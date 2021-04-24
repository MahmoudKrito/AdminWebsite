<?php

namespace Modules\Areas\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Areas\Entities\Area;
use Modules\Areas\Http\Requests\CreateAreaRequest;
use Modules\Areas\Http\Requests\UpdateAreaRequest;
use Modules\Areas\Transformers\AreaResource;
use Throwable;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                if ($request->has('city_id') && $request->city_id) {
                    $records = Area::onlyTrashed()->latest()->where('city_id', $request->city_id)->paginate(config('setting.paginate'));
                } else {
                    $records = Area::onlyTrashed()->latest()->paginate(config('setting.paginate'));
                }
            } else {
                if ($request->has('city_id') && $request->city_id) {
                    $records = Area::latest()->where('city_id', $request->city_id)->paginate(config('setting.paginate'));
                } else {
                    $records = Area::latest()->paginate(config('setting.paginate'));
                }
            }
            if ($records->count() > 0) {
                return response()->json(['message' => __('Returned Successfully'), 'data' => AreaResource::collection($records)->response()->getData(true)],200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateAreaRequest $request)
    {
        try {
            $store = Area::create($request->all());
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
            $record = Area::find($id);
            if ($record) {
                return response()->json(['message' => __('Changed Successfully'), 'data' => AreaResource::make($record)],200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''],400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong')],400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAreaRequest $request, $id)
    {
        try {
            $record = Area::find($id);
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
            $record = Area::find($id);
            if ($record) {
                //                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return response()->json(['message' => __('You can not delete this record'), 'data' => ''], 400);
                }

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
            return response()->json(['message' => __('Something went wrong')],400);
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
            $record = Area::onlyTrashed()->find($id);
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
            return response()->json(['message' => __('Something went wrong')],400);
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
            $record = Area::find($id);
            if ($record) {
                //                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return response()->json(['message' => __('You can not delete this record'), 'data' => ''], 400);
                }

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
            return response()->json(['message' => __('Something went wrong')],400);
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
            $record = Area::find($id);
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
