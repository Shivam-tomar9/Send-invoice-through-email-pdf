<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Product;
use App\Mail\SignupEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;




class AjaxController extends Controller
{
    public function add()
    {
      return view('ajax.add');
    }
     public function save(Request $request)
    {
      $data =array(
        
        'name'=>$request->name,
        'phoneno'=>$request->phoneno,
        'email'=>$request->email,
        'address'=>$request->address,
        'created_at'=>date('Y-m-d H:i:s')
      );


       $customer_id= Customer::insertGetId($data);


       for($i=0;$i<count($request->productname);$i++)
       {
        $data =array(
          'customer_id'=>$customer_id,
          'productname'=>$request->productname[$i],
          'productprice'=>$request->productprice[$i],
          'created_at'=>date('Y-m-d H:i:s')



        );
        Product::insert($data);
       }
       return redirect('/ajax-index');

    }
     public function index()
    {
        $data=Customer::get();
        $input=Product::get();
        return view('ajax.index',compact('data','input'));
    }
     public function edit($id)
    {
        $crud=Customer::find($id);
        $data=Product::where('customer_id',$id)->get();
        return view('ajax.edit',compact('data','crud'));
    }
     public function update(Request $request)
    {
      $data =array(
        
        'name'=>$request->name,
        'phoneno'=>$request->phoneno,
        'email'=>$request->email,
        'address'=>$request->address,
        'updated_at'=>date('Y-m-d H:i:s')
      );
      Customer::where('id',"=",$request->id)->update($data);
      Product::where('customer_id',"=",$request->id)->delete();


      for($i=0;$i<count($request->productname);$i++)
       {
        $data =array(
          'customer_id'=>$request->id,
          'productname'=>$request->productname[$i],
          'productprice'=>$request->productprice[$i],
          'created_at'=>date('Y-m-d H:i:s')



        );
        Product::insert($data);
       }
       return redirect('/ajax-index');

    }
     public function delete($id)
    {
        $data=Customer::find($id);
        if($data)
        {
          Product::where('customer_id',$id)->delete();
          $data->delete();
        }
        return redirect('/ajax-index');
    }
    
     
    public function custom()
 {
     return view('ajax.custom');

 }


    public function sendEmail()
  {
   Mail::to('tomarshivam987@gmail.com')->send(new SignupEmail());
   dd("Email has been sent");
 }
}
