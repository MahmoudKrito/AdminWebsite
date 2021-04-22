<?php

namespace Modules\Types\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Types\Entities\Type;
use Modules\Types\Http\Requests\CreateTypeRequest;
use Modules\Types\Http\Requests\UpdateTypeRequest;
use Modules\Types\Transformers\TypeResource;
use Throwable;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = Type::onlyTrashed()->where('parent_id', '!=', 0)->latest()->paginate(9);
            } else {
                $records = Type::latest()->where('parent_id', '!=', 0)->paginate(9);
            }
            if ($records->count() > 0) {
                return response()->json(
                    [
                        'message' => __('Returned Successfully'),
                        'data' => TypeResource::collection($records)->response()->getData(true)
                    ], 200);
            } else {
                return response()->json(['message' => __('Data not found'), 'data' => ''], 400);
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
    public function store(CreateTypeRequest $request)
    {
        try {
            $store = Type::create($request->except('image'));
            if ($request->hasFile('image')) {
                $path = 'uploads/countries';
                $name = webpUploadImage($request->file('image'), $path);
                $store->image = $name;
                $store->save();
            }
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
            $record = Type::find($id);
            if ($record) {
                return response()->json(['message' => __('Changed Successfully'), 'data' => TypeResource::make($record)], 200);
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
    public function update(UpdateTypeRequest $request, $id)
    {
        try {
            $record = Type::find($id);
            if ($record) {
                $update = $record->update($request->except('image', '_method', '_token'));

                if ($request->hasFile('image')) {
                    $path = 'uploads/countries';
                    $name = webpUploadImage($request->file('image'), $path);
                    $record->image = $name;
                    $record->save();
                }
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
            $record = Type::find($id);
            if ($record) {
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
            $record = Type::onlyTrashed()->find($id);
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
            $record = Type::find($id);
            if ($record) {
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $record = Type::find($id);
            if ($record) {
                $record->update([
                    'active' => $request->status
                ]);
                return response()->json(['message' => __('Changed Successfully'), 'data' => ''], 200);
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request], 400);
        }
    }
}
