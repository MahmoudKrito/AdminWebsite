<?php

namespace Modules\Countries\Http\Controllers;

use App\Http\Helper\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Countries\Entities\Country;
use Modules\Countries\Http\Requests\CreateCountryRequest;
use Modules\Countries\Http\Requests\UpdateCountryRequest;
use Modules\Countries\Transformers\CountryResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CountryController extends Controller
{

    function __construct()
    {
//        $this->middleware('can:index Country ', ['only' => ['index','show']]);
////        $this->middleware('permission:product-create', ['only' => ['create','store']]);
////        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
////        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = Country::onlyTrashed()->latest()->paginate(Setting::paginate);
            } else {
                $records = Country::latest()->paginate(Setting::paginate);
            }
            if ($records->count() > 0) {
                return jsonResponse('', 'Countries', CountryResource::collection($records)->response()->getData(true), Response::HTTP_OK);
            } else {
                return jsonResponse('empty', 'Countries', '', Response::HTTP_OK);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', $request, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateCountryRequest $request)
    {
        try {
            $store = Country::create($request->all());
            return jsonResponse("create_success", 'Countries', '', Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', $request, Response::HTTP_BAD_REQUEST);
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
            $record = Country::find($id);
            if ($record) {
                return jsonResponse('', 'Countries', CountryResource::make($record), Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Countries', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', '', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCountryRequest $request, $id)
    {
        try {
            $record = Country::find($id);
            if ($record) {
                $update = $record->update($request->except('_method', '_token'));
                return jsonResponse('update_success', 'Countries', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Countries', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', $request, Response::HTTP_BAD_REQUEST);
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
            $record = Country::find($id);
            if ($record) {
//                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return jsonResponse('delete_invalid', 'Countries', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->delete();
                return jsonResponse('delete_success', 'Countries', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Countries', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', '', Response::HTTP_BAD_REQUEST);
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
            $record = Country::onlyTrashed()->find($id);
            if ($record) {
                $restore = $record->restore();
                return jsonResponse('restore_success', 'Countries', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Countries', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', '', Response::HTTP_BAD_REQUEST);
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
            $record = Country::find($id);
            if ($record) {
//                $result = checkRelation($record, ['clients', 'sellers']);
                $result = 0;
                if ($result) {
                    return jsonResponse('delete_invalid', 'Countries', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->forceDelete();
                return jsonResponse('force_delete_success', 'Countries', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Countries', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', '', Response::HTTP_BAD_REQUEST);
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
            $record = Country::find($id);
            if ($record) {
                $record->update([
                    'active' => $request->status
                ]);
                return jsonResponse('change_success', 'Countries', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Countries', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Countries', $request, Response::HTTP_BAD_REQUEST);
        }
    }
}
