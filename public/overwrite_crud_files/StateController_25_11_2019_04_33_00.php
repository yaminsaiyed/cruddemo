<?php
namespace App\Http\Controllers;

use App\State;
use App\Exports\StateExport; 
use App\Imports\StateImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class StateController extends Controller
{
     public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=['checkbox','id','country_id','name','sort_order','status','action'];
                $total_data=State::count();
                $limit=$request->input('length');
                $start=$request->input('start');
                
                $order=$col_order[$request->input('order.0.column')];
                $dir=$request->input('order.0.dir');
               
                $is_advanced_search=0;
                $condition=array();
               
               	if(!empty($request->input('country_id'))) {
                    $condition[]=array('country_id','=',$request->input('country_id'));
                    $is_advanced_search=1;
                }if(!empty($request->input('name'))) {
                    $condition[]=array('name','like',"%{$request->input('name')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('sort_order'))) {
                    $condition[]=array('sort_order','=',$request->input('sort_order'));
                    $is_advanced_search=1;
                }if($request->input('status')!="") {
                    $condition[]=array('status','=',$request->input('status'));
                    $is_advanced_search=1;
                }

                if ($is_advanced_search==0) {
                    $result=State::offset($start)->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                    $total_filtered=State::count();
                }else{
                    $query=State::query();
                    $query->where($condition);
                    $query->offset($start);
                    $query->limit($limit);
                    $query->orderBy($order,$dir);
                    $result=$query->get();
                    $total_filtered=count($result);
                }
                 \Session::put('state_export', $condition);


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

                            $edit='<a href="'.route('state.edit',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
                            $view='<a href="'.route('state.show',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
                            $nest['checkbox']='<input type="checkbox" name="data[data_id][]" value="' . $row->id . '"class="checkboxes"/>';
                            $nest['id']=($key+1)+$s_no;
							$nest['country_id']=$row->get_country->name;
							$nest['name']=$row->name;
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
		return view('state.index',["country_select_list"=>\App\Country::where('status',1)->orderBy('name','asc')->pluck('name','id')]);

}

	 public function create()
    {
    return view('state.create',["country_select_list"=>\App\Country::where('status',1)->orderBy('name','asc')->pluck('name','id')]);
    }

       function form_validation($request)
    {   
        return $this->validate($request,[
						'country_id'=>'required',
						'name'=>'required',
						'status'=>'required',
						'sort_order'=>'nullable|numeric'
						],[
						'country_id.required'=>'please select country',
						'name.required'=>'please enter name',
						'status.required'=>'please enter status',
						'sort_order.numeric'=>'please enter valid sort order'
						]);
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (State::create($request->all())) {
            return redirect()->route('state.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('state.add')->with('error_message', 'Opps something went wrong!'); 
        }

    }

    public function show(State $state)
    {   
        return view('state.show',['result'=>$state]);
    }
    public function edit(State $state)
    {
        return view('state.edit',['result'=>$state,"country_select_list"=>\App\Country::where('status',1)->orderBy('name','asc')->pluck('name','id')]);
    }
  
// ===========

    public function update(Request $request, State $state)
    {
        $this->form_validation($request);
        
        if ($state->update($request->all())) {
            return redirect()->route('state.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('state.edit')->with('error_message', 'Opps something went wrong!'); 
        }
    }

    public function destroy(State $state)
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(State::where('id',$id)->update(['status'=>$status])) {
                $status=true;
                $message="record status successfully updated";
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
             if (State::whereIn('id',$data_id)->delete()) {
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
    }public function exportExcel()
      {
        return Excel::download(new StateExport, 'state.xlsx');
      }

      public function exportCSV()
      {
        return Excel::download(new StateExport, 'state.csv');
      }
	public function import() 
    {   
        if (Excel::import(new StateImport,request()->file('import'))) {
        return back()->with('success_message', 'Data Successfully Imported');    
        }else{
        return back()->with('error_message', 'Opps something went wrong');
        }
        
    }
}