<?php
namespace App\Http\Controllers;

use App\Testy;
use App\Exports\TestyExport; 
use App\Imports\TestyImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class TestyController extends Controller
{
     public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=['checkbox','id','name','date_test','long_text_test','sort_order','status','action'];
                $total_data=Testy::count();
                $limit=$request->input('length');
                $start=$request->input('start');
                
                $order=$col_order[$request->input('order.0.column')];
                $dir=$request->input('order.0.dir');
               
                $is_advanced_search=0;
                $condition=array();
               
               	if(!empty($request->input('name'))) {
                    $condition[]=array('name','like',"%{$request->input('name')}%");
                    $is_advanced_search=1;
                }if($request->input('date_test')!="") {
                    $condition[]=array('date_test','=',date('Y-m-d',strtotime($request->input('date_test'))));
                    $is_advanced_search=1;
                }if(!empty($request->input('long_text_test'))) {
                    $condition[]=array('long_text_test','like',"%{$request->input('long_text_test')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('sort_order'))) {
                    $condition[]=array('sort_order','=',$request->input('sort_order'));
                    $is_advanced_search=1;
                }if($request->input('status')!="") {
                    $condition[]=array('status','=',$request->input('status'));
                    $is_advanced_search=1;
                }

                if ($is_advanced_search==0) {
                    $result=Testy::offset($start)->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                    $total_filtered=Testy::count();
                }else{
                    $query=Testy::query();
                    $query->where($condition);
                    $query->offset($start);
                    $query->limit($limit);
                    $query->orderBy($order,$dir);
                    $result=$query->get();
                    $total_filtered=count($result);
                }
                 \Session::put('testy_export', $condition);


                    $page_no=0;
                    if ($start != 0) {
                        $page_no = ($start / $limit) + 1;
                    }
                    $s_no=0;
                    if($page_no>1)
                    {
                        $s_no=($page_no-1)*$limit;  
                    }
                    $data=array();
                    if($result){
                        foreach ($result as $key => $row) {

                            $edit='<a href="'.route('testy.edit',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
                            $view='<a href="'.route('testy.show',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
                            $nest['checkbox']='<input type="checkbox" name="data[data_id][]" value="' . $row->id . '"class="checkboxes"/>';
                            $nest['id']=($key+1)+$s_no;
							$nest['name']=$row->name;
							$nest['date_test']=\AppHelper::getDateFormat($row->date_test);
							$nest['long_text_test']=$row->long_text_test;
							$nest['sort_order']=$row->sort_order;
							$nest['status']='<label class="switch"><input type="checkbox" name="checkbox" value="'.$row->id.'" class ="on_off" '.($row->status==1?"checked":"").'><span class="slider round"></span></label>';
                            $nest['action']=$edit."&nbsp;".$view;
                            $data[]=$nest;
                        }
                    }
                $json=array(
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => intval($total_data),
                    'recordsFiltered' => intval($total_filtered),
                    'data' => $data,
                );

                return response()->json($json);
                
        }
		return view('testy.index',[]);

}

	 public function create()
    {
    return view('testy.create',[]);
    }

       function form_validation($request)
    {   
        return $this->validate($request,[
						'name'=>'required',
						'date_test'=>'required',
						'time_test'=>'required',
						'long_text_test'=>'required',
						'image'=>'required',
						'status'=>'required',
						'sort_order'=>'nullable|numeric'
						],[
						'name.required'=>'please enter name',
						'date_test.required'=>'please enter date test',
						'time_test.required'=>'please enter time test',
						'long_text_test.required'=>'please enter long text test',
						'image.required'=>'please select image',
						'status.required'=>'please enter status',
						'sort_order.numeric'=>'please enter valid sort order'
						]);
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (Testy::create($request->all())) {
            return redirect()->route('testy.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('testy.add')->with('error_message', 'Opps something went wrong!'); 
        }

    }

    public function show(Testy $testy)
    {   
        return view('testy.show',['result'=>$testy]);
    }
    public function edit(Testy $testy)
    {
        return view('testy.edit',['result'=>$testy]);
    }
  
// ===========

    public function update(Request $request, Testy $testy)
    {
        $this->form_validation($request);
        
        if ($testy->update($request->all())) {
            return redirect()->route('testy.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('testy.edit')->with('error_message', 'Opps something went wrong!'); 
        }
    }

    public function destroy(Testy $testy)
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(Testy::where('id',$id)->update(['status'=>$status])) {
                $status=true;
                $message="Status successfully updated";
             }else{
                $status=false;
                $message="Opps Something went wrong";
             }
        
        }else{
                $status=false;
                $message="Bad Request";
        }
        
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    function multiple_delete(Request $request)
    {
        
        if($request->ajax()){
             $data_id = json_decode($request->data_id);
             if (Testy::whereIn('id',$data_id)->delete()) {
                $status=true;
                $message="Record successfully deleted";
             }else{
                $status=false;
                $message="Opps Something went wrong";
             }
        
        }else{
                $status=false;
                $message="Bad Request";
        }
        
        return response()->json(['status'=>$status,'message'=>$message]);
    }
}