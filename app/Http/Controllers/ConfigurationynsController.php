<?php
/*

-varchar lentgh 211 then image
-long text then ckeditor
-date then datepicker
-time then timepicker
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ConfigurationynsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth', ['except' => array()]);
	}

	function bismillah()
	{

		return view('configurationyns.create');
	}
	function store(Request $request)
	{

		$model_name = $request->model;
		$controller_name = $request->controller . "Controller";
		$table_name = $request->table;
		$hasmany_comma = $request->has_many;
		$hasone_comma = $request->has_one;
		$label_name = $request->label_name;

		// create model start
		$fillable_array = array();
		$index_listing_array[] = 'checkbox';
		$index_listing_array[] = 's_no';
		$index_listing_type[] = 's_no';
		$index_listing_type[] = "first";
		$primary_id = "id";
		$belong_to = "";

		$validation_rules = array();
		$validation_messages = array();

		$export_loop = "";
		$export_heading1 = array();
		$export_heading2 = array();
		$export_heading3 = array();
		$import_array = array();
		$import_row_counter = 0;
		$import_get_data_primary_model = "";
		// dd(DB::select('describe '.$table_name));

		$dropdown_data_set_array = array();
		$dropdown_data_set_array_index_controller = array();

		$get_join_data_index_method = array();
		$get_date_for_filter = array();

		$model_date_time_format_change = "";

		$uniq_key_field = array();
		foreach (DB::select('describe ' . $table_name) as $key => $value) {

			if ($value->Key == "UNI") {
				$uniq_key_field[] = $value->Field;
			}

			if ($value->Field == "created_at" || $value->Field == "updated_at") {
				continue;
			}
			if ($key != 0) {
				$fillable_array[] = $value->Field;
			} else {
				$primary_id = $value->Field;
			}

			// for controller start
			if (count($index_listing_array) <= 6) {

				if ($value->Field == "status") {
				} else if ($value->Type == "time") {
				} else if (strpos($value->Type, '211') !== false) {
				} else {
					$index_listing_array[] = $value->Field;
					$index_listing_type[] = $value->Type;
				}

				if ($value->Key == "MUL") {
					// set dropdown list data start

					$dropdown_data_set_array_index_controller[substr(strtolower($value->Field), 0, -3) . "_select_list"] = '\\App\\' . substr(str_replace("_", '', ucwords($value->Field, "_")), 0, -2) . '::where(\'status\',1)->orderBy(\'name\',\'asc\')->pluck(\'name\',\'id\')';
					// set dropdown list data end	
				}
			}
			// for controller end


			//for validation start


			if (strpos(strtolower($value->Field), 'email') !== false) { //for email
				$temp_email = array();
				if ($value->Null == "NO") {
					$temp_email[] = "required";
				} else {
					$temp_email[] = "nullable";
				}

				if ($value->Key == "UNI") {
					$temp_email[] = 'unique:' . $table_name . ',' . $value->Field . '\'.($id ? ",$id" : \'\')';
				}


				$temp_email[] = "email";

				$validation_rules[] = $value->Field . '=>' . implode("|", $temp_email);

				if ($value->Null == "NO") {

					$temp_email_required_message = "please enter " . str_replace('_', ' ', $value->Field);

					$validation_messages[] = $value->Field . ".required=>" . $temp_email_required_message;
				}

				$temp_email_message = "please enter valid " . str_replace('_', ' ', $value->Field);



				$validation_messages[] = $value->Field . ".email=>" . $temp_email_message;
			} else if (strpos(strtolower($value->Field), 'phone') !== false || strpos(strtolower($value->Field), 'mobile') !== false || strpos(strtolower($value->Field), 'contact') !== false) { //for phone
				$temp_phone = array();
				if ($value->Null == "NO") {
					$temp_phone[] = "required";
				} else {
					$temp_phone[] = "nullable";
				}

				$temp_phone[] = "min:10";
				$temp_phone[] = "max:15";

				if ($value->Key == "UNI") {
					$temp_phone[] = 'unique:' . $table_name . ',' . $value->Field . '\'.($id ? ",$id" : \'\')';
				}



				$validation_rules[] = $value->Field . "=>" . implode("|", $temp_phone);

				if ($value->Null == "NO") {

					$temp_phone_required = "please enter " . str_replace('_', ' ', $value->Field);
					$validation_messages[] = $value->Field . ".required=>" . $temp_phone_required;
				}

				$temp_phone_message = "please enter valid " . str_replace('_', ' ', $value->Field);
				$validation_messages[] = $value->Field . ".min=>" . $temp_phone_message;



				$validation_messages[] = $value->Field . ".max=>" . $temp_phone_message;
			} else if (strpos(strtolower($value->Field), 'sort_order') !== false) { //for sort order

				$temp_sort_order = array();
				$temp_sort_order[] = "nullable";
				$temp_sort_order[] = "numeric";



				$validation_rules[] = $value->Field . "=>" . implode("|", $temp_sort_order);

				$temp_sortorder_message = "please enter valid " . str_replace('_', ' ', $value->Field);


				$validation_messages[] = $value->Field . ".numeric=>" . $temp_sortorder_message;
			} else  if ($value->Null == "NO" && $key != 0) { //for required
				$data_not_null = array();
				$data_not_null[] = "required";

				if ($value->Key == "UNI") {
					$data_not_null[] = 'unique:' . $table_name . ',' . $value->Field . '\'.($id ? ",$id" : \'\')';
				}

				$validation_rules[] = $value->Field . "=>" . implode("|", $data_not_null);


				if (strpos($value->Type, '211') !== false) {
					$temp_not_null_message = "please select " . str_replace('_', ' ', $value->Field);
				} else {

					if ($value->Key == "MUL") {
						$temp_not_null_message = "please select " . str_replace('_', ' ', substr($value->Field, 0, -3));
					} else {
						$temp_not_null_message = "please enter " . str_replace('_', ' ', $value->Field);
					}
				}
				$validation_messages[] = $value->Field . ".required=>" . $temp_not_null_message;
			}

			//for validation end


			//export start
			$is_export_field_done = 0;

			if ($value->Field == "status") {

				$export_loop .= '
		$export_array[$key][\'status\']=($value->status==1?"Active":"Inactive");';

				//import start
				$import_array[] = 'status=>(strtolower($row[' . $import_row_counter . '])==\'active\'?1:0)';
				$import_row_counter++;
				//import end


				$is_export_field_done = 1;
			}

			if ($key != 0) {
				$export_field_type = "Text";
				if (strpos(strtolower($value->Type), 'int') !== false || strpos(strtolower($value->Field), 'phone') !== false || strpos(strtolower($value->Field), 'mobile') !== false || strpos(strtolower($value->Field), 'contact') !== false) {
					$export_field_type = "Number";
				}

				if ($value->Key == "MUL") {

					$export_field_type = "Text";
					$export_heading_str = str_replace("_", " ", ucfirst(substr($value->Field, 0, -3)));
				} else {
					$export_heading_str = $this->string_yns($value->Field);
				}

				$export_heading1[] = $export_heading_str;
				$export_heading2[] = 'Required : ' . ($value->Null == "NO" ? "YES" : "NO");
				$export_heading3[] = 'Type : ' . $export_field_type;
			}


			//export end



			//for join start


			if ($value->Key == "MUL") {

				$get_join_data_index_method[] = $value->Field;

				$belong_to .= '
			public function get_' . substr($value->Field, 0, -3) . '()
		{
			return $this->belongsTo(\'App\\' . substr(str_replace("_", '', ucwords($value->Field, "_")), 0, -2) . '\', \'' . $value->Field . '\', \'id\');
		}';
				//export start
				$export_loop .= '
		$export_array[$key][\'' . strtolower(substr($value->Field, 0, -3)) . '\']=!empty($value->get_' . substr($value->Field, 0, -3) . '->name)?$value->get_' . substr($value->Field, 0, -3) . '->name:"";';
				$is_export_field_done = 1;

				//import start

				$import_array[] = $value->Field . '=>isset(\'App\\' . substr(str_replace("_", '', ucwords($value->Field, "_")), 0, -2) . '\'' . '::where(\'name\',\'like\',$row[' . $import_row_counter . '])->first()->id)?\'App\\' . substr(str_replace("_", '', ucwords($value->Field, "_")), 0, -2) . '\'' . '::where(\'name\',\'like\',$row[' . $import_row_counter . '])->first()->id:' . "''";

				$import_row_counter++;
				//import end

				//export end

				// set dropdown list data start

				$dropdown_data_set_array[substr(strtolower($value->Field), 0, -3) . "_select_list"] = '\\App\\' . substr(str_replace("_", '', ucwords($value->Field, "_")), 0, -2) . '::where(\'status\',1)->orderBy(\'name\',\'asc\')->pluck(\'name\',\'id\')';
				// set dropdown list data end

			}
			//export start
			if ($key != 0 && $is_export_field_done == 0) {
				$export_loop .= '
		$export_array[$key][\'' . $value->Field . '\']=$value->' . $value->Field . ';';


				$import_array[] = $value->Field . '=>$row[' . $import_row_counter . ']';
				$import_row_counter++;
			}

			//export end
			//for join end


			if (strtolower($value->Type) == "date") {
				$get_date_for_filter[] = $value->Field;

				$model_date_time_format_change .= '
				if (empty($instance->' . $value->Field . ')) {
		        $instance->' . $value->Field . '=NULL;
		        }else{
		        $instance->' . $value->Field . '=date("Y-m-d",strtotime($instance->' . $value->Field . '));
		        }';
			}
			if (strtolower($value->Type) == "time") {
				$get_date_for_filter[] = $value->Field;

				$model_date_time_format_change .= '
				if (empty($instance->' . $value->Field . ')) {
		        $instance->' . $value->Field . '="00:00:00";
		        }else{
		        $instance->' . $value->Field . '=date("h:i:s",strtotime($instance->' . $value->Field . '));
		        }';
			}

			if (strpos(strtolower($value->Type), 'int') !== false && $value->Null == "YES") {
				$model_date_time_format_change .= '
				if (empty($instance->' . $value->Field . ')) {
		        $instance->' . $value->Field . '=NULL;
		        }';
			}
		}



		//validation rule array maker start
		$validation_rules_str = "[\n\t\t\t\t\t\t";
		$validation_rules_count = count($validation_rules);
		foreach ($validation_rules as $validation_rules_key => $validation_rules_value) {

			$explode_data = explode("=>", trim($validation_rules_value));
			$explode_data[0] = "'" . $explode_data[0] . "'";

			if (strpos($explode_data[1], '$id') !== false) {
				$explode_data[1] = "'" . $explode_data[1] . "";
			} else {
				$explode_data[1] = "'" . $explode_data[1] . "'";
			}

			$row_comma = "";
			if (($validation_rules_key + 1) < $validation_rules_count) {
				$row_comma = ",\n\t\t\t\t\t\t";
			}

			$validation_rules_str .= implode("=>", $explode_data) . $row_comma;
		}



		$validation_rules_str .= "\n\t\t\t\t\t\t]";
		//validation rule array maker end

		// unique key start 
		$unique_key_param_edit_method = "";
		$unique_key_param_validation_method = "";
		if (isset($uniq_key_field) && count($uniq_key_field) > 0) {
			$unique_key_param_edit_method = ',$' . strtolower($model_name) . '->id';
			$unique_key_param_validation_method = ',$id=""';
		}
		// unique key end 



		//validation message array maker start
		$validation_messages_str = "[\n\t\t\t\t\t\t";
		$validation_messages_count = count($validation_messages);
		foreach ($validation_messages as $validation_messages_key => $validation_messages_value) {

			$explode_data = explode("=>", trim($validation_messages_value));
			$explode_data[0] = "'" . $explode_data[0] . "'";
			$explode_data[1] = "'" . $explode_data[1] . "'";

			$row_comma = "";
			if (($validation_messages_key + 1) < $validation_messages_count) {
				$row_comma = ",\n\t\t\t\t\t\t";
			}

			$validation_messages_str .= implode("=>", $explode_data) . $row_comma;
		}
		//validation message array maker end

		$validation_messages_str .= "\n\t\t\t\t\t\t]";




		//import array maker start

		$import_row_str = "[\n\t\t\t\t\t\t";
		$import_array_count = count($import_array);
		foreach ($import_array as $import_row_key => $import_row_value) {
			$explode_data = explode("=>", trim($import_row_value));
			$explode_data[0] = "'" . $explode_data[0] . "'";
			$explode_data[1] = $explode_data[1];

			$import_row_comma = "";
			if (($import_row_key + 1) < $import_array_count) {
				$import_row_comma = ",\n\t\t\t\t\t\t";
			}

			$import_row_str .= implode("=>", $explode_data) . $import_row_comma;
		}
		$import_row_str .= "\n\t\t\t\t\t\t]";



		$hasmany = "";
		if (!empty($hasmany_comma)) {
			$hasmany_array = explode(",", $hasmany_comma);


			foreach ($hasmany_array as $has_many_value) {

				$hasmany .= '
			public function get_' . $has_many_value . '()
		{
		    return $this->hasMany(\'App\\' . $has_many_value . '\', \'' . strtolower($has_many_value) . "_id" . '\', \'id\');
		}';
			}
		}


		$hasone = "";
		if (!empty($hasone_comma)) {
			$hasone_array = explode(",", $hasone_comma);


			foreach ($hasone_array as $has_one_value) {

				$hasone .= '
			public function get_' . $has_one_value . '()
		{
		    return $this->hasOne(\'App\\' . $has_one_value . '\', \'' . strtolower($has_one_value) . "_id" . '\', \'id\');
		}';
			}
		}


		$fillable = str_replace("\"", "'", json_encode($fillable_array));

		$model_code = '<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ' . $model_name . ' extends Model
{

	   protected $table = \'' . $table_name . '\';
	   public $primaryKey = \'' . $primary_id . '\';
	   public $timestamps = true;
	   protected $fillable = ' . $fillable . '; 
	   protected $guarded = array();

	   ' . $belong_to . '
	   ' . $hasmany . '
	   ' . $hasone . '';

		if (!empty($model_date_time_format_change)) {
			$model_code .= '
	   	public static function boot() {
	       parent::boot();

			static::creating(function ($instance){
		        self::before_save_update($instance);
			});
			static::updating(function ($instance){
		        self::before_save_update($instance);
			});
	    }

	    public static function before_save_update($instance)
	    {
	    		' . $model_date_time_format_change . '

				return $instance;
	    }	
	   ';
		}
		$model_code .= '
}';

		if (\File::exists('app/' . $model_name . '.php')) {
			\File::copy(base_path('app/' . $model_name . '.php'), base_path('public/overwrite_crud_files/' . $model_name . '_' . date('d_m_Y_h_i_s') . '.php'));
		}


		$rootPath = base_path() . "/app/";
		$model_obj = Storage::createLocalDriver(['root' => $rootPath]);
		$model_obj->put($model_name . '.php', $model_code);

		// create model end
		echo 'model created<br>';

		if ($request->only_model == 1) {
			die;
		}

		$index_listing_array[] = "status";
		$index_listing_type[] = "status";

		$index_listing_array[] = "action";
		$index_listing_type[] = "last";
		$filter_condition = "";
		$final_data = "";
		//$select_data[]="'".$table_name.".".$primary_id." as ".$primary_id."'";;


		foreach ($index_listing_array as $key_filt => $value_filt) {

			if ($index_listing_type[$key_filt] == "last" || $index_listing_type[$key_filt] == "first" || $index_listing_type[$key_filt] == "s_no") {
				continue;
			}

			if (strpos(strtolower($index_listing_type[$key_filt]), 'int') !== false) {

				$filter_condition .= 'if(!empty($request->input(\'' . $value_filt . '\'))) {
                    $condition[]=array(\'' . $value_filt . '\',\'=\',$request->input(\'' . $value_filt . '\'));
                    
                }';
			} else {

				if ($value_filt == "status") {
					$filter_condition .= 'if($request->input(\'' . $value_filt . '\')!="") {
                    $condition[]=array(\'' . $value_filt . '\',\'=\',$request->input(\'' . $value_filt . '\'));
                    
                }';
				} else if (in_array($value_filt, $get_date_for_filter)) {
					$filter_condition .= 'if($request->input(\'' . $value_filt . '\')!="") {
                    $condition[]=array(\'' . $value_filt . '\',\'=\',date(\'Y-m-d\',strtotime($request->input(\'' . $value_filt . '\'))));
                    
                }';
				} else {
					$filter_condition .= 'if(!empty($request->input(\'' . $value_filt . '\'))) {
                    $condition[]=array(\'' . $value_filt . '\',\'like\',"%{$request->input(\'' . $value_filt . '\')}%");
                    
                }';
				}
			}

			if ($value_filt == "status") {
				$select_data[] = "'" . $table_name . "." . $value_filt . " as " . $value_filt . "'";
				continue;
			}

			if (in_array($value_filt, $get_join_data_index_method)) {
				$final_data .= '
							$nest[\'' . $value_filt . '\']=!empty($row->get_' . substr($value_filt, 0, -3) . '->name)?$row->get_' . substr($value_filt, 0, -3) . '->name:"";';
			} else if (in_array($value_filt, $get_date_for_filter)) {
				$final_data .= '
							$nest[\'' . $value_filt . '\']=\AppHelper::getDateFormat($row->' . $value_filt . ');';
			} else {
				$final_data .= '
							$nest[\'' . $value_filt . '\']=$row->' . $value_filt . ';';
			}
			// $result->get_'.substr($value->Field, 0, -3).'->name
			$select_data[] = "'" . $table_name . "." . $value_filt . " as " . $value_filt . "'";
		}




		$index_listing = str_replace("\"", "'", json_encode($index_listing_array));



		// create controller start
		$controller_code = '<?php
namespace App\Http\Controllers;

use App\\' . $model_name . ';
use App\\Exports\\' . $model_name . 'Export; 
use App\Imports\\' . $model_name . 'Import;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
class ' . $controller_name . ' extends Controller
{
     public function __construct() {
        $this->middleware(\'auth\',[\'except\' => array()]);
    }

    public function index(Request $request)
    {   
        if($request->ajax()){
                $col_order=' . $index_listing . ';
                $limit=$request->input(\'length\');
                $start=$request->input(\'start\');
                
                $order=$col_order[$request->input(\'order.0.column\')];
                $dir=$request->input(\'order.0.dir\');
                $condition=array();
               
               	' . $filter_condition . '

                  $query=' . $model_name . '::query();
                  $query->select(' . implode(",", $select_data) . ');
                  $query->where($condition);
                  
                  $total_filtered=$query->count();

                  $query->offset($start);
                  $query->limit($limit);
                  $query->orderBy($order,$dir);
                  $result=$query->get();
                  $recordsTotal=' . $model_name . '::count();

                 \Session::put(\'' . strtolower($model_name) . '_export\', $condition);


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

                            $edit=\'<a href="\'.route(\'' . strtolower($model_name) . '.edit\',$row->' . $primary_id . ').\'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>\';
                            $view=\'<a href="\'.route(\'' . strtolower($model_name) . '.show\',$row->' . $primary_id . ').\'" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>\';
                            $nest[\'checkbox\']=\'<input type="checkbox" name="data[data_id][]" value="\' . $row->' . $primary_id . ' . \'"class="checkboxes"/>\';
                            $nest[\'s_no\']=($key+1)+$s_no;' . $final_data . '
							$nest[\'status\']=\'<label class="switch"><input type="checkbox" name="checkbox" value="\'.$row->' . $primary_id . '.\'" class ="on_off" \'.($row->status==1?"checked":"").\'><span class="slider round"></span></label>\';
                            $nest[\'action\']=$edit."&nbsp;".$view;
                            $data[]=$nest;
                        }
                    }
                $json=array(
                    \'draw\' => intval($request->input(\'draw\')),
                    \'recordsTotal\' => intval($recordsTotal),
                    \'recordsFiltered\' => intval($total_filtered),
                    \'data\' => $data,
                );

                return response()->json($json);
                
        }';

		$set_all_dropdown_index = array();
		foreach ($dropdown_data_set_array_index_controller as $dropdown_data_set_key => $dropdown_data_set_value) {

			$set_all_dropdown_index[] = '"' . $dropdown_data_set_key . '"' . "=>" . $dropdown_data_set_value;
		}


		$controller_code .= '
		return view(\'' . strtolower($model_name) . '.index\',[' . implode(",", $set_all_dropdown_index) . ']);

}

	 public function create()
    {
    ';
		$set_all_dropdown = array();
		foreach ($dropdown_data_set_array as $dropdown_data_set_key => $dropdown_data_set_value) {

			$set_all_dropdown[] = '"' . $dropdown_data_set_key . '"' . "=>" . $dropdown_data_set_value;
		}


		$controller_code .= 'return view(\'' . strtolower($model_name) . '.create\',[' . implode(",", $set_all_dropdown) . ']);
    }

       function form_validation($request' . $unique_key_param_validation_method . ')
    {   
        return $this->validate($request,' . $validation_rules_str . ',' . $validation_messages_str . ');
    }

    public function store(Request $request)
    {  
         $this->form_validation($request);
        if (' . $model_name . '::create($request->all())) {
            return redirect()->route(\'' . strtolower($model_name) . '.index\')->with(\'success_message\', \'Data Successfully Submitted\');   
        }else{
            return redirect()->route(\'' . strtolower($model_name) . '.add\')->with(\'error_message\', \'Opps something went wrong!\'); 
        }

    }

    public function show(' . $model_name . ' $' . strtolower($model_name) . ')
    {   
        return view(\'' . strtolower($model_name) . '.show\',[\'result\'=>$' . strtolower($model_name) . ']);
    }
    public function edit(' . $model_name . ' $' . strtolower($model_name) . ')
    {
        return view(\'' . strtolower($model_name) . '.edit\',[\'result\'=>$' . strtolower($model_name) . (count($set_all_dropdown) > 0 ? ',' : "") . implode(",", $set_all_dropdown) . ']);
    }
  
// ===========

    public function update(Request $request, ' . $model_name . ' $' . strtolower($model_name) . ')
    {
        $this->form_validation($request' . $unique_key_param_edit_method . ');
        
        if ($' . strtolower($model_name) . '->update($request->all())) {
            return redirect()->route(\'' . strtolower($model_name) . '.index\')->with(\'success_message\', \'Data Successfully Submitted\');   
        }else{
            return redirect()->route(\'' . strtolower($model_name) . '.edit\')->with(\'error_message\', \'Opps something went wrong!\'); 
        }
    }

    public function destroy(' . $model_name . ' $' . strtolower($model_name) . ')
    {
        //
    }

    function change_status(Request $request)
    {
        if($request->ajax()){
             $id = $request->status_id;
             $status = $request->status;
             if(' . $model_name . '::where(\'id\',$id)->update([\'status\'=>$status])) {
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
        
        return response()->json([\'status\'=>$status,\'message\'=>$message]);
    }

    function multiple_delete(Request $request)
    {
        
        if($request->ajax()){
             $data_id = json_decode($request->data_id);
             try {
                 if (' . $model_name . '::whereIn(\'id\',$data_id)->delete()) {
                    $status=true;
                    $message="Record successfully deleted";
                 }else{
                    $status=false;
                    $message="Opps Something went wrong";
                 }

             } catch (Exception $e) {
                 if ($e->errorInfo[0]=="23000") {
                    $status=false;
                    $message="Before delete parent you have to first delete child row";   
                 }else{
                    $status=false;
                    $message="Opps something went wrong!";   
                 }
             }
             
        
        }else{
                $status=false;
                $message="Bad Request";
        }

       
        
        return response()->json([\'status\'=>$status,\'message\'=>$message]);
    }';

		if ($request->export == 1) {
			$controller_code .= 'public function exportExcel()
      {
        return Excel::download(new ' . $model_name . 'Export, \'' . strtolower($model_name) . "_'.date('dmYHis').'" . '.xlsx\');
      }

      public function exportCSV()
      {
        return Excel::download(new ' . $model_name . 'Export, \'' . strtolower($model_name) . "_'.date('dmYHis').'" . '.csv\');
      }';
		}


		if ($request->import == 1) {
			$controller_code .= '
	public function import() 
    {   
        if (Excel::import(new ' . $model_name . 'Import,request()->file(\'import\'))) {
        return back()->with(\'success_message\', \'Data Successfully Imported\');    
        }else{
        return back()->with(\'error_message\', \'Opps something went wrong\');
        }
        
    }';
		}

		$controller_code .= '
}';
		if (\File::exists('app/Http/Controllers/' . $controller_name . '.php')) {
			\File::copy(base_path('app/Http/Controllers/' . $controller_name . '.php'), base_path('public/overwrite_crud_files/' . $controller_name . '_' . date('d_m_Y_h_i_s') . '.php'));
		}

		$rootPathController = base_path() . "/app/Http/Controllers";
		$controller_obj = Storage::createLocalDriver(['root' => $rootPathController]);
		$controller_obj->put($controller_name . '.php', $controller_code);
		echo 'controller created<br>';
		// create controller end



		// create export start


		$export_heading1_json = str_replace("\"", "'", json_encode($export_heading1));
		$export_heading2_json = str_replace("\"", "'", json_encode($export_heading2));
		$export_heading3_json = str_replace("\"", "'", json_encode($export_heading3));


		$export_code = '<?php
namespace App\Exports;
use App\\' . $model_name . ';
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;

class ' . $model_name . 'Export implements FromCollection, WithHeadings,WithEvents,WithTitle,ShouldAutoSize
{

    
  public function collection()
  {

    $condition=\Session::get(\'' . strtolower($model_name) . '_export\');
    
    $' . strtolower($model_name) . ' = ' . $model_name . '::select(' . str_replace(array('[', ']', '"'), array("", "", ""), json_encode($fillable)) . ')->where($condition)->get();
    
    $export_array=array();
   
    foreach ($' . strtolower($model_name) . ' as $key => $value) {
        
        ' . $export_loop . '
    }
    return collect($export_array);
  }

  public function headings(): array
    {
        return [
            ' . $export_heading1_json . ',
            ' . $export_heading2_json . ',
            ' . $export_heading3_json . ',
        ];
    }

public function title(): string
    {
        return \'' . $model_name . ' Export\';
    }

    public function registerEvents(): array
    {

    	
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = \'A1:W1\'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },

        ];
    }
}';



		if ($request->export == 1) {
			if (\File::exists('app/Exports/' . $model_name . 'Export.php')) {
				\File::copy(base_path('app/Exports/' . $model_name . 'Export.php'), base_path('public/overwrite_crud_files/' . $model_name . 'Export_' . date('d_m_Y_h_i_s') . '.php'));
			}
			$rootPathExport = base_path() . "/app/Exports/";
			$export_obj = Storage::createLocalDriver(['root' => $rootPathExport]);
			$export_obj->put($model_name . 'Export.php', $export_code);
			echo 'export created<br>';
		}
		// create export end


		//create import start

		$import_code = '<?php
  
namespace App\Imports;
  
use App\\' . $model_name . ';
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class ' . $model_name . 'Import implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new ' . $model_name . '(' . $import_row_str . ');
    }

     public function startRow(): int
    {
        return 3;
    }
}';


		if ($request->import == 1) {
			if (\File::exists('app/Imports/' . $model_name . 'Import.php')) {
				\File::copy(base_path('app/Imports/' . $model_name . 'Import.php'), base_path('public/overwrite_crud_files/' . $model_name . 'Import_' . date('d_m_Y_h_i_s') . '.php'));
			}
			$rootPathImport = base_path() . "/app/Imports/";
			$import_obj = Storage::createLocalDriver(['root' => $rootPathImport]);
			$import_obj->put($model_name . 'Import.php', $import_code);
			echo 'import created<br>';
		}

		//create import end


		//  create view start
		$dir_path = "/resources/views/" . strtolower($model_name);
		if (!\File::isDirectory(base_path($dir_path))) {
			\File::makeDirectory(base_path($dir_path), $mode = 0777, $recursive = true, $force = false);
		}

		//create.blade.php start
		$create_view = '@extends(\'layouts.admin_main\')

@section(\'content\')

<section class="content-header">
  <h1>
    ' . $label_name . '
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route(\'admin.dashboard\') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route(\'' . strtolower($model_name) . '.index\') }}">' . $label_name . '</a></li>
    <li class="active">Add</li>
  </ol>
</section>
  

<section class="content">
  @include(\'flash_messages.admin_message\')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open([\'method\'=>\'POST\',\'route\'=>[\'' . strtolower($model_name) . '.store\'],\'files\'=>true,\'role\'=>\'form\',\'class\'=>\'form-data\']) !!} 
      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> <span>' . $label_name . ' Add</span> </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">';

		$create_form_data = "";
		$image_element = "";
		$clrscr = 0;
		$is_date = 0;
		$is_time = 0;
		$is_ckeditor = 0;
		foreach (DB::select('describe ' . $table_name) as $key => $value) {
			if ($value->Field == "created_at" || $value->Field == "updated_at" || $key == 0) {
				continue;
			}
			$asterisk_sign = "";
			if ($value->Null == "NO") {
				$asterisk_sign = '<span class="text-danger">*</span>';
			}

			if ($value->Field == "status") {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'status\') }}</small>';
				}

				$create_form_data .= '
			<div class="col-md-6">
              <div class="form-group">
                <label>Status ' . $asterisk_sign . '</label>

              {{Form::select(\'status\', \AppHelper::getStatus(), \'1\', [\'class\' => \'form-control select2\',\'style\'=>\'width: 100%\',\'placeholder\'=>\'Please Select\'])}}
              ' . $error_message . '
              </div>
            
            </div>';
			} else if (strpos(strtolower($value->Field), 'phone') !== false || strpos(strtolower($value->Field), 'mobile') !== false || strpos(strtolower($value->Field), 'contact') !== false || $value->Field == "sort_order") {

				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                  {!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control only_numbers\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
                  ' . $error_message . '
                </div>
            </div>';
			} else if ($value->Key == "MUL") {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$create_form_data .= '
				<div class="col-md-6">
	              <div class="form-group">
	                <label>' . ucfirst(str_replace('_', ' ', substr($value->Field, 0, -3))) . " " . $asterisk_sign . '</label>

	              {{Form::select(\'' . $value->Field . '\',$' . substr($value->Field, 0, -3) . '_select_list, \'\', [\'class\' => \'form-control select2\',\'style\'=>\'width: 100%\',\'placeholder\'=>\'Please Select\'])}}
	             ' . $error_message . '
	              </div>
	            
	            </div>';
			} else if (strpos(strtolower($value->Type), 'longtext') !== false || strpos(strtolower($value->Type), 'text') !== false) {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$is_ckeditor++;
				$create_form_data .= '
				<div class="col-md-12">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                  {!! Form::textarea(\'' . $value->Field . '\',null,[\'class\'=>\'form-control\',\'id\'=>\'ckeditor' . $is_ckeditor . '\',\'rows\'=>\'10\',\'cols\'=>\'80\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
	                  ' . $error_message . '
	                </div>
	            </div>';
			}/*else if(strpos(strtolower($value->Type), 'text') !== false){
					$error_message="";
					if ($value->Null=="NO") {
					$error_message='<small class="text-danger">{{ $errors->first(\''.$value->Field.'\') }}</small>';
					}
					$create_form_data.='
				<div class="col-md-6">
                <div class="form-group">
                  <label>'.$this->string_yns($value->Field)." ".$asterisk_sign.' </label>
                  {!! Form::textarea(\''.$value->Field.'\',null,[\'class\'=>\'form-control\',\'rows\'=>\'3\',\'placeholder\'=>\''.$this->string_yns($value->Field).'\'])!!}
	                  '.$error_message.'
	                </div>
	            </div>';
				}*/ else if (strpos($value->Type, '(211)') !== false) {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$create_form_data .= '
			<div class="col-md-6 mb_30">
              <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . '</label>
              <table class="table image-table">
                <tr>
                  <td style="vertical-align: middle;text-align: left;"><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage(old(\'' . $value->Field . '\')) }}" alt=" profile picture">
                  <div class="clearfix"></div>
                  <small class="text-danger file_error"></small>
                  <div class="clearfix"></div>
                  <div class="progress" style="display: none;">
                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    </div>
                  </div>
                  </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                <span class="btn btn-primary btn-file">
                Choose File <input name="_' . $value->Field . '" type="file" class="inputFileUpload" save_folder="' . strtolower($model_name) . '" input_file_key="_' . $value->Field . '" crop_compress="compress" compress_size="800" crop_size="800X800" />  
                </span>
                 </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                     
                  <button type="button" class="btn btn-danger remove_image" 
                   <?php 
                  if(empty(old(\'' . $value->Field . '\'))){
                   echo \'style="display: none;"\';
                  }
                  ?>
                  >Remove</button>

                  {!! Form::hidden(\'' . $value->Field . '\',"",[\'class\'=>\'hidden_filename\'])!!}
                </td>
                  
                </tr>
              </table>
              ' . $error_message . '

      </div>';

				$image_element = '@include(\'admin_elements.upload_elements.single_image_crop_compress\')';
			} else if (strtolower($value->Type) == "date") {
				$is_date = 1;

				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
				<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  {!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control  pull-right datepicker\',\'readonly\'=>true,\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
                  </div>
	                  ' . $error_message . '
	                </div>
	            </div>';
			} else if (strtolower($value->Type) == "time") {
				$is_time = 1;
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
				<div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                   <div class="input-group">
                  {!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control timepicker\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
                  <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
	                  ' . $error_message . '
	                </div>
	                </div>
	            </div>';
			} else {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                  {!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
	                  ' . $error_message . '
	                </div>
	            </div>';
			}

			$create_form_data .= "\n";
			$create_form_data .= "\n";
			$clrscr++;
			if ($clrscr > 1) {
				$create_form_data .= "\t\t\t\t" . '<div class="clearfix"></div>';
				$clrscr = 0;
			}
		}


		$create_view .= $create_form_data;
		$create_view .= '</div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->';

		if ($is_date == 1) {
			$create_view .= "\n@include('admin_elements.input_elements.datepicker')\n";
		}
		if ($is_time == 1) {
			$create_view .= "\n@include('admin_elements.input_elements.timepicker')\n";
		}
		if ($is_ckeditor > 0) {
			$create_view .= "\n@include('admin_elements.input_elements.ckeditor')\n";
		}

		$create_view .= $image_element . "\n@endsection";




		if (\File::exists('resources/views/' . $model_name . '/create.blade.php')) {
			\File::copy(base_path('resources/views/' . $model_name . '/create.blade.php'), base_path('public/overwrite_crud_files/' . $model_name . 'create_blade_' . date('d_m_Y_h_i_s') . '.php'));
		}

		$rootPathcreate = base_path() . "/resources/views/" . strtolower($model_name) . "/";
		$creatr_obj = Storage::createLocalDriver(['root' => $rootPathcreate]);
		$creatr_obj->put('create.blade.php', $create_view);
		echo 'create.blade.php view file created<br>';

		//create.blade.php end

		//edit.blade.php start
		$edit_view = '@extends(\'layouts.admin_main\')

@section(\'content\')

<section class="content-header">
  <h1>
    ' . $label_name . '
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route(\'admin.dashboard\') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route(\'' . strtolower($model_name) . '.index\') }}">' . $label_name . '</a></li>
    <li class="active">Edit</li>
  </ol>
</section>
  

<section class="content">
  @include(\'flash_messages.admin_message\')
    <!-- SELECT2 EXAMPLE -->
    {!! Form::open([\'method\'=>\'PUT\',\'route\'=>[\'' . strtolower($model_name) . '.update\',$result->id],\'role\'=>\'form\',\'class\'=>\'form-data\',\'files\'=>true]) !!} 
      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> ' . $label_name . ' Edit </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">';

		$create_form_data = "";
		$image_element = "";
		$clrscr = 0;
		$is_date = 0;
		$is_time = 0;
		$is_ckeditor = 0;
		foreach (DB::select('describe ' . $table_name) as $key => $value) {
			if ($value->Field == "created_at" || $value->Field == "updated_at" || $key == 0) {
				continue;
			}
			$asterisk_sign = "";
			if ($value->Null == "NO") {
				$asterisk_sign = '<span class="text-danger">*</span>';
			}

			if ($value->Field == "status") {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'status\') }}</small>';
				}
				$create_form_data .= '
			<div class="col-md-6">
              <div class="form-group">
                <label>Status ' . $asterisk_sign . '</label>

              {{Form::select(\'status\', \AppHelper::getStatus(),$result->' . $value->Field . ', [\'class\' => \'form-control select2\',\'style\'=>\'width: 100%\',\'placeholder\'=>\'Please Select\'])}}
              ' . $error_message . '
              </div>
            
            </div>';
			} else if (strpos(strtolower($value->Field), 'phone') !== false || strpos(strtolower($value->Field), 'mobile') !== false || strpos(strtolower($value->Field), 'contact') !== false || $value->Field == "sort_order") {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                  {!! Form::text(\'' . $value->Field . '\',$result->' . $value->Field . ',[\'class\'=>\'form-control only_numbers\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
                  ' . $error_message . '
                </div>
            </div>';
			} else if ($value->Key == "MUL") {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$create_form_data .= '
				<div class="col-md-6">
	              <div class="form-group">
	                <label>' . ucfirst(str_replace('_', ' ', substr($value->Field, 0, -3))) . " " . $asterisk_sign . '</label>

	              {{Form::select(\'' . $value->Field . '\',$' . substr($value->Field, 0, -3) . '_select_list,$result->' . $value->Field . ', [\'class\' => \'form-control select2\',\'style\'=>\'width: 100%\',\'placeholder\'=>\'Please Select\'])}}
	              ' . $error_message . '
	              </div>
	            
	            </div>';
			} else if (strpos(strtolower($value->Type), 'longtext') !== false || strpos(strtolower($value->Type), 'text') !== false) {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$is_ckeditor++;
				$create_form_data .= '
				<div class="col-md-12">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                  {!! Form::textarea(\'' . $value->Field . '\',$result->' . $value->Field . ',[\'class\'=>\'form-control\',\'rows\'=>\'3\',\'id\'=>\'ckeditor' . $is_ckeditor . '\',\'rows\'=>\'10\',\'cols\'=>\'80\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
	                  ' . $error_message . '
	                </div>
	            </div>';
			}/*else if(strpos(strtolower($value->Type), 'text') !== false){
					$error_message="";
					if ($value->Null=="NO") {
					$error_message='<small class="text-danger">{{ $errors->first(\''.$value->Field.'\') }}</small>';
					}
					$create_form_data.='
				<div class="col-md-6">
                <div class="form-group">
                  <label>'.$this->string_yns($value->Field)." ".$asterisk_sign.' </label>
                  {!! Form::textarea(\''.$value->Field.'\',$result->'.$value->Field.',[\'class\'=>\'form-control\',\'rows\'=>\'3\',\'placeholder\'=>\''.$this->string_yns($value->Field).'\'])!!}
	                  '.$error_message.'
	                </div>
	            </div>';
				}*/ else if (strpos($value->Type, '(211)') !== false) {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$create_form_data .= '
			<div class="col-md-6 mb_30">
              <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . '</label>
              <table class="table image-table">
                <tr>
                  <td style="vertical-align: middle;text-align: left;"><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage($result->' . $value->Field . ') }}" alt=" profile picture">
                  <div class="clearfix"></div>
                  <small class="text-danger file_error"></small>
                  <div class="clearfix"></div>
                  <div class="progress" style="display: none;">
                    <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    </div>
                  </div>
                  </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                <span class="btn btn-primary btn-file">
                Choose File <input name="_' . $value->Field . '" type="file" class="inputFileUpload" save_folder="' . strtolower($model_name) . '" input_file_key="_' . $value->Field . '" crop_compress="compress" compress_size="800" crop_size="800X800"/>  
                </span>
                 </td>
                  <td  style="vertical-align: middle;text-align: left;"> 
                     
                  <button type="button" class="btn btn-danger remove_image" 
                  
                  <?php 
                  if(empty($result->' . $value->Field . ')){
                   echo \'style="display: none;"\';
                  }
                  ?>
                  >Remove</button>

                  {!! Form::hidden(\'' . $value->Field . '\',!empty($result->' . $value->Field . ')?$result->' . $value->Field . ':"",[\'class\'=>\'hidden_filename\'])!!}
                </td>
                  
                </tr>
              </table>
              ' . $error_message . '

      </div>';

				$image_element = '@include(\'admin_elements.upload_elements.single_image_crop_compress\')';
			} else if (strtolower($value->Type) == "date") {
				$is_date = 1;

				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
				<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  {!! Form::text(\'' . $value->Field . '\',\AppHelper::getDateFormat($result->' . $value->Field . '),[\'class\'=>\'form-control  pull-right datepicker\',\'readonly\'=>true,\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
                  </div>
	                  ' . $error_message . '
	                </div>
	            </div>';
			} else if (strtolower($value->Type) == "time") {
				$is_time = 1;
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}

				$create_form_data .= '
				<div class="col-md-6">
				<div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                   <div class="input-group">
                  {!! Form::text(\'' . $value->Field . '\',\AppHelper::getTimeFormat($result->' . $value->Field . '),[\'class\'=>\'form-control timepicker\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
                  <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
	                  ' . $error_message . '
	                </div>
	                </div>
	            </div>';
			} else {
				$error_message = "";
				if ($value->Null == "NO") {
					$error_message = '<small class="text-danger">{{ $errors->first(\'' . $value->Field . '\') }}</small>';
				}
				$create_form_data .= '
				<div class="col-md-6">
                <div class="form-group">
                  <label>' . $this->string_yns($value->Field) . " " . $asterisk_sign . ' </label>
                  {!! Form::text(\'' . $value->Field . '\',$result->' . $value->Field . ',[\'class\'=>\'form-control\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}
	                  ' . $error_message . '
	                </div>
	            </div>';
			}

			$create_form_data .= "\n";
			$clrscr++;
			if ($clrscr > 1) {
				$create_form_data .= "\t\t\t\t" . '<div class="clearfix"></div>';
				$clrscr = 0;
			}
		}

		$edit_view .= $create_form_data;
		$edit_view .= '</div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route(\'' . strtolower($model_name) . '.index\') }}" class="btn btn-default">Back</a>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->';

		if ($is_date == 1) {
			$edit_view .= "\n@include('admin_elements.input_elements.datepicker')\n";
		}
		if ($is_time == 1) {
			$edit_view .= "\n@include('admin_elements.input_elements.timepicker')\n";
		}

		if ($is_ckeditor > 0) {
			$edit_view .= "\n@include('admin_elements.input_elements.ckeditor')\n";
		}

		$edit_view .= $image_element . "\n@endsection";





		if (\File::exists('resources/views/' . $model_name . '/edit.blade.php')) {
			\File::copy(base_path('resources/views/' . $model_name . '/edit.blade.php'), base_path('public/overwrite_crud_files/' . $model_name . 'edit_blade_' . date('d_m_Y_h_i_s') . '.php'));
		}

		$rootPathedit = base_path() . "/resources/views/" . strtolower($model_name) . "/";
		$creatr_obj = Storage::createLocalDriver(['root' => $rootPathedit]);
		$creatr_obj->put('edit.blade.php', $edit_view);
		echo 'edit.blade.php view file created<br>';
		//edit.blade.php end

		//show.blade.php start

		$show_view = '@extends(\'layouts.admin_main\')

@section(\'content\')

<section class="content-header">
  <h1>
    ' . $label_name . '
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route(\'admin.dashboard\') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route(\'' . strtolower($model_name) . '.index\') }}">' . $label_name . '</a></li>
    <li class="active">View</li>
  </ol>
</section>
  

<section class="content">
<!-- SELECT2 EXAMPLE -->
   <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> ' . $label_name . ' View </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="w0" class="table table-striped table-bordered detail-view">
            <tbody>';

		foreach (DB::select('describe ' . $table_name) as $key => $value) {
			/*if ($key == 0) {
					continue;
				}*/

			if ($value->Field == "status") {
				$show_view .= '
	            <tr>
	              <th>' . $this->string_yns($value->Field) . '</th>
	              <td>{{($result->' . $value->Field . '==1?"Active":"Inactive")}}</td>
	            </tr>';
			} else if (strpos($value->Type, '211') !== false) {
				$show_view .= '
				<?php if(!empty($result->' . $value->Field . ')){ ?>
	            <tr>
	              <th>' . $this->string_yns($value->Field) . '</th>
	              <td><img class="profile-user-img watter_image" src="{{ \AppHelper::getImage($result->' . $value->Field . ') }}" alt=" profile picture"></td>
	            </tr>
	        	<?php } ?>';
			} else if ($value->Key == "MUL") {
				$show_view .= '
	            <tr>
	              <th>' . $this->string_yns(substr($value->Field, 0, -3)) . '</th>
	              <td>{{!empty($result->get_' . substr($value->Field, 0, -3) . '->name)?$result->get_' . substr($value->Field, 0, -3) . '->name:""}}</td>
	            </tr>';
			} else if (strtolower($value->Type) == "time") {
				$show_view .= '
	            <tr>
	              <th>' . $this->string_yns($value->Field) . '</th>
	              <td>{{\AppHelper::getTimeFormat($result->' . $value->Field . ')}}</td>
	            </tr>';
			} else if (strtolower($value->Type) == "datetime" || strtolower($value->Type) == "timestamp") {
				$show_view .= '
	            <tr>
	              <th>' . $this->string_yns($value->Field) . '</th>
	              <td>{{\AppHelper::getDateTimeFormat($result->' . $value->Field . ')}}</td>
	            </tr>';
			} else if (strtolower($value->Type) == "date") {
				$show_view .= '
	            <tr>
	              <th>' . $this->string_yns($value->Field) . '</th>
	              <td>{{\AppHelper::getDateFormat($result->' . $value->Field . ')}}</td>
	            </tr>';
			} else {
				$show_view .= '
	            <tr>
	              <th>' . $this->string_yns($value->Field) . '</th>
	              <td>{{$result->' . $value->Field . '}}</td>
	            </tr>';
			}
		}
		$show_view .=
			'</tbody>
           </table>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <a href="{{ route(\'' . strtolower($model_name) . '.index\')}}" class="btn btn-default">Back</a>
        </div>

        
      </div>

     
      <!-- /.box -->
      
</section>
    <!-- /.content -->

@endsection';


		if (\File::exists('resources/views/' . $model_name . '/show.blade.php')) {
			\File::copy(base_path('resources/views/' . $model_name . '/show.blade.php'), base_path('public/overwrite_crud_files/' . $model_name . 'show_blade_' . date('d_m_Y_h_i_s') . '.php'));
		}

		$rootPathshow = base_path() . "/resources/views/" . strtolower($model_name) . "/";
		$creatr_obj = Storage::createLocalDriver(['root' => $rootPathshow]);
		$creatr_obj->put('show.blade.php', $show_view);
		echo 'show.blade.php view file created<br>';


		//show.blade.php end


		//index.blade.php start
		$index_view = '@extends(\'layouts.admin_main\')

@section(\'content\')

<section class="content-header">
  <h1>
    ' . $label_name . '
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route(\'admin.dashboard\') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">' . $label_name . '</li>
  </ol>
</section>

<section class="content">

  <div class="flash_messages">
    @include(\'flash_messages.admin_message\')  
  </div>';
		$filter_data = "";
		$is_date = 0;
		$index_listing_array_view = array();
		$join_table_array = array();
		$number_val_array = array();
		$call_controller_for_filter = array();
		foreach (DB::select('describe ' . $table_name) as $key => $value) {
			if ($value->Field == "created_at" || $value->Field == "updated_at") {
				continue;
			}


			if (count($index_listing_array_view) <= 4) { //4 because of checkbox and id

				if ($value->Field == "status") {
				} else if ($value->Type == "time") {
				} else if (strpos($value->Type, '211') !== false) {
				} else {

					$index_listing_array_view[] = $value;
				}

				if (strpos(strtolower($value->Field), 'phone') !== false || strpos(strtolower($value->Field), 'mobile') !== false || strpos(strtolower($value->Field), 'contact') !== false || $value->Field == "sort_order") {

					$call_controller_for_filter[] = 'yns.' . $value->Field . ' = $(\'.' . $value->Field . '\').val()';



					$number_val_array[] = $value->Field;
					$filter_data .= '
				<th>{!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control only_numbers ' . $value->Field . ' filter-input\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}</th>';
				} else if ($value->Key == "MUL") {

					$call_controller_for_filter[] = 'yns.' . $value->Field . ' = $(\'.' . $value->Field . '\').val()';

					$join_table_array[] = $value->Field;
					$filter_data .= '
				<th>{{Form::select(\'' . $value->Field . '\',$' . substr($value->Field, 0, -3) . '_select_list, \'\', [\'class\' => \'form-control select2 ' . $value->Field . ' filter-select\',\'style\'=>\'width: 100%\',\'placeholder\'=>\'Please Select\'])}}</th>';
				} else if (strpos(strtolower($value->Type), 'text') !== false) {
					$call_controller_for_filter[] = 'yns.' . $value->Field . ' = $(\'.' . $value->Field . '\').val()';
					if ($value->Field=="id") {
						$filter_data .= '
				<th>{!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control input-w-100 ' . $value->Field . ' filter-input\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}</th>';
					}else{
						$filter_data .= '
				<th>{!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control ' . $value->Field . ' filter-input\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}</th>';
						
					}
					

				} else if (strpos(strtolower($value->Type), '211') !== false) {
					$filter_data .= '';
				} else if (strtolower($value->Type) == "date") {
					$call_controller_for_filter[] = 'yns.' . $value->Field . ' = $(\'.' . $value->Field . '\').val()';
					$number_val_array[] = $value->Field;
					$is_date = 1;
					$filter_data .= '
				<th>{!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control  pull-right datepicker ' . $value->Field . ' filter-date\',\'readonly\'=>true,\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}</th>';
				} else if (strtolower($value->Type) == "time") {
					$filter_data .= '';
				} else if ($value->Field != "status") {
					$call_controller_for_filter[] = 'yns.' . $value->Field . ' = $(\'.' . $value->Field . '\').val()';

					$filter_data .= '
				<th>{!! Form::text(\'' . $value->Field . '\',null,[\'class\'=>\'form-control ' . $value->Field . ' filter-input\',\'placeholder\'=>\'' . $this->string_yns($value->Field) . '\'])!!}</th>';
				}
			}
		}




		$call_controller_for_filter[] = 'yns.status = $(\'.status\').val()';

		$filter_data .= '
				<th>{{Form::select(\'status\', \AppHelper::getStatus(), \'\', [\'class\' => \'form-control select2 filter-select status\',\'style\'=>\'width: 100%\',\'placeholder\'=>\'Please Select\'])}}</th>';

		$index_view .= '
    <div class="row">
      <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">' . $label_name . ' List</h3>

        <div class="box-tools pull-right index_btn">
           <a href="{{ route(\'' . strtolower($model_name) . '.create\') }}" class="btn btn-primary"><i class="fa fa-plus"></i> <span>Add</span></a>
           <button type="button" class="btn btn-danger delete_records"><i class="fa fa-fw fa-trash"></i> <span>Delete</span></button>';

		if ($request->import == 1) {
			$index_view .= '
           	<button type="button" class="btn btn-default ml_5" data-toggle="modal" data-target="#modal-default"><i class="fa fa-fw fa-file-excel-o"></i> <span>Import</span></button>';
		}

		if ($request->export == 1) {
			$index_view .= '
           	<div class="btn-group ml_5 export_btn">
           <button type="button" class="btn btn-success exp_btn"><i class="fa fa-fw fa-cloud-download"></i> <span>Export</span></button>
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu btn-success" role="menu">
                    <li><a href="{{route(\'' . strtolower($model_name) . '.export_excel\')}}">Export To Excel <i class="fa fa-fw fa-file-excel-o"></i></a></li>
                    <li><a href="{{route(\'' . strtolower($model_name) . '.export_csv\')}}">Export To CSV <i class="fa fa-fw fa-file-excel-o"></i></a></li>
                  </ul>
                </div>';
		}



		$index_view .= '
        </div>
             

            </div>
            <!-- /.box-header -->
            <div class="box-body table_mob_box">
              <div class="box-body table-responsive no-padding">
              <table id="' . $model_name . '" class="table table-bordered  table-striped" style="width: 100%;">
                 <thead>
                 <tr>
                  <th><input type="checkbox" name="check_all" class="check_all"/></th>
                  <th>Sr No</th>';
		$th = "";
		foreach ($index_listing_array_view as $value) {
			if ($value->Key == "MUL") {
				$th .= "
                  		<th>" . substr(str_replace("_", '', ucwords($value->Field, "_")), 0, -2) . "</th>";
			} else {
				$th .= "
                  		<th>" . $this->string_yns($value->Field) . "</th>";
			}
		}
		$index_view .= $th;
		$index_view .= '
                  <th>Status</th>
                  <th>Action</th>
                </tr>
				<tr>
				<th></th>
				<th></th>
                ' . $filter_data . '
                <th class="text-center"> <button type="submit" class="btn btn-default reset_filter">Reset</button></th>
                </tr>	
                 </thead>
               <tbody>
               </tbody>
                
              </table>
        

            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
      
@include(\'admin_elements.datatable.configuration\')
<script>
var table_id=$(\'#' . $model_name . '\');
var delete_url="{{ route(\'' . strtolower($model_name) . '.multiple_delete\') }}";
var status_url="{{ route(\'' . strtolower($model_name) . '.change_status\') }}";
var table="";
$(document).ready(function(){
  //================= DATA TABLE START =================//
   table = table_id.DataTable({
				responsive: true,
				orderCellsTop: true,
        ajax :{
            url:"{{ route(\'' . strtolower($model_name) . '.index\') }}",
            data: function (yns) {';
		$index_view .= implode(",", $call_controller_for_filter);

		$index_view .= '
            },
            dataType: \'json\',
            type: \'GET\',
          },
          columns :[';
		$center_order_false = array();
		$center_order_true = array();
		$left_order_true = array();
		$columns_data = "\n";


		foreach ($index_listing_array as $key => $value) {
			if ($key == 0 || $key == 1 || $value == "action") {
				$columns_data .= "\t\t\t\t\t\t{data : '" . $value . "',orderable:false,className:'text-center','createdCell':  function (td, cellData, rowData, row, col) {
                        $(td).attr('data-title', '".$this->string_yns($value)."'); 
                        }},\n";
				$center_order_false[] = $key;
			} else if ($value == "status" || in_array($value, $number_val_array)) {
				$columns_data .= "\t\t\t\t\t\t{data : '" . $value . "',orderable:true,className:'text-center','createdCell':  function (td, cellData, rowData, row, col) {
					$(td).attr('data-title', '".$this->string_yns($value)."'); 
					}},\n";
				$center_order_true[] = $key;
			} else {
				$columns_data .= "\t\t\t\t\t\t{data : '" . $value . "',orderable:true,className:'text-left','createdCell':  function (td, cellData, rowData, row, col) {
					$(td).attr('data-title', '".$this->string_yns($value)."'); 
					}},\n";
				$left_order_true[] = $key;
			}
		}
		$index_view .= $columns_data;
		$index_view .= '
          ],
          ';


		$index_view .= '"order": [[2, \'desc\']],

        processing : DATATABLE_PROCESSING,
        responsive: DATATABLE_RESPONSIVE,
        serverSide :DATATABLE_SERVERSIDE,
        searching: DATATABLE_SEARCHING,
        bStateSave: DATATABLE_BSTATESAVE, // save datatable state(pagination, sort, etc) in cookie.
        language: DATATABLE_LANGUAGE,
        dom:DATATABLE_DOM,
        //l - length changing input control ,f - filtering input,t - The table!,i - Table information summary ,p - pagination control,r - processing display element
        lengthMenu: DATATABLE_LENGTHMENU,
        pageLength: DATATABLE_PAGELENGTH, // default record count per page                  
    });
  //================= DATA TABLE END =================//
});
</script>';



		if ($request->import == 1) {
			$index_view .= '
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
<div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Import ' . $label_name . '</h4>
          </div>
         
         {!! Form::open([\'method\'=>\'POST\',\'route\'=>[\'' . strtolower($model_name) . '.import\'],\'role\'=>\'form\',\'files\'=>true,\'class\'=>\'import_form\']) !!} 
          <div class="modal-body">
            <table class="table image-table">
                
                <tr>
                  
                <td  style="vertical-align: middle;text-align: left;"> 
                <span style="width: 100%;height: 100%;" class="btn btn-primary btn-file">
                Choose File <input name="import" type="file" class="import_input" />  
                </span>
                 </td>
                                    
                </tr>


                <tr>
                  
                <td  style="vertical-align: middle;text-align: left;"> 
               <a style="width: 100%;height: 100%;"  href="{{ asset(\'public/import_sample_sheets/' . strtolower($model_name) . '.xlsx\') }}" class="btn btn-primary pull-left">Download Sample</a>
                 </td>
                                    
                </tr>
              </table>
          </div>
        {!! Form::close() !!}
          <div class="modal-footer">
            
            
            
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
           
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

<script type="text/javascript">
  $(".import_input").change(function(){
     $(".import_form").submit();
  });

</script>';
		}


		if ($is_date == 1) {
			$index_view .= "\n@include('admin_elements.input_elements.datepicker')\n@endsection";
		} else {
			$index_view .= "@endsection";
		}


		if (\File::exists('resources/views/' . $model_name . '/index.blade.php')) {
			\File::copy(base_path('resources/views/' . $model_name . '/index.blade.php'), base_path('public/overwrite_crud_files/' . $model_name . 'show_blade_' . date('d_m_Y_h_i_s') . '.php'));
		}

		$rootPathshow = base_path() . "/resources/views/" . strtolower($model_name) . "/";
		$creatr_obj = Storage::createLocalDriver(['root' => $rootPathshow]);
		$creatr_obj->put('index.blade.php', $index_view);
		echo 'index.blade.php view file created<br>';




		//index.blade.php end




		//  create view end




		// route file past in web start

		echo "
<br><br><br>====================================<br>
Route::resource('" . strtolower($model_name) . "', " . $model_name . "Controller::class);
<br>Route::get('" . strtolower($model_name) . "_delete', [" . $model_name . "Controller::class,'multiple_delete'])->name('" . strtolower($model_name) . ".multiple_delete');
<br>Route::get('" . strtolower($model_name) . "_change_status', [" . $model_name . "Controller::class,'change_status'])->name('" . strtolower($model_name) . ".change_status');
<br>Route::get('" . strtolower($model_name) . "_exportExcel',[" . $model_name . "Controller::class,'exportExcel'])->name('" . strtolower($model_name) . ".export_excel');
<br>Route::get('" . strtolower($model_name) . "_exportCSV',[" . $model_name . "Controller::class,'exportCSV'])->name('" . strtolower($model_name) . ".export_csv');
<br>Route::post('" . strtolower($model_name) . "_import',[" . $model_name . "Controller::class,'import'])->name('" . strtolower($model_name) . ".import');
<br><br>====================================";

		die;
		// route file past in web end


		die;
	}

	function string_yns($str = '')
	{

		$replace = str_replace("_", " ", $str);
		$str_lower = strtolower($replace);
		return ucwords($str_lower);
	}
}
