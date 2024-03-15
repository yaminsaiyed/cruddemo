<?php
namespace App\Http\Controllers;

use App\TableName;
use App\Exports\TableNameExport; 
use App\Imports\TableNameImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class TableNameController extends Controller
{
     public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=['checkbox','id','name','description','long_description','very_long_description','date','status','action'];
                $total_data=TableName::count();
                $limit=$request->input('length');
                $start=$request->input('start');
                
                $order=$col_order[$request->input('order.0.column')];
                $dir=$request->input('order.0.dir');
               
                $is_advanced_search=0;
                $condition=array();
               
               	if(!empty($request->input('name'))) {
                    $condition[]=array('name','like',"%{$request->input('name')}%");
                    $is_advanced_search=1;
                }
                if(!empty($request->input('description'))) {
                    $condition[]=array('description','like',"%{$request->input('description')}%");
                    $is_advanced_search=1;
                }
                if(!empty($request->input('long_description'))) {
                    $condition[]=array('long_description','like',"%{$request->input('long_description')}%");
                    $is_advanced_search=1;
                }
                if(!empty($request->input('very_long_description'))) {
                    $condition[]=array('very_long_description','like',"%{$request->input('very_long_description')}%");
                    $is_advanced_search=1;
                }if($request->input('date')!="") {
                    $condition[]=array('date','=',date('Y-m-d',strtotime($request->input('date'))));
                    $is_advanced_search=1;
                }if($request->input('status')!="") {
                    $condition[]=array('status','=',$request->input('status'));
                    $is_advanced_search=1;
                }

                if ($is_advanced_search==0) {
                    $result=TableName::offset($start)->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                    $total_filtered=TableName::count();
                }else{
                    $query=TableName::query();
                    $query->where($condition);
                    $query->offset($start);
                    $query->limit($limit);
                    $query->orderBy($order,$dir);
                    $result=$query->get();
                    $total_filtered=count($result);
                }
                 \Session::put('tablename_export', $condition);


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

                            $edit='<a href="'.route('tablename.edit',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
                            $view='<a href="'.route('tablename.show',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
                            $nest['checkbox']='<input type="checkbox" name="data[data_id][]" value="' . $row->id . '"class="checkboxes"/>';
                            $nest['id']=($key+1)+$s_no;
							$nest['name']=$row->name;
							$nest['description']=$row->description;
							$nest['long_description']=$row->long_description;
							$nest['very_long_description']=$row->very_long_description;
							$nest['date']=\AppHelper::getDateFormat($row->date);
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
		return view('tablename.index',[]);

}

	 public function create()
    {
    return view('tablename.create',["country_select_list"=>\App\Country::where('status',1)->orderBy('name','asc')->pluck('name','id')]);
    }

       function form_validation($request)
    {   
        return $this->validate($request,[
						'name'=>'required',
						'date'=>'required',
						'time'=>'required',
						'datetime'=>'required',
						'price'=>'required',
						'status'=>'required',
						'sort_order'=>'nullable|numeric'
						],[
						'name.required'=>'please enter name',
						'date.required'=>'please enter date',
						'time.required'=>'please enter time',
						'datetime.required'=>'please enter datetime',
						'price.required'=>'please enter price',
						'status.required'=>'please enter status',
						'sort_order.numeric'=>'please enter valid sort order'
						]);
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (TableName::create($request->all())) {
            return redirect()->route('tablename.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('tablename.add')->with('error_message', 'Opps something went wrong!'); 
        }

    }

    public function show(TableName $tablename)
    {   
        return view('tablename.show',['result'=>$tablename]);
    }
    public function edit(TableName $tablename)
    {
        return view('tablename.edit',['result'=>$tablename,"country_select_list"=>\App\Country::where('status',1)->orderBy('name','asc')->pluck('name','id')]);
    }
  
// ===========

    public function update(Request $request, TableName $tablename)
    {
        $this->form_validation($request);
        
        if ($tablename->update($request->all())) {
            return redirect()->route('tablename.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('tablename.edit')->with('error_message', 'Opps something went wrong!'); 
        }
    }

    public function destroy(TableName $tablename)
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(TableName::where('id',$id)->update(['status'=>$status])) {
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
             if (TableName::whereIn('id',$data_id)->delete()) {
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