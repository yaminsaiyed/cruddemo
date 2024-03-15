<?php
namespace App\Http\Controllers;

use App\CmsPage;
use App\Exports\CmsPageExport; 
use App\Imports\CmsPageImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class CmsPageController extends Controller
{
     public function __construct() {
        $this->middleware('auth',['except' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=['checkbox','id','title','short_description','long_description','meta_title','meta_description','status','action'];
                $total_data=CmsPage::count();
                $limit=$request->input('length');
                $start=$request->input('start');
                
                $order=$col_order[$request->input('order.0.column')];
                $dir=$request->input('order.0.dir');
               
                $is_advanced_search=0;
                $condition=array();
               
               	if(!empty($request->input('title'))) {
                    $condition[]=array('title','like',"%{$request->input('title')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('short_description'))) {
                    $condition[]=array('short_description','like',"%{$request->input('short_description')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('long_description'))) {
                    $condition[]=array('long_description','like',"%{$request->input('long_description')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('meta_title'))) {
                    $condition[]=array('meta_title','like',"%{$request->input('meta_title')}%");
                    $is_advanced_search=1;
                }if(!empty($request->input('meta_description'))) {
                    $condition[]=array('meta_description','like',"%{$request->input('meta_description')}%");
                    $is_advanced_search=1;
                }if($request->input('status')!="") {
                    $condition[]=array('status','=',$request->input('status'));
                    $is_advanced_search=1;
                }

                if ($is_advanced_search==0) {
                    $result=CmsPage::offset($start)->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
                    $total_filtered=CmsPage::count();
                }else{
                    $query=CmsPage::query();
                    $query->where($condition);
                    $query->offset($start);
                    $query->limit($limit);
                    $query->orderBy($order,$dir);
                    $result=$query->get();
                    $total_filtered=count($result);
                }
                 \Session::put('cmspage_export', $condition);


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

                            $edit='<a href="'.route('cmspage.edit',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>';
                            $view='<a href="'.route('cmspage.show',$row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
                            $nest['checkbox']='<input type="checkbox" name="data[data_id][]" value="' . $row->id . '"class="checkboxes"/>';
                            $nest['id']=($key+1)+$s_no;
							$nest['title']=$row->title;
							$nest['short_description']=$row->short_description;
							$nest['long_description']=$row->long_description;
							$nest['meta_title']=$row->meta_title;
							$nest['meta_description']=$row->meta_description;
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
		return view('cmspage.index',[]);

}

	 public function create()
    {
    return view('cmspage.create',[]);
    }

       function form_validation($request,$id="")
    {   
        return $this->validate($request,[
						'title'=>'required',
						'seo_keyword'=>'required|unique:cms_page,seo_keyword'.($id ? ",$id" : ''),
						'status'=>'required',
						'sort_order'=>'nullable|numeric'
						],[
						'title.required'=>'please enter title',
						'seo_keyword.required'=>'please enter seo keyword',
						'status.required'=>'please enter status',
						'sort_order.numeric'=>'please enter valid sort order'
						]);
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (CmsPage::create($request->all())) {
            return redirect()->route('cmspage.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('cmspage.add')->with('error_message', 'Opps something went wrong!'); 
        }

    }

    public function show(CmsPage $cmspage)
    {   
        return view('cmspage.show',['result'=>$cmspage]);
    }
    public function edit(CmsPage $cmspage)
    {
        return view('cmspage.edit',['result'=>$cmspage,]);
    }
  
// ===========

    public function update(Request $request, CmsPage $cmspage)
    {
        $this->form_validation($request,$cmspage->id);
        
        if ($cmspage->update($request->all())) {
            return redirect()->route('cmspage.index')->with('success_message', 'Data Successfully Submitted');   
        }else{
            return redirect()->route('cmspage.edit')->with('error_message', 'Opps something went wrong!'); 
        }
    }

    public function destroy(CmsPage $cmspage)
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(CmsPage::where('id',$id)->update(['status'=>$status])) {
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
             if (CmsPage::whereIn('id',$data_id)->delete()) {
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