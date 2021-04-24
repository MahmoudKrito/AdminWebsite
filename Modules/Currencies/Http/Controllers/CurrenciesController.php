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
                return jsonResponse(
                         __("Currencies::general.create_success"),
                         CurrencyResource::collection($records)->response()->getData(true)
                    , 200);
            } else {
                return jsonResponse( __('Model not found'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  $request, 400);
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
                return jsonResponse( __('Inserted Successfully'),  '', 200);
            } else {
                return jsonResponse( __('Something went wrong'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  $request, 400);
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
                return jsonResponse( __('Changed Successfully'),  CurrencyResource::make($record), 200);
            } else {
                return jsonResponse( __('Model not found'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  '', 400);
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
                    return jsonResponse( __('Updated Successfully'),  '', 200);
                } else {
                    return jsonResponse( __('Something went wrong'),  '', 400);
                }
            } else {
                return jsonResponse( __('Model not found'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  $request, 400);
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
                    return jsonResponse( __('You can not delete this record'),  '', 400);
                }

                $del = $record->delete();
                if ($del) {
                    return jsonResponse( __('Deleted Successfully'),  '', 200);
                } else {
                    return jsonResponse( __('Something went wrong'),  '', 400);
                }

            } else {
                return jsonResponse( __('Model not found'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  '', 400);
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
                    return jsonResponse( __('Restored Successfully'),  '', 200);
                } else {
                    return jsonResponse( __('Something went wrong'),  '', 400);
                }
            } else {
                return jsonResponse( __('Model not found'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  '', 400);
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
                    return jsonResponse( __('You can not delete this record'),  '', 400);
                }

                $del = $record->forceDelete();
                if ($del) {
                    return jsonResponse( __('Force Deleted Successfully'),  '', 200);
                } else {
                    return jsonResponse( __('Something went wrong'),  '', 400);
                }
            } else {
                return jsonResponse( __('Model not found'),  '', 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse( __('Something went wrong'),  '', 400);
        }
    }
}
