<?php

namespace Modules\Currencies\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Currencies\Entities\Currency;
use Modules\Currencies\Http\Requests\CreateCurrencyRequest;
use Modules\Currencies\Http\Requests\UpdateCurrencyRequest;
use Modules\Currencies\Transformers\CurrencyResource;
use Throwable;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = Currency::onlyTrashed()->latest()->paginate(config('setting.paginate'));
            } else {
                $records = Currency::latest()->paginate(config('setting.paginate'));
            }
            if ($records->count() > 0) {
                return response()->json(
                    [
                        'message' => __('Returned Successfully'),
                        'data' => CurrencyResource::collection($records)->response()->getData(true)
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
    public function store(CreateCurrencyRequest $request)
    {
        try {
            $store = Currency::create($request->all());
            if ($store) {
                return response()->json(['message' => __('Inserted Successfully'), 'data' => ''], 200);
            } else {
                return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request], 400);
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
            $record = Currency::find($id);
            if ($record) {
                return response()->json(['message' => __('Changed Successfully'), 'data' => CurrencyResource::make($record)], 200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCurrencyRequest $request, $id)
    {
        try {
            $record = Currency::find($id);
            if ($record) {
                $update = $record->update($request->except('_method', '_token'));
                if ($update) {
                    return response()->json(['message' => __('Updated Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request], 400);
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
            $record = Currency::find($id);
            if ($record) {
                $result = checkRelation($record, 'countries');
                if ($result) {
                    return response()->json(['message' => __('You can not delete this record'), 'data' => ''], 400);
                }

                $del = $record->delete();
                if ($del) {
                    return response()->json(['message' => __('Deleted Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }

            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
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
    public function restore($id)
    {
        try {
            $record = Currency::onlyTrashed()->find($id);
            if ($record) {
                $restore = $record->restore();
                if ($restore) {
                    return response()->json(['message' => __('Restored Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
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
    public function forceDestroy($id)
    {
        try {
            $record = Currency::find($id);
            if ($record) {
                $result = checkRelation($record, 'countries');
                if ($result) {
                    return response()->json(['message' => __('You can not delete this record'), 'data' => ''], 400);
                }

                $del = $record->forceDelete();
                if ($del) {
                    return response()->json(['message' => __('Force Deleted Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
        }
    }
}
