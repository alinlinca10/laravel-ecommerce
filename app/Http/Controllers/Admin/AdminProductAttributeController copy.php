<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Store\Product;
use App\Models\Store\Category;
use App\Models\Store\ProductAttribute;
use App\Models\Store\ProductAttributeValue;
use Auth;
use stdClass;
use Input;
use Str;

class AdminProductAttributeController extends Controller
{
    public $folder = 'admin/products/attributes';
    public $link = '/admin/products/attributes';
    public $section = 'Products attributes';
    public $pags = 50;

    public function index()
    {
        $items = ProductAttribute::orderBy('id', 'desc')
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

        $item = new ProductAttribute();
        
        return view($this->folder.'.create')
            ->with(compact('item'))
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
                'value' => 'required',
            ]);


        $item = new ProductAttribute();
        $item->name = $request->name;
        $item->active = $request->active ? 1 : null;
        $item = ProductAttribute::create($item->toArray());

        $attrValue = new ProductAttributeValue();
        $attrValue->attribute_id = $item->id;
        $attrValue->value = $request->value;
        $attrValue = ProductAttributeValue::create($attrValue->toArray());
        // dd($request->all());

            
        // if ($validator->fails())
        //     return redirect()->back()->withInput()->withErrors($validator);

        flash('Attribute created successfully.')->success();

        return redirect()->route('attributes.index');

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
        $item = ProductAttribute::find($id);

        return view($this->folder.'.edit')
            ->with(compact('item'))
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
                'value' => 'required|unique:table,column,except,id',
            ]);

        $item = ProductAttribute::find($id);
        $item->name = $request->name;
        $item->active = $request->active ? 1 : null;
        $item->save();

        if ($request->has('value')) {
            foreach ($request->input('value') as $attributeValue) {
                // Verificăm dacă valoarea atributului nu este goală și nu există deja în baza de date
                if (!empty($attributeValue) && !ProductAttributeValue::where('attribute_id', $item->id)->where('value', $attributeValue)->exists()) {
                    $newAttribute = new ProductAttributeValue();
                    $newAttribute->attribute_id = $item->id;
                    $newAttribute->value = $attributeValue;
                    $newAttribute->save();
                }
            }
        }

        if ($request->has('image')) {
            dd($request->input('image'));

            foreach ($request->input('image') as $attributeValue) {
                // Verificăm dacă valoarea atributului nu este goală și nu există deja în baza de date
                if (!empty($attributeValue) && !ProductAttributeValue::where('attribute_id', $item->id)->where('value', $attributeValue)->exists()) {

                    $newAttribute = new ProductAttributeValue();
                    $newAttribute->attribute_id = $item->id;
                    $newAttribute->value = $attributeValue;
                    $newAttribute->image = $request->input('image');
                    $newAttribute->save();
                }
            }
        }

        // if ($request->has('deleteAttribute')) {
        //     dd('are');
        //     $deletedAttributes = $request->input('deleteAttribute');
        //     // Iterați prin atributurile de șters și ștergeți-le din baza de date
        //     foreach ($deletedAttributes as $deletedAttribute) {
        //         ProductAttributeValue::find($deletedAttribute)->delete();
        //     }
        // }
            
        flash('Attribute updated successfully!')->success();

        return redirect()->back();
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

    public function delete($id) {
        $url = $this->link.'/' . $id;

        return view('admin/partials.delete')
            ->with(compact('url'));
    }

    public function destroy($ids) {
        $ids = explode(',', $ids);

        foreach ($ids as $id) {
            $item = ProductAttribute::findOrFail($id);
            $item->delete();
        }
        flash('Attribute deleted successfully.')->success();

        return redirect()->back();
    }

    // public function setVisibility($ids) {
    //     $ids = explode(',', $ids);

    //     foreach ($ids as $id) {
    //         $item = Product::findOrFail($id);

    //         $item->active = !$item->active;
    //     }

    //     return redirect($this->link);
    // }

    public function setVisibility($id, Request $request) {
        $item = ProductAttribute::find($id);

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

    public function deleteAttribute(Request $request)
    {
        $attributeId = $request->input('attribute_id');
        $attribute = ProductAttributeValue::find($attributeId);
        
        if ($attribute) {
            $attribute->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    
    public function getAttributeValues($attribute_id)
    {
        $attributeValues = ProductAttributeValue::where('attribute_id', $attribute_id)->get();
        return response()->json($attributeValues);
    }
    
}
