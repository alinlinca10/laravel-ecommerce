<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Menu;
use Auth;
use Input;
use stdClass;

class AdminMenuController extends Controller
{
    public $folder = 'admin/menu';
    public $link = '/admin/menu';
    public $section = 'Menus';
    public $pags = 50;

    public function index()
    {
        $items = Menu::orderBy('created_at', 'desc')
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
        $menus = Menu::orderBy('order')->pluck('name', 'id');
        $menus->prepend('No parent', 0);

        $item = new Menu();
        
        return view($this->folder.'.create')
            ->with(compact('item'))
            ->with(compact('menus'))
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
                'title' => 'required',
            ]);

        if(Menu::where('name', $request->name)->where('parent_id', $request->parent_id)->first()) {
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
            $parent      = Menu::find($request->parent_id);
            $maxPosition = Menu::where('parent_id', '=', $parent->id)->max('position');
            $maxPosition += 1;

            $request['path']     = $parent->path != null ? $parent->path . '/' . $parent->name : $parent->name;
            $request['level']    = $parent->level + 1;
            $request['position'] = $maxPosition;
            $request['order']    = $parent->order . '.' . $this->numToOnes($maxPosition);
        } else {

            $maxPosition = Menu::where('parent_id', '=', null)->max('position');
            $maxPosition += 1;

            $request['parent_id']   = null;
            $request['path']     = null;
            $request['level']    = 1;
            $request['position'] = $maxPosition;
            $request['order']    = $this->numToOnes($maxPosition);
        }

        $request['active']    = 1;

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->pictures = serialize($imgs);
        $menu->active = $request->active;

        $menu = Menu::create($menu->toArray());

        flash('Menu created succesfully!')->success();

        return redirect()->route('menu.index');

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
        $item = Menu::find($id);

        $menus = Menu::where('id', '!=', $id)->orderBy('order')->pluck('name', 'id');
        $menus->prepend('No parent', 0);

        return view($this->folder.'.edit')
            ->with(compact('item'))
            ->with('link', $this->link)
            ->with('section', $this->section)
            ->with(compact('menus'));
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

        if(Menu::where('name', $request->name)->where('parent_id', $request->parent_id)->first()) {
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

        $menu = Menu::find($id);

        if($menu->name != $request->name || $menu->parent_id != $request->parent_id)
            $update = true;

        $menu->name = $request->name;
        $menu->pictures = serialize($imgs);
        $menu->parent_id = $request->parent_id > 0 ? $request->parent_id : null;

        // if($menu->childrenCategories){
        //     foreach($menu->childrenCategories as $childrenCategory){
        //         // dd($request->shop_category);
        //         $childrenCategory->shop_category = $request->shop_category;
        //     }
        // }

        if($parent = $menu->parent)
            $menu->path = $parent->path ? $parent->path.'/'.$parent->name : $parent->name;
        else
            $menu->path = null;
        $menu->save();

        if($update)
          $this->updatePaths($menu);

        flash('Menu edited succesfully!')->success();

        return redirect()->route('menu.index');
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
            $item = Menu::findOrFail($id);
            $item->delete();
        }

        return redirect($this->link);
    }

    public function setVisibility($id, Request $request) {
        $item = Menu::find($id);

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

        $items = Menu::where(function ($q) use ($request) {
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

    public function reorderPaths($menu, $id = null) {
        if($menu->page && !$id) {
          $menu->page->category_id = $menu->parent_id;
          $menu->page->save();
        }
  
        foreach ($menu->pages as $key => $page) {
          if($id)
            $page->category_id = $menu->parent_id;
          $page->path = $menu->path;
          $page->save();
        }
  
        $children = Menu::where('parent_id', $menu->id)->get();
        foreach ($children as $key => $child) {
          $child->path = $menu->path;
          if($id)
            $child->parent_id = $menu->parent_id;
          $child->save();
          $this->reorderPaths($child);
        }
      }
  
      public function updatePaths($menu) {
        if($menu->page) {
          $menu->page->category_id = $menu->parent_id;
          $menu->page->path = $menu->path;
          $menu->page->name = $menu->name;
          $menu->page->title = $menu->title;
          $menu->page->save();
        }
  
        $children = Menu::where('parent_id', $menu->id)->get();
        foreach ($children as $key => $child) {
          $child->path = $menu->path ? $menu->path.'/'.$menu->name : $menu->name;
          $child->save();
          $this->updatePaths($child);
        }
      }
  
      public function order($lang)
      {
          $categories = Menu::where('language', '=', $lang)->orderBy('order')->get();
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
                  $item = Menu::find($item_id);
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
