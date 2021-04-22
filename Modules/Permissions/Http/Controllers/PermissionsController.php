<?php

namespace Modules\Permissions\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Permissions\Http\Requests\AssignUserRequest;
use Modules\Permissions\Http\Requests\CreatePermissionRequest;
use Modules\Permissions\Http\Requests\RemoveUserRequest;
use Modules\Permissions\Http\Requests\UpdatePermissionRequest;
use Modules\Permissions\Transformers\PermissionResource;
use Spatie\Permission\Models\Permission;
use Throwable;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('onlyTrashed') && $request->onlyTrashed) {
                $records = Permission::onlyTrashed()->latest()->paginate(9);
            } else {
                $records = Permission::latest()->paginate(9);
            }
            if ($records->count() > 0) {
                return response()->json(
                    [
                        'message' => __('Returned Successfully'),
                        'data' => PermissionResource::collection($records)->response()->getData(true)
                    ],200);
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
    public function store(CreatePermissionRequest $request)
    {
        try {
            $store = Permission::create($request->all());
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
            $record = Permission::find($id);
            if ($record) {
                return response()->json(['message' => __('Changed Successfully'), 'data' => PermissionResource::make($record)], 200);
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
    public function update(UpdatePermissionRequest $request, $id)
    {
        try {
            $record = Permission::find($id);
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
            DB::beginTransaction();
            $record = Permission::find($id);
            if ($record) {
                $del = $record->delete();
                if ($del) {
                    DB::commit();
                    return response()->json(['message' => __('Deleted Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            DB::rollBack();
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
            DB::beginTransaction();
            $record = Permission::onlyTrashed()->find($id);
            if ($record) {
                $restore = $record->restore();
                if ($restore) {
                    DB::commit();
                    return response()->json(['message' => __('Restored Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            DB::rollBack();
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
            DB::beginTransaction();
            $record = Permission::find($id);
            if ($record) {
                $del = $record->forceDelete();
                if ($del) {
                    DB::commit();
                    return response()->json(['message' => __('Force Deleted Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
        }
    }

    public function assignUser(AssignUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $record = User::find($request->user_id);
            if ($record) {
                $assign = $record->givePermissionTo($request->permissions);
                if ($assign) {
                    DB::commit();
                    return response()->json(['message' => __('Assigned Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function removeUser(RemoveUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $record = User::find($request->user_id);
            if ($record) {
                $assign = $record->revokePermissionTo($request->permission);
                if ($assign) {
                    DB::commit();
                    return response()->json(['message' => __('Deleted Successfully'), 'data' => ''], 200);
                } else {
                    return response()->json(['message' => __('Something went wrong'), 'data' => ''], 400);
                }
            } else {
                return response()->json(['message' => __('Model not found'), 'data' => ''], 400);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['message' => __('Something went wrong'), 'data' => $request], 400);
        }
    }
}
