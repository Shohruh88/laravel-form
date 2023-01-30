<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function uploadPage()
    {
        return view("fileupload");
    }


    // public function request(){

    // }

    public function store(Request $request){
    //Validatsiyadan o'tirish
    $request->validate([
        'firstname' => 'required',
        'lastname' => 'required',
        'description' => 'required',
        'type' => 'required',
        'date' => 'required',
        'foto' => 'required|mimes:png,jpg,jpeg|max:32768',
        'excel' => 'required|mimes:xlsx,xls|max:32768',
        'pdf' => 'required|mimes:pdf,docx,doc|max:32768',
        'range' => 'required'
    ]);

    $pdfName = time().'.'.$request->file('pdf')->extension();
    $excelName = time(). '.' . $request->file('excel')->extension();
    $imageName = time(). '.' . $request->file('image')->extension();

    $request->file->move(public_path('pdf'), $pdfName);
    $request->file->move(public_path('excel'), $excelName);
    $request->file->move(public_path('image'), $imageName);

    File::query()->create([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'description' => $request->desc,
        'type' => $request->type,
        'date' => $request->date,
        'foto' => $imageName,
        'excel' => $excelName,
        'pdf' => $pdfName,
        'range' => $request->range,
    ]);

    return response()->json([
        'message' => "Success!"
    ]);


    }

}


