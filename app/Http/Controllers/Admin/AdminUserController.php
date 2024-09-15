<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\User;
use Auth;
use stdClass;
use Input;

class AdminUserController extends Controller
{
    public $folder = 'admin/users';
    public $link = '/admin/users';
    public $pags = 50;

    public function index()
    {
        $items = User::orderBy('created_at', 'desc')
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
        $item = new User();
        
        return view($this->folder.'.create')
            ->with(compact('item'))
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
                'price' => 'required',
                // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

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

        $auth = Auth::user();
        $category = $request->category_id ? Category::find($request->category_id) : '';

        $item = new User();
        $item->user_id = $auth->id;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->old_price = $request->old_price;
        $item->code = $request->code;
        $item->qty = $request->qty;
        $item->category_id = $category ? $category->id : null;
        $item->description = $request->description;
        $item->pictures = serialize($imgs);
        $item->active = $request->active ? 1 : null;

        $item = User::create($item->toArray());
        
        flash('User created successfully.')->success();

        return redirect()->route('users.index');

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

        $item = User::find($id);

        return view($this->folder.'.edit')
            ->with(compact('item'));
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
                'price' => 'required',
                // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

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
        
        $auth = Auth::user();
        $category = $request->category_id ? Category::find($request->category_id) : '';

        $item = User::find($id);
        $item->user_id = $auth->id;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->old_price = $request->old_price;
        $item->code = $request->code;
        $item->qty = $request->qty;
        $item->category_id = $category ? $category->id : null;
        $item->description = $request->description;
        $item->pictures = serialize($imgs);
        $item->active = $request->active ? 1 : null;
        
        $item->save();

        // return redirect()->route('products.index')
        //     ->with('success','Product created successfully.');

        // session()->flash('success', 'Product created successfully.');
        flash('User created successfully.')->success();
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $item = User::find($id);
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
            $item = User::findOrFail($id);
            $item->delete();
        }
        flash('User deleted successfully.')->success();

        return redirect($this->link);
    }

    // public function setVisibility($ids) {
    //     $ids = explode(',', $ids);

    //     foreach ($ids as $id) {
    //         $item = User::findOrFail($id);

    //         $item->active = !$item->active;
    //     }

    //     return redirect($this->link);
    // }

    public function setVisibility($id, Request $request) {
        $item = User::find($id);

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

        $items = User::where(function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request . '%')
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
