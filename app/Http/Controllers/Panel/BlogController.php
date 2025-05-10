<?php

namespace App\Http\Controllers\Panel;

use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\BlogRequest;
use App\Http\Resources\PanelDatatable\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        return view('panel.blogs.index');
    }

//    public function getDataTable(Request $request)
//    {
//
//        $items = Blog::query()->search($request)->orderByDesc('created_at');
//        $resource = new BlogResource($items);
//        return filterDataTable($items, $resource, $request);
//    }

    public function create()
    {
        return view('panel.blogs.create');
    }

    public function store(BlogRequest $request)
    {
        $data = $request->only(Blog::FILLABLE);
        if ($request->file('image')) {
            $image = uploadImage($request, 'image');
            $data['image'] = $image->file_name ?? '';
        }
        Blog::create($data)->createTranslation($request);
        return $this->response_api(true, trans('messages.done_successfully'), StatusCodes::OK);
    }

    public function edit($id)
    {
        $data['item'] = Blog::findOrFail($id);
        return view('panel.blogs.create', $data);
    }

    public function update($id, BlogRequest $request)
    {
        $data = $request->only(Blog::FILLABLE);
        if ($request->file('image')) {
            $image = uploadImage($request, 'image');
            $data['image'] = $image->file_name ?? '';
        }

        Blog::updateOrCreate(['id' => $id], $data)->createTranslation($request);
        return $this->response_api(true, trans('messages.done_successfully') , StatusCodes::OK);
    }


    public function operation(Request $request)
    {
        $item = Blog::find($request->id);
        if (isset($item)) {
            $item->is_active = !$item->is_active;
            $item->save();
            return $this->response_api(true, __('messages.done_successfully') , StatusCodes::OK);
        } else {
            return $this->response_api(false, __('messages.error'), StatusCodes::INTERNAL_ERROR);
        }

    }


    public function delete($id)
    {
        $item = Blog::find($id);
        return (isset($item) && $item->delete()) ? $this->response_api(true, __('messages.deleted_successfully') , StatusCodes::OK) : $this->response_api(false, __('messages.error') , StatusCodes::INTERNAL_ERROR);
    }



}
