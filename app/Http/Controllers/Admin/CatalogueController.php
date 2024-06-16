<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catelogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    const PATH_VIEW = 'admin.catalogues.';
    const PATH_UPLOAD = 'catalogues';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Catelogue::latest('id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->except('cover');
        $data['is_active'] ??= 0; // nếu $data['is_active'] trong $data tồn tại thì nhận chính nó còn ko tồn tại thì =0
        // dd($data);
        if ($request->hasFile('cover')) {
            $data['cover'] = Storage::put(self::PATH_UPLOAD, $request->file('cover'));
        }
        // dd($data);

        Catelogue::create($data);

        return redirect()->route('admin.catalogues.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $model = Catelogue::findOrFail($id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $model = Catelogue::findOrFail($id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    //     $model = Catelogue::findOrFail($id);
    //     $data = $request->except('cover');
    //     $data['is_active'] ??= 0; // nếu $data['is_active'] trong $data tồn tại thì nhận chính nó còn ko tồn tại thì =0
    //     // dd($data);
    //     if ($request->hasFile('cover')) {
    //         $data['cover'] = Storage::put(self::PATH_UPLOAD, $request->file('cover'));
    //     }
    //     // dd($data);
    //     $currentCover = $model->cover;
    //     $model->update($data);
    //     if ($currentCover && Storage::exists($currentCover)) {
    //         Storage::delete($currentCover);
    //     }
    //     return back();
    // }
    public function update(Request $request, string $id)
    {
        $model = Catelogue::findOrFail($id);
        $data = $request->except('cover');
        $data['is_active'] ??= 0;

        // Lưu giá trị ảnh hiện tại
        $currentCover = $model->cover;

        if ($request->hasFile('cover')) {
            // Nếu có ảnh mới, cập nhật giá trị ảnh mới
            $data['cover'] = Storage::put(self::PATH_UPLOAD, $request->file('cover'));

            // Cập nhật model
            $model->update($data);

            // Xóa ảnh cũ nếu tồn tại
            if ($currentCover && Storage::exists($currentCover)) {
                Storage::delete($currentCover);
            }
        } else {
            // Nếu không có ảnh mới, giữ lại ảnh cũ
            $data['cover'] = $currentCover;

            // Cập nhật model
            $model->update($data);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $model = Catelogue::findOrFail($id);
        $model->delete();
        if ($model->cover && Storage::exists($model->cover)) {
            Storage::delete($model->cover);
        }
        return back();
    }
}
