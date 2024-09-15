<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use stdClass;
use Input;

use App\Models\Page;
use App\Models\Store\Product;
use App\Models\Store\Category;
use App\Models\Store\Attribute;
use App\Models\Store\ProductAttribute;
use App\Models\Store\ProductAttributeRows;

class AdminProductController extends Controller
{
    public $folder = 'admin/products';
    public $link = '/admin/products';
    public $section = 'Products';
    public $pags = 50;

    public function index()
    {
        $items = Product::orderBy('id', 'desc')
            ->paginate($this->pags);

        return view($this->folder . '.index')
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
        $categories = Category::orderBy('order')->pluck('name', 'id');
        $categories->prepend('Without category', 0);

        $item = new Product();

        return view($this->folder . '.create')
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
                'price' => 'required',
                // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]
        );

        $imgs = collect();
        if ($request->imgs) {
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

        $item = new Product();
        $item->user_id = $auth->id;
        $item->name = $request->name;
        $item->link = Str::slug($request->name, '-');
        $item->price = $request->price;
        $item->old_price = $request->old_price;
        $item->cost = $request->cost;
        $item->sku = $request->sku;
        $item->code = $request->code;
        $item->qty = $request->qty;
        $item->category_id = $category ? $category->id : null;
        $item->description = $request->description;
        $item->pictures = serialize($imgs);
        $item->active = $request->active ? 1 : null;

        $item = Product::create($item->toArray());

        flash('Product created successfully.')->success();

        return redirect()->route('products.index');
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

        $attributes = Attribute::pluck('name', 'id');

        $item = Product::find($id);
        $words = explode(' ', $item->name);
        if($item->category_id)
            $products = Product::with(['attributeValues', 'attributeValues.attribute'])->where('category_id', $item->category->id)->pluck('name', 'id');
            // $products = Product::where('name', 'LIKE', '%' . $words[0] . '%')->where('id', '!=', $item->id)->pluck('name', 'id');
    
        return view($this->folder . '.edit')
            ->with(compact('item'))
            ->with(compact('categories'))
            ->with('products', $products ?? null)
            ->with('attributes', $attributes)
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
                'price' => 'required',
                // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]
        );

        $imgs = collect();
        if ($request->imgs) {
            foreach ($request->imgs['pictures'] as $key => $value) {
                $img = new stdClass();
                //   $img->thumb = Image::scale($value, 270, 'width', true);
                $img->picture = $value;
                $img->alt = $request->imgs['alt'][$key];
                $imgs->push($img);
            }
        }
        
        // $item = Product::find($id);
        // if (Page::where('id', '!=', $item->page_id)->where('name', $request->name)->where('category_id', $request->category_id)->first()) {
        //     $validator->after(function ($validator) {
        //         $validator->errors()->add('PageExists', 'Exista deja o pagina cu aceeasi adresa!');
        //     });
        // }

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);

        $auth = Auth::user();
        $category = $request->category_id ? Category::find($request->category_id) : '';

        $item = Product::find($id);
        $item->user_id = $auth->id;
        $item->name = $request->name;
        $item->link = Str::slug($request->name, '-');
        $item->price = $request->price;
        $item->old_price = $request->old_price;
        $item->cost = $request->cost;
        $item->sku = $request->sku;
        $item->code = $request->code;
        $item->qty = $request->qty;
        $item->category_id = $category ? $category->id : null;
        $item->description = $request->description;
        $item->pictures = serialize($imgs);
        $item->active = $request->active ? 1 : null;
        // $item->attribute_id = $request->product_attribute ?? null;
        // $item->associated_products = $request->associated_products ? $request->associated_products : null;
        $item->save();
        // dd($item);

        // // Create page
        // if ($page = $item->page) {
        //     $page->title = $request->title ? $request->title : $request->showname;
        //     $page->description = $request->description ? $request->description : substr(strip_tags(e($request->content)), 0, 199);
        //     $page->keywords = $request->keywords ? $request->keywords : $page->makeKeywords($request->showname);
        //     $page->category_id = $category ? $category->id : null;
        // } else {
        //     $page = new Page();
        //     $page->name = strip_tags($request->name);
        //     $page->path = Page::makePath($category);
        //     $page->title = $request->title ? $request->title : $request->showname;
        //     $page->description = $request->description ? $request->description : substr(strip_tags(e($request->content)), 0, 199);
        //     $page->keywords = $request->keywords ? $request->keywords : $page->makeKeywords($request->showname);
        //     $page->category_id = $category ? $category->id : null;
        //     $page->active = $request->active == null ? null : 1;

        //     $page = Page::create($page->toArray());
        //     $page->save();

        //     $item->page_id = $page->id;
        //     $item->save();
        // }

        // if ($page->name != $request->name || $page->path != Page::makePath($category)) {
        //     $check_link = Page::where('name', $request->name)->where('path', Page::makePath($category))->first();
        //     if ($check_link) {
        //         $validator->after(function ($validator) {
        //             $validator->errors()->add('SameLink', 'The link is already created. Type another link.');
        //         });
        //         if ($validator->fails())
        //             return redirect()->back()->withInput()->withErrors($validator);
        //     } else {
        //         $page->name = strip_tags($request->name);
        //         $page->path = Page::makePath($category);
        //     }
        // }
        // // Create page
        // dd($request->variations);
        // Actualizarea sau adăugarea variațiilor
        if ($request->has('variations')) {
            foreach ($request->variations as $attributeId => $variation) {
                foreach ($variation['attribute_values'] as $valueId => $details) {

                    // Gestionăm imaginile dacă există
                    if (isset($details['images']) && is_array($details['images'])) {
                        $images = collect();
                        foreach ($details['images'] as $key => $image) {
                            $img = new stdClass();
                            $img->picture = $image;
                            $img->alt = $request->imgs['alt'][$key];
                            $images->push($img);
                        }
                    }
                    // dd($item->attributeValues->first()->pivot);
                    $item->attributeValues()->updateExistingPivot($id, [
                        'price' => $details['price'],
                        'stock' => $details['stock'],
                        'images' => isset($images) ? serialize($images) : null,
                    ]);
                }
            }
        }

        $item->save();

        flash('Product updated successfully!')->success();

        return redirect()->back();
        // return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $item = Product::find($id);
    //     $item->delete();

    //     return redirect()->route('products.index')
    //         ->with('success','Product deleted successfully');
    // }

    public function delete($id)
    {
        $url = $this->link . '/' . $id;

        return view('admin/partials.delete')
            ->with(compact('url'));
    }

    public function destroy($ids)
    {
        $ids = explode(',', $ids);

        foreach ($ids as $id) {
            $item = Product::findOrFail($id);
            $item->delete();
        }
        flash('Product deleted successfully.')->success();

        return redirect($this->link);
    }

    // public function setVisibility($ids) {
    //     $ids = explode(',', $ids);

    //     foreach ($ids as $id) {
    //         $item = Product::findOrFail($id);

    //         $item->active = !$item->active;
    //     }

    //     return redirect($this->link);
    // }

    public function setVisibility($id, Request $request)
    {
        $item = Product::find($id);

        if ($request['state'] == 1) {
            $item->active = null;
            $item->save();

            return response()->json(["state" => null]);
        } elseif ($request['state'] == NULL) {
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

        $items = Product::where(function ($q) use ($request) {
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
