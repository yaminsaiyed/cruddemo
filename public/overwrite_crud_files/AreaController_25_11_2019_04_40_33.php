<?php
namespace App\Http\Controllers;

use App\Area;
use App\Exports\AreaExport; 
use App\Imports\AreaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class AreaController extends Controller
{
     public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=['checkbox','id','city_id','name','sort_order','status','action'];
                $total_data=Area::count();
                $limit=$request->input('length');
                $start=$request->input('start');
                
                $order=$col_order[$request->input('order.0.column')];
                $dir=$request->input('order.0.dir');
               
                $is_advanced_search=0;
                $condition=array();
               
               	if(!empty($request->input('city_id'))) {
                    $condition[]=array('city_id','=',$request->input('city_id'));
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
                    $result=Area::offset($start)->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                    $total_filtered=Area::count();
                }else{
                    $query=Area::query();
                    $query->where($condition);
                    $query->offset($start);
                    $query->limit($limit);
                    $query->orderBy($order,$dir);
                    $result=$query->get();
                    $total_filtered=count($result);
                }
                 \Session::put('area_export', $condition);


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

                            $edit='<a href="'.route('area.edit',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
                            $view='<a href="'.route('area.show',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
                            $nest['checkbox']='<input type="checkbox" name="data[data_id][]" value="' . $row->id . '"class="checkboxes"/>';
                            $nest['id']=($key+1)+$s_no;
							$nest['city_id']=$row->get_city->name;
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
		return view('area.index',["city_select_list"=>\App\City::where('status',1)->orderBy('name','asc')->pluck('name','id')]);

}

	 public function create()
    {
    return view('area.create',["city_select_list"=>\App\City::where('status',1)->orderBy('name','asc')->pluck('name','id')]);
    }

       function form_validation($request)
    {   
        return $this->validate($request,[
						'city_id'=>'required',
						'name'=>'required',
						'status'=>'required',
						'sort_order'=>'nullable|numeric'
						],[
						'city_id.required'=>'please select city',
						'name.required'=>'please enter name',
						'status.required'=>'please enter status',
						'sort_order.numeric'=>'please enter valid sort order'
						]);
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (Area::create($request->all())) {
            return redirect()->route('area.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('area.add')->with('error_message', 'Opps something went wrong!'); 
        }

    }

    public function show(Area $area)
    {   
        return view('area.show',['result'=>$area]);
    }
    public function edit(Area $area)
    {
        return view('area.edit',['result'=>$area,"city_select_list"=>\App\City::where('status',1)->orderBy('name','asc')->pluck('name','id')]);
    }
  
// ===========

    public function update(Request $request, Area $area)
    {
        $this->form_validation($request);
        
        if ($area->update($request->all())) {
            return redirect()->route('area.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('area.edit')->with('error_message', 'Opps something went wrong!'); 
        }
    }

    public function destroy(Area $area)
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(Area::where('id',$id)->update(['status'=>$status])) {
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
             if (Area::whereIn('id',$data_id)->delete()) {
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
        return Excel::download(new AreaExport, 'area.xlsx');
      }

      public function exportCSV()
      {
        return Excel::download(new AreaExport, 'area.csv');
      }
	public function import() 
    {   
        if (Excel::import(new AreaImport,request()->file('import'))) {
        return back()->with('success_message', 'Data Successfully Imported');    
        }else{
        return back()->with('error_message', 'Opps something went wrong');
        }
        
    }
}