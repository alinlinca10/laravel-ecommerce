<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Store\Category;
use Auth;
use Input;
use stdClass;

class AdminCategoryController extends Controller
{
    public $folder = 'admin/category';
    public $link = '/admin/category';
    public $pags = 50;

    public function index()
    {
        $items = Category::with('creator')->orderBy('created_at', 'desc')
            ->paginate($this->pags);

        return view($this->folder.'.index')
            ->with('items', $items)
            ->with('link', $this->link)
            ->with('folder', $this->folder);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('order')->pluck('name', 'id');
        $categories->prepend('Without category', 0);

        $item = new Category();
        
        return view($this->folder.'.create')
            ->with(compact('item'))
            ->with(compact('categories'))
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
                'title' => 'required',
            ]);

        if(Category::where('name', $request->name)->where('parent_id', $request->parent_id)->first()) {
            $validator->after(function($validator){
                $validator->errors()->add('CategExists', 'Exista deja o categorie cu aceeasi adresa!');
            });
        }

        $imgs = collect();
        if($request->imgs) {
            foreach ($request->imgs['pictures'] as $key => $value) {
              $img = new stdClass();
            //   $img->thumb = Image::scale($value, 270, 'width', true);
              $img->picture = $value;
              $img->alt = $request->imgs['alt'][$key];
              $imgs->push($img);
            }
        }

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);
        
        if ($request->parent_id > 0) {
            $parent      = Category::find($request->parent_id);
            $maxPosition = Category::where('parent_id', '=', $parent->id)->max('position');
            $maxPosition += 1;

            $request['path']     = $parent->path != null ? $parent->path . '/' . $parent->name : $parent->name;
            $request['level']    = $parent->level + 1;
            $request['position'] = $maxPosition;
            $request['order']    = $parent->order . '.' . $this->numToOnes($maxPosition);
        } else {

            $maxPosition = Category::where('parent_id', '=', null)->max('position');
            $maxPosition += 1;

            $request['parent_id']   = null;
            $request['path']     = null;
            $request['level']    = 1;
            $request['position'] = $maxPosition;
            $request['order']    = $this->numToOnes($maxPosition);
        }

        $request['active']    = 1;

        $category = new Category();
        $category->title = $request->title;
        $category->name = $request->name;
        $category->pictures = serialize($imgs);
        $category->shop_category = $request->shop_category;
        $category->user_id = Auth::user()->id;
        $category->active = $request->active;

        $category = Category::create($category->toArray());

        flash('Category created succesfully!')->success();

        return redirect()->route('category.index');

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
        $item = Category::find($id);

        $categories = Category::where('id', '!=', $id)->orderBy('order')->pluck('title', 'id');
        $categories->prepend('Without category', 0);

        return view($this->folder.'.edit')
            ->with(compact('item'))
            ->with('link', $this->link)
            ->with(compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
            ]);

        if(Category::where('name', $request->name)->where('parent_id', $request->parent_id)->first()) {
            $validator->after(function($validator){
                $validator->errors()->add('CategExists','Exista deja o categorie cu aceeasi adresa!');
            });
        }

        $imgs = collect();
        if($request->imgs) {
            foreach ($request->imgs['pictures'] as $key => $value) {
              $img = new stdClass();
            //   $img->thumb = Image::scale($value, 270, 'width', true);
              $img->picture = $value;
              $img->alt = $request->imgs['alt'][$key];
              $imgs->push($img);
            }
        }

        // if ($validator->fails())
        //     return view('admin/partials/errors')->withErrors($validator);
        
        $update = false;

        $category = Category::find($id);

        if($category->name != $request->name || $category->parent_id != $request->parent_id)
            $update = true;
        
        $category->title = $request->title;
        $category->name = $request->name;
        $category->user_id = Auth::user()->id;
        $category->shop_category = $request->shop_category;
        $category->pictures = serialize($imgs);
        $category->parent_id = $request->parent_id > 0 ? $request->parent_id : null;

        // if($category->childrenCategories){
        //     foreach($category->childrenCategories as $childrenCategory){
        //         // dd($request->shop_category);
        //         $childrenCategory->shop_category = $request->shop_category;
        //     }
        // }

        if($parent = $category->parent)
            $category->path = $parent->path ? $parent->path.'/'.$parent->name : $parent->name;
        else
            $category->path = null;
        $category->save();

        if($update)
          $this->updatePaths($category);

        flash('Category edited succesfully!')->success();

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $item = Order::find($id);
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
            $item = Category::findOrFail($id);
            $item->delete();
        }

        return redirect($this->link);
    }

    public function setVisibility($id, Request $request) {
        $item = Category::find($id);

        if ($request['state'] == 1) {
            $item->active = null;
            $item->save();
        //    dd('asd');
            return response()->json(["state" => null]);
        }
        elseif ($request['state'] == NULL) {
            $item->active = 1;
            $item->save();
            // dd('asd2');

            return response()->json(["state" => 1]);
        }
        return redirect()->back();
    }

    public function search()
    {
        $request = Input::get('terms');
        $page    = Input::get('page');

        $items = Category::where(function ($q) use ($request) {
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

    public function reorderPaths($category, $id = null) {
        if($category->page && !$id) {
          $category->page->category_id = $category->parent_id;
          $category->page->save();
        }
  
        foreach ($category->pages as $key => $page) {
          if($id)
            $page->category_id = $category->parent_id;
          $page->path = $category->path;
          $page->save();
        }
  
        $children = Categories::where('parent_id', $category->id)->get();
        foreach ($children as $key => $child) {
          $child->path = $category->path;
          if($id)
            $child->parent_id = $category->parent_id;
          $child->save();
          $this->reorderPaths($child);
        }
      }
  
      public function updatePaths($category) {
        if($category->page) {
          $category->page->category_id = $category->parent_id;
          $category->page->path = $category->path;
          $category->page->name = $category->name;
          $category->page->title = $category->title;
          $category->page->save();
        }
  
        $children = Category::where('parent_id', $category->id)->get();
        foreach ($children as $key => $child) {
          $child->path = $category->path ? $category->path.'/'.$category->name : $category->name;
          $child->save();
          $this->updatePaths($child);
        }
      }
  
      public function order($lang)
      {
          $categories = Categories::where('language', '=', $lang)->orderBy('order')->get();
          return view($this->folder.'.order')
              ->with(compact('categories'))
              ->with('link', $this->link);
      }
  
      public function setOrder(Request $request)
      {
          $items = json_decode($request->order, true);
          $this->recursiveOrder($items);
  
          flash('Lista de categorii a fost ordonata cu succes.')->success();
          if($request->save_exit)
            return redirect($this->link);
          else
            return redirect()->back();
      }
  
      public function recursiveOrder($items, $level = 1, $order = '', $position = 0, $last_id = null, $last_path = null)
      {
          foreach ($items as $id => $item_id) {
              if (is_array($item_id)) {
                  if ($id === 'children') {
                      $level++;
                      $position = -1;
                  }
                  $position++;
                  $this->recursiveOrder($item_id, $level, $order, $position, $last_id, $last_path);
              } elseif ($id === 'id') {
                  $item = Categories::find($item_id);
                  if (isset($item)) {
                      if ($level == 1) {
                          $order = $this->numToOnes($position);
                      } else {
                          $order .= '.' . $this->numToOnes($position);
                      }
  
                      $item->position = $position;
                      $item->level    = $level;
                      $item->order    = $order;
                      $item->parent_id   = $last_id;
                      $item->path   = $last_path;
                      $item->save();
  
                      if($page = $item->page) {
                        $page->category_id = $item->parent_id;
                        $page->path = $item->path;
                        $page->name = $item->name;
                        $page->title = $item->title;
                        $page->save();
                      }
  
                      foreach ($item->pages as $key => $page) {
                        $page->path = $item->path ? $item->path.'/'.$item->name : $item->name;
                        $page->save();
                      }
  
                      $last_id = $item_id;
                      $last_path = $item->path != null ? $item->path . '/' . $item->name : $item->name;
                  }
              }
          }
      }
  
      public function numToOnes($num)
      {
        $ones = '';
        for ($i = 0; $i < $num; $i++) {
            $ones .= '1';
        }
  
        return $ones;
      }
}
