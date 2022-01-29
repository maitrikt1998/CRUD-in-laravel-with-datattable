<?php

namespace App\Http\Controllers;
// use Datatables;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Person;
class Personcontroller extends Controller
{
    //
    public function index(){
        if(request()->ajax()){
            $persons = Person::get();
            // dd($persons);
            return DataTables::of($persons)->addColumn('action', function($row){
                
                
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success edit"> Edit
                </a>';
                $btn = $btn.'   <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Delete" data-id="'.$row->id.'" class="delete btn btn-danger">
                Delete
            </a>';
                
   


                 return $btn;
         })
         ->rawColumns(['action'])->setRowId('id')->addIndexColumn()->make(true);
        }
        return view('index');
    }

    public function store(Request $req){
        $personId = $req->id;
        // dd($personId);
        $person = Person::updateOrCreate(
            [
                'id'=>$personId
            ],
            [
                'firstname'=>$req->fname,
                'lastname'=>$req->lname,
                'email'=>$req->email,
                'gender'=>$req->gender,
            ]);
            return Response()->json($person);
    }

    public function edit(Request $req){
        $person = Person::where('id',$req->id)->first();
        return Response()->json($person);
    }

    public function destroy(Request $request)
    {
        $book = Person::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }
}
