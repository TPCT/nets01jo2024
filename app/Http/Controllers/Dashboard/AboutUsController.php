<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function __construct(AboutUs $model)
    {
        $this->model = $model;
        $this->middleware(['permission:read-about_us'])->only('index');
        $this->middleware(['permission:create-about_us'])->only('create');
        $this->middleware(['permission:update-about_us'])->only('update');
        $this->middleware(['permission:delete-about_us'])->only('destroy');

    }
    public function edit( $id ){
        $row = AboutUs::first();
        return view('dashboard.about_us.edit' ,compact('row'));
    }

    public function update(Request $request)
    {

         $about_us = $this->model->first();
        $request->validate([
            'ar.description'          => ['required', 'min:3','max:5000' ],
            'en.description'          => ['required', 'min:3','max:5000' ],
        ]);
        $about_us->update( $request->all() );
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.about_us.edit' , 1 );
    }
}
