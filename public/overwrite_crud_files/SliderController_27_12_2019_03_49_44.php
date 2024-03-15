<?php
namespace App\Http\Controllers;

use App\Slider;
use App\Exports\SliderExport; 
use App\Imports\SliderImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class SliderController extends Controller
{
     public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=['checkbox','id','title','subtitle','link','sort_order','status','action'];
                $total_data=Slider::count();
                $limit=$request->input('length');
                $start=$request->input('start');
                
                $order=$col_order[$request->input('order.0.column')];
                $dir=$request->input('order.0.dir');
               
                $is_advanced_search=0;
                $condition=array();
               
               	if(!empty($request->input('title'))) {
                    $condition[]=array('title','like',"%{$request->input('title')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('subtitle'))) {
                    $condition[]=array('subtitle','like',"%{$request->input('subtitle')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('link'))) {
                    $condition[]=array('link','like',"%{$request->input('link')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('sort_order'))) {
                    $condition[]=array('sort_order','=',$request->input('sort_order'));
                    $is_advanced_search=1;
                }if($request->input('status')!="") {
                    $condition[]=array('status','=',$request->input('status'));
                    $is_advanced_search=1;
                }

                if ($is_advanced_search==0) {
                    $result=Slider::offset($start)->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                    $total_filtered=Slider::count();
                }else{
                    $query=Slider::query();
                    $query->where($condition);
                    $query->offset($start);
                    $query->limit($limit);
                    $query->orderBy($order,$dir);
                    $result=$query->get();
                    $total_filtered=count($result);
                }
                 \Session::put('slider_export', $condition);


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

                            $edit='<a href="'.route('slider.edit',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
                            $view='<a href="'.route('slider.show',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
                            $nest['checkbox']='<input type="checkbox" name="data[data_id][]" value="' . $row->id . '"class="checkboxes"/>';
                            $nest['id']=($key+1)+$s_no;
							$nest['title']=$row->title;
							$nest['subtitle']=$row->subtitle;
							$nest['link']=$row->link;
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
		return view('slider.index',[]);

}

	 public function create()
    {
    return view('slider.create',[]);
    }

       function form_validation($request)
    {   
        return $this->validate($request,[
						'title'=>'required',
						'image'=>'required',
						'sort_order'=>'nullable|numeric',
						'status'=>'required'
						],[
						'title.required'=>'please enter title',
						'image.required'=>'please select image',
						'sort_order.numeric'=>'please enter valid sort order',
						'status.required'=>'please enter status'
						]);
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (Slider::create($request->all())) {
            return redirect()->route('slider.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('slider.add')->with('error_message', 'Opps something went wrong!'); 
        }

    }

    public function show(Slider $slider)
    {   
        return view('slider.show',['result'=>$slider]);
    }
    public function edit(Slider $slider)
    {
        return view('slider.edit',['result'=>$slider,]);
    }
  
// ===========

    public function update(Request $request, Slider $slider)
    {
        $this->form_validation($request);
        
        if ($slider->update($request->all())) {
            return redirect()->route('slider.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('slider.edit')->with('error_message', 'Opps something went wrong!'); 
        }
    }

    public function destroy(Slider $slider)
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(Slider::where('id',$id)->update(['status'=>$status])) {
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
             if (Slider::whereIn('id',$data_id)->delete()) {
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