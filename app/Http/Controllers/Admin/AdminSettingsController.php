<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store\Order;
use Auth;

class AdminSettingsController extends Controller
{
    public $folder = 'admin/settings';
    public $link = '/admin/settings';
    public $section = 'Settings';
    public $pags = 50;

    public function index()
    {

        return view($this->folder.'.index')
            ->with('link', $this->link)
            ->with('section', $this->section)
            ->with('folder', $this->folder);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->folder.'.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $auth = Auth::user();

        $item = new Products();
        $item->user_id = $auth->id;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->active = $request->active ? 1 : null;
        
        Order::create($item->toArray());
        
        flash('Product created successfully.')->success();

        return redirect()->route('orders.index');

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
        $item = Order::find($id);

        return view($this->folder.'.edit')
            ->with('item', $item)
            ->with('link', $this->link)
            ->with('section', $this->section)
            ->with('folder', $this->folder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // 'name' => 'required',
        ]);

        $details = collect([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'county' => $request->input('county'),
            'locality' => $request->input('locality')
        ]);

        $item = Order::find($id);
        
        $item->status_delivery = $request->status_delivery;
        $item->details = serialize($details);      
        $item->notes = $request->notes;      
        $item->save();

        flash('Order updated successfully.')->success();
        
        return redirect()->route('orders.index');
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
            $item = Order::findOrFail($id);
            $item->delete();
        }

        return redirect($this->link);
    }

    public function setVisibility($id, Request $request) {
        $item = Order::find($id);

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
}
