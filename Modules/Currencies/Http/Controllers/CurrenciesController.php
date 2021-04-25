<?php

namespace Modules\Currencies\Http\Controllers;

use App\Http\Helper\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Currencies\Entities\Currency;
use Modules\Currencies\Http\Requests\CreateCurrencyRequest;
use Modules\Currencies\Http\Requests\UpdateCurrencyRequest;
use Modules\Currencies\Transformers\CurrencyResource;
use Symfony\Component\HttpFoundation\Response;
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
                $records = Currency::onlyTrashed()->latest()->paginate(Setting::paginate);
            } else {
                $records = Currency::latest()->paginate(Setting::paginate);
            }
            if ($records->count() > 0) {
                return jsonResponse('', 'Currencies', CurrencyResource::collection($records)->response()->getData(true), Response::HTTP_OK);
            } else {
                return jsonResponse('empty', 'Currencies', '', Response::HTTP_OK);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', $request, Response::HTTP_BAD_REQUEST);
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
            return jsonResponse("create_success", 'Currencies', '', Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', $request, Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('', 'Currencies', CurrencyResource::make($record), Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Currencies', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', '', Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('update_success', 'Currencies', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Currencies', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', $request, Response::HTTP_BAD_REQUEST);
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
                    return jsonResponse('delete_invalid', 'Currencies', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->delete();
                return jsonResponse('delete_success', 'Currencies', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Currencies', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', '', Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('restore_success', 'Currencies', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Currencies', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', '', Response::HTTP_BAD_REQUEST);
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
                    return jsonResponse('delete_invalid', 'Currencies', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->forceDelete();
                return jsonResponse('force_delete_success', 'Currencies', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Currencies', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Currencies', '', Response::HTTP_BAD_REQUEST);
        }
    }
}
