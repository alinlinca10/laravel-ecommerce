<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Page;
use App\Models\Store\Category;
use Auth;
use stdClass;
use Input;

class AdminPageController extends Controller
{
    public $folder = 'admin/page';
    public $link = '/admin/page';
    public $section = 'Page';
    public $pags = 50;

    public function index()
    {
        $items = Page::orderBy('id', 'desc')
            ->paginate($this->pags);

        return view($this->folder.'.index')
            ->with('items', $items)
            ->with('link', $this->link)
            ->with('section', $this->section)
            ->with('folder', $this->folder);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('order')->pluck('title', 'id');
        $categories->prepend('Without category', 0);

        $item = new Page();

        return view($this->folder.'.create')
            ->with(compact('item'))
            ->with(compact('categories'))
            ->with('section', $this->section)
            ->with('link', $this->link);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]);

        $auth = Auth::user();
        $category = $request->category_id ? Category::find($request->category_id) : '';

        $item = new Page();
        $item->name = $request->title;
        $item->title = $request->title;
        $item->path = $request->path;
        $item->description = $request->description;
        $item->keywords = $request->keywords;
        // $item->is_category = $request->is_category;

        $item->category_id = $category ? $category->id : null;
        $item->description = $request->description;
        $item->active = $request->active ? 1 : null;

        $item = Page::create($item->toArray());
        
        flash('Page created successfully.')->success();

        return redirect()->route('page.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $categories = Category::orderBy('order')->pluck('name', 'id');
        // $categories->prepend('Fara categorie parinte', 0);

        $categories = Category::with('parent')->get()->sortBy('name');
        foreach ($categories as $key => $category) {
            $parent_category = $category->parent;

            if ($parent_category) {
                $category['name'] = $category->path . '/' . $category['title'];
            } else {
                $category['name'] = $category['title'];
            }
  
        }
        $categories = $categories->pluck('name', 'id');
        $categories->prepend('Without category', 0);

        $item = Page::find($id);

        return view($this->folder.'.edit')
            ->with(compact('item'))
            ->with(compact('categories'))
            ->with('link', $this->link)
            ->with('section', $this->section)
            ->with('folder', $this->folder);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]);
        
        $category = $request->category_id ? Category::find($request->category_id) : '';

        $item = Page::find($id);
        $item->name = $request->title;
        $item->title = $request->title;
        $item->path = $request->path;
        $item->description = $request->description;
        $item->keywords = $request->keywords;
        $item->category_id = $category ? $category->id : null;
        $item->active = $request->active ? 1 : null;
        
        $item->save();

        flash('Product updated successfully!')->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $item = Page::find($id);
    //     $item->delete();

    //     return redirect()->route('products.index')
    //         ->with('success','Product deleted successfully');
    // }

    public function delete($id) {
        $url = $this->link.'/' . $id;

        return view('admin/partials.delete')
            ->with(compact('url'));
    }

    public function destroy($ids) {
        $ids = explode(',', $ids);

        foreach ($ids as $id) {
            $item = Page::findOrFail($id);
            $item->delete();
        }
        flash('Product deleted successfully.')->success();

        return redirect($this->link);
    }

    // public function setVisibility($ids) {
    //     $ids = explode(',', $ids);

    //     foreach ($ids as $id) {
    //         $item = Page::findOrFail($id);

    //         $item->active = !$item->active;
    //     }

    //     return redirect($this->link);
    // }

    public function setVisibility($id, Request $request) {
        $item = Page::find($id);

          if ($request['state'] == 1) {
            $item->active = null;
            $item->save();
           
            return response()->json(["state" => null]);
        }
        elseif ($request['state'] == NULL) {
            $item->active = 1;
            $item->save();
           
            return response()->json(["state" => 1]);
        }
        return redirect()->back();
    }

    public function search()
    {
        $request = Input::get('terms');
        $page    = Input::get('page');

        $items = Page::where(function ($q) use ($request) {
            $q->where('name', 'LIKE', $request . '%')
                ->orWhere('id', 'LIKE', $request . '%')
                ->orWhere('created_at', 'LIKE', date('Y-m-d', strtotime($request)) . '%');

        })
            ->orderBy('id', 'asc')
            ->paginate($this->pags);

        // $items->setPath($this->link . '/search')
        //     ->appends(['terms' => $request]);

        return view($this->folder . '/' . ($page ? 'index' : 'items'))
            ->with(compact('items'))
            ->with('link', $this->link)
            ->with('folder', $this->folder);
    }
}
