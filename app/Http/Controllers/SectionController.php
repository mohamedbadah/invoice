<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\section;
use Illuminate\Http\Request;
use App\Models\invoiceDetail;
use App\Models\Invoice_attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = 1;
        $sections = Section::paginate(5);
        $d = $sections->currentPage() - 1;
        return view('section.section', compact('sections', 'c', 'd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name_section' => 'required|unique:sections,section_name',
            'description' => 'required'
        ], [
            'name_section.required' => 'ادخل الاسم صحيح',
            'name_section.unique' => 'الاسم موجود مسبقا',
            'description.required' => 'الرجاء ادخال اسم الوصف'
        ]);
        if ($validation) {
            Section::create([
                'section_name' => $request->name_section,
                'description' => $request->description,
                'created_by' => Auth::user()->name
            ]);
            session()->flash('add', 'لقد تمت الاضافة بنجاج');
        }
        return redirect()->route('user.section.index');
        // $section = Section::where('section_name', $request->name_section)->exists();
        // if ($section) {
        //     session()->flash('error', 'القسم موجود مسبقا');
        //     return redirect()->route('user.section.index');
        // } else {
        //     $store = Section::create([
        //         'section_name' => $request->name_section,
        //         'description' => $request->description,
        //         'created_by' => Auth::user()->name
        //     ]);
        //     session()->flash('add', 'لقد تمت الاضافة بنجاج');
        //     return redirect()->route('user.section.index');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(section $section)
    {
        // $invoice = Invoice::findOrFail($section->id);
        // $invoice_detail = invoiceDetail::where('section', $section->id)->first();
        // $i = $section->invoice_detail;
        // $i = $section->with('invoice_detail')->get();
        // $invoice_attachment=Invoice_attachment::where('');
        return view('section.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = section::find($id);
        return view('section.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'name_update' => 'required|unique:sections,section_name,' . $id,
            'disc' => 'required'
        ]);
        if ($validation) {
            $update = section::find($id);
            $update->section_name = $request->name_update;
            $update->description = $request->disc;
            $isSave = $update->save();
            session()->flash('succ', 'تم التحديث');
            return redirect()->route('user.section.index');
        } else {
            session()->flash('falid', 'فشل التحديث');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::where('id', $id);
        $delete = $section->delete();
        if ($delete) {
            return redirect()->route('user.section.index');
        }
    }
    public function getProduct($id)
    {
        $section = Section::findOrFail($id);
        // $section = Section::where('id', $id)->first();
        $product = DB::table('products')->where('section_id', $section->id)->pluck('product_name', 'id');
        return json_encode($product);
        // dd($product);
    }
}
