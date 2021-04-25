<?php

namespace Modules\Areas\Http\Controllers;

use App\Http\Helper\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Areas\Entities\Area;
use Modules\Areas\Http\Requests\CreateAreaRequest;
use Modules\Areas\Http\Requests\UpdateAreaRequest;
use Modules\Areas\Transformers\AreaResource;
use Symfony\Component\HttpFoundation\Response;
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
                $records = Area::onlyTrashed()->latest()->paginate(Setting::paginate);
            } else {
                $records = Area::latest()->paginate(Setting::paginate);
            }
            if ($records->count() > 0) {
                return jsonResponse('', 'Areas', AreaResource::collection($records)->response()->getData(true), Response::HTTP_OK);
            } else {
                return jsonResponse('empty', 'Areas', '', Response::HTTP_OK);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', $request, Response::HTTP_BAD_REQUEST);
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
            return jsonResponse("create_success", 'Areas', '', Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', $request, Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('', 'Areas', AreaResource::make($record), Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Areas', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', '', Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('update_success', 'Areas', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Areas', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', $request, Response::HTTP_BAD_REQUEST);
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
                    return jsonResponse('delete_invalid', 'Areas', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->delete();
                return jsonResponse('delete_success', 'Areas', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Areas', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', '', Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('restore_success', 'Areas', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Areas', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', '', Response::HTTP_BAD_REQUEST);
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
                    return jsonResponse('delete_invalid', 'Areas', '', Response::HTTP_BAD_REQUEST);
                }
                $del = $record->forceDelete();
                return jsonResponse('force_delete_success', 'Areas', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Areas', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', '', Response::HTTP_BAD_REQUEST);
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
                return jsonResponse('change_success', 'Areas', '', Response::HTTP_OK);
            } else {
                return jsonResponse('not_found', 'Areas', '', Response::HTTP_BAD_REQUEST);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return jsonResponse('wrong', 'Areas', $request, Response::HTTP_BAD_REQUEST);
        }
    }
}
