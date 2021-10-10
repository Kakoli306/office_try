<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
    $companies = Company::latest()->paginate(5);
    
     return view('companies.index',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $companies = Company::all();
        return view('companies.create', compact('companies'));
    }

  public function store(Request $request)  // this function store or save new data in table
  {
    $request->validate([
        'name' => 'required',
        'website' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|min:100',
    ]);

    $input = $request->all();

    if ($image = $request->file('image')) {
        $destinationPath = 'image/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $input['image'] = "$profileImage";
    }

    Company::create($input);
 
    return redirect()->route('companies.index')
                    ->with('success','Company created successfully.');

  }

  public function show(Company $company)  // this function show data according id 
  {
    return view('companies.show',compact('company'));
  }

  public function edit(Company $company)
  {
      return view('companies.edit',compact('company'));
  }

  public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
        'website' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'address' => 'required',
        ]);
  
        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }
          
        $company->update($input);
    
        return redirect()->route('companies.index')
                        ->with('success','Company updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
     
        return redirect()->route('companies.index')
                        ->with('success','Company deleted successfully');
    }
}
