<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeOfService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Layanan Laundry';
        $services = TypeOfService::all();
        return view('admin.service.index', compact('title', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Data Layanan';
        $services = TypeOfService::all();
        return view('admin.service.create', compact('title', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TypeOfService::create([
            'service_name'=>$request->service_name,
            'price'=>$request->price,
            'description'=>$request->description
        ]);

        Alert::success('Excellent', 'Add service data successfully');
        return redirect()->to('service')->with('success', 'Add service data successfully');
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
        $title = 'Ubah Jenis Layanan';
        $edit = TypeOfService::find($id);
        return view('admin.service.edit', compact('title', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = ([
            'service_name'=>['required'],
            'price'=>['required'],
            'description'=>['nullable']
        ]);
        $validators = Validator::make($request->all(), $rules);
        if ($validators->fails()) {
            return back()->withErrors($validators)->withInput();
        };

        $data = [
            'service_name'=>$request->service_name,
            'price'=>$request->price,
            'description'=>$request->description
        ];

        Alert::success('Excellent', 'Update data service successfully');
        TypeOfService::where('id', $id)->update($data);
        return redirect()->to('service')->with('success', 'Update data service successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TypeOfService::find($id)->delete();
        toast('Delete data service successfully', 'success');
        return redirect()->to('service')->with('success', 'Delete data service successfully');
    }
}