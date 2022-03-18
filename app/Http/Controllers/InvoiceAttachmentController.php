<?php

namespace App\Http\Controllers;

use session;
use Illuminate\Http\Request;
use App\Models\Invoice_attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'pic' => 'required,mimes:pdf,jpg,png'
        ]);
        if ($validation) {
            $attach = new Invoice_attachment();
            $attach->invoice_number = $request->invoice_number2;
            $attach->invoice_id = $request->invoice_id2;
            $attach->created_by = Auth::user()->name;
            $ex = $request->file('pic')->getClientOriginalExtension();
            $newName = 'attach_' . time() . '.' . $ex;
            $request->file('pic')->move(public_path('uploade'), $newName);
            $attach->file_name = $newName;
            $isSave = $attach->save();
            session()->flash('success', 'لقد تم اضافة المرفق بنجاح');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $attach = Invoice_attachment::where('id', $id)->first();
        $isDeleted = $attach->delete();
        $s = Storage::disk('upload')->delete($attach->file_name);
        if ($isDeleted) {
            return response()->json(
                ['icon' => 'success', 'title' => 'deleted', 'text' => 'successfully deleted'],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['icon' => 'faild', 'title' => 'not deleteted', 'text' => 'faild deleted'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
