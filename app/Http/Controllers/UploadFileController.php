<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Image;
use Intervention\Image\Exception\NotReadableException;

class UploadFileController extends Controller
{
	public function remove_single_image(Request $request)
	{
		if ($request->ajax()) {


			$status = true;
			$message = "File successfully removed!";
			$filename = "";
			$display_filename = url('public') . "/" . config('constants.default_image');

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename);
			return response()->json($result_array);
		}
	}
	public function single_image(Request $request)
	{
		if ($request->ajax()) {
			$flag = 0;
			$input_file_key = $request->get('input_file_key'); // file input key name 
			$validator_type = Validator::make($request->all(), [
				$input_file_key => 'mimes:jpeg,jpg,png,ico,svg',
			]);

			if ($validator_type->fails()) {
				$message = 'uploaded file type is not valid';
				$flag = 1;
			}
			$validator_size = Validator::make($request->all(), [
				$input_file_key => 'max:20000',
				//The value is in kilobytes. I.e. max:10240 = max 10 MB.
			]);


			if ($validator_size->fails()) {
				$message = 'maximum uploading size is 20 MB';
				$flag = 1;
			}

			if ($flag == 0) {
				$folder_name = str_replace("/", "slash", $request->get('save_folder'));
				$status = true;
				$message = "File successfully uploaded!";

				// start ratio size
				/*$files=$request->file($input_file_key);
                    $ImageUpload = Image::make($files);
                    $ImageUpload->resize(21,21);
                    $filename=uniqid() . '.' . $files->getClientOriginalExtension();
                    $ImageUpload->save(storage_path($folder_name."/".$filename));
                    $display_filename = Storage::disk('public')->url($folder_name."/".$filename);*/
				// end ratio size

				//start image 400kb to 200kb
				/*$files=$request->file($input_file_key);
                    $filename=uniqid() . '.' . $files->getClientOriginalExtension();
                   
                    $ImageUpload=Image::make($files)->resize(120, null, function ($constraint) {$constraint->aspectRatio();});
                    $ImageUpload->save(storage_path($folder_name."/".$filename));
                    $display_filename = Storage::disk('public')->url($folder_name."/".$filename);*/
				//end image 400kb to 200kb

				$filename = $request->file($input_file_key)->store($folder_name);

				$display_filename = Storage::disk('public')->url($filename);
			} else {
				$status = false;
				$message = $message;
				$filename = "";
				$display_filename = url('public') . "/" . config('constants.default_image');
			}

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename);

			return response()->json($result_array);
		}
	}
	public function single_image_crop_compress(Request $request)
	{
		if ($request->ajax()) {
			$flag = 0;
			$input_file_key = $request->get('input_file_key'); // file input key name 
			$validator_type = Validator::make($request->all(), [
				$input_file_key => 'mimes:jpeg,jpg,png,ico,svg',
			]);

			if ($validator_type->fails()) {
				$message = 'uploaded file type is not valid';
				$flag = 1;
			}
			$validator_size = Validator::make($request->all(), [
				$input_file_key => 'max:20000',
				//The value is in kilobytes. I.e. max:10240 = max 10 MB.
			]);


			if ($validator_size->fails()) {
				$message = 'maximum uploading size is 20 MB';
				$flag = 1;
			}

			if ($flag == 0) {
				$folder_name = str_replace("/", "slash", $request->get('save_folder'));
				

				$dir_path = "/public/storage/" . $folder_name;
				if (!\File::isDirectory(base_path($dir_path))) {
					\File::makeDirectory(base_path($dir_path), $mode = 0777, $recursive = true, $force = false);
				}
				$status = true;
				$message = "File successfully uploaded!";

				$crop_compress = $request->get('crop_compress');

				if ($crop_compress == "crop") {
					$crop_array = explode("X", $request->get('crop_size'));
					$height = $crop_array[0];
					$width = $crop_array[1];
					$files = $request->file($input_file_key);
					$ImageUpload = Image::make($files);
					$ImageUpload->orientate();
					$ImageUpload->resize($height, $width);
					$filename = $folder_name . "/" . uniqid() . '.' . $files->getClientOriginalExtension();
					$ImageUpload->save(public_path("storage/".$filename));
					$display_filename = asset('public/storage/'.$filename);
				} else if ($crop_compress == "compress") {
					$compress_size = $request->get('compress_size');
					$files = $request->file($input_file_key);
					$filename = $folder_name . "/" . uniqid() . '.' . $files->getClientOriginalExtension();

					$ImageUpload = Image::make($files)->resize($compress_size, null, function ($constraint) {
						$constraint->aspectRatio();
					});

					$ImageUpload->save(public_path("storage/".$filename));
					$display_filename = asset('public/storage/'.$filename);
				} else {
					$filename = $request->file($input_file_key)->store($folder_name);
					$display_filename = asset('public/storage/'.$filename);
				}
			} else {
				$status = false;
				$message = $message;
				$filename = "";
				$display_filename = url('public') . "/" . config('constants.default_image');
			}

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename);

			return response()->json($result_array);
		}
	}

	public function single_image_crop_compress_wattermark(Request $request)
	{
		if ($request->ajax()) {
			$flag = 0;
			$input_file_key = $request->get('input_file_key'); // file input key name 
			$validator_type = Validator::make($request->all(), [
				$input_file_key => 'mimes:jpeg,jpg,png,ico,svg',
			]);

			if ($validator_type->fails()) {
				$message = 'uploaded file type is not valid';
				$flag = 1;
			}
			$validator_size = Validator::make($request->all(), [
				$input_file_key => 'max:20000',
				//The value is in kilobytes. I.e. max:10240 = max 10 MB.
			]);


			if ($validator_size->fails()) {
				$message = 'maximum uploading size is 20 MB';
				$flag = 1;
			}

			if ($flag == 0) {
				$folder_name = str_replace("/", "slash", $request->get('save_folder'));
				$status = true;
				$message = "File successfully uploaded!";

				$crop_compress = $request->get('crop_compress');
				$files = $request->file($input_file_key);
				$ImageUpload = Image::make($files);
				$ImageUpload->orientate();
				$ImageUpload->fit(1500);

				if (Storage::disk('local')->exists('default_wattermark/' . $request->product_master_id . '.png')) {
					$ImageUpload->insert(storage_path('default_wattermark/' . $request->product_master_id . '.png'), 'bottom-right', 0, 10);
				}



				$ImageUpload->resize(800, null, function ($constraint) {
					$constraint->aspectRatio();
				});
				$filename = $folder_name . "/" . uniqid() . '.' . $files->getClientOriginalExtension();
				$ImageUpload->save(storage_path($filename));
				$display_filename = Storage::disk('public')->url($filename);
			} else {
				$status = false;
				$message = $message;
				$filename = "";
				$display_filename = url('public') . "/" . config('constants.default_image');
			}

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename);

			return response()->json($result_array);
		}
	}

	public function remove_single_video(Request $request)
	{
		if ($request->ajax()) {


			$status = true;
			$message = "File successfully removed!";
			$filename = "";
			$display_filename = url('public') . "/" . config('constants.default_video_upload_image');

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename, 'video_anchor_tag' => "javascript:;");
			return response()->json($result_array);
		}
	}


	public function single_video(Request $request)
	{

		if ($request->ajax()) {
			$flag = 0;
			$input_file_key = $request->get('input_file_key'); // file input key name 
			$validator_type = Validator::make($request->all(), [
				$input_file_key => 'mimes:gif,mov,mp4,mkv,webm,avi,m4v,mpeg',
			]);


			if ($validator_type->fails()) {

				$message = 'uploaded file type is not valid';
				$flag = 1;
			}
			$validator_size = Validator::make($request->all(), [
				$input_file_key => 'max:20000',
				//The value is in kilobytes. I.e. max:10240 = max 10 MB.
			]);


			if ($validator_size->fails()) {
				$message = 'maximum uploading size is 20 MB';
				$flag = 1;
			}

			if ($flag == 0) {
				$folder_name = str_replace("/", "slash", $request->get('save_folder'));
				$status = true;
				$message = "File successfully uploaded!";
				$filename = $request->file($input_file_key)->store($folder_name);

				$display_filename = url('public') . "/" . config('constants.default_video_uploaded_image');

				$video_anchor_tag = url('storage') . "/" . $filename;
			} else {
				$status = false;
				$message = $message;
				$filename = "";
				$display_filename = url('public') . "/" . config('constants.default_video_upload_image');
				$video_anchor_tag = "javascript:;";
			}

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename, 'video_anchor_tag' => $video_anchor_tag);

			return response()->json($result_array);
		}
	}

	public function remove_single_pdf(Request $request)
	{
		if ($request->ajax()) {


			$status = true;
			$message = "File successfully removed!";
			$filename = "";
			$display_filename = asset('public/default_images/noimage.png');

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename, 'pdf_anchor_tag' => "javascript:;");
			return response()->json($result_array);
		}
	}


	public function single_pdf(Request $request)
	{

		if ($request->ajax()) {
			$flag = 0;
			$input_file_key = $request->get('input_file_key'); // file input key name 
			$validator_type = Validator::make($request->all(), [
				$input_file_key => 'mimes:pdf',
			]);


			if ($validator_type->fails()) {

				$message = 'uploaded file type is not valid';
				$flag = 1;
			}
			$validator_size = Validator::make($request->all(), [
				$input_file_key => 'max:20000',
				//The value is in kilobytes. I.e. max:10240 = max 10 MB.
			]);


			if ($validator_size->fails()) {
				$message = 'maximum uploading size is 20 MB';
				$flag = 1;
			}

			if ($flag == 0) {

				$folder_name = str_replace("/", "slash", $request->get('save_folder'));
				$dir_path = "/public/storage/" . $folder_name;
				if (!\File::isDirectory(base_path($dir_path))) {
					\File::makeDirectory(base_path($dir_path), $mode = 0777, $recursive = true, $force = false);
				}
				
				$status = true;
				$message = "File successfully uploaded!";
				$filename = $request->file($input_file_key)->store($folder_name);

				$display_filename = asset('public/default_images/pdfimage.png');
				$pdf_anchor_tag = url('storage') . "/" . $filename;
				
			} else {
				$status = false;
				$message = $message;
				$filename = "";
				$display_filename = asset('public/default_images/pdfnoimage.png');
				$pdf_anchor_tag = "javascript:;";
			}

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename, 'pdf_anchor_tag' => $pdf_anchor_tag);

			return response()->json($result_array);
		}
	}

	public function remove_single_doc(Request $request)
	{
		if ($request->ajax()) {


			$status = true;
			$message = "File successfully removed!";
			$filename = "";
			$display_filename = asset('public/default_images/nodoc.png');

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename, 'pdf_anchor_tag' => "javascript:;");
			return response()->json($result_array);
		}
	}


	public function single_doc(Request $request)
	{

		if ($request->ajax()) {
			$flag = 0;
			$input_file_key = $request->get('input_file_key'); // file input key name 
			$validator_type = Validator::make($request->all(), [
				$input_file_key => 'mimes:pdf,doc,docx,xls,xl',
			]);
			
			if ($validator_type->fails()) {

				$message = 'uploaded file type is not valid';
				$flag = 1;
			}
			$validator_size = Validator::make($request->all(), [
				$input_file_key => 'max:20000',
				//The value is in kilobytes. I.e. max:10240 = max 10 MB.
			]);


			if ($validator_size->fails()) {
				$message = 'maximum uploading size is 20 MB';
				$flag = 1;
			}

			if ($flag == 0) {

				$folder_name = str_replace("/", "slash", $request->get('save_folder'));
				
				if (!\File::isDirectory(base_path("public/storage/".$folder_name))) {
					\File::makeDirectory(base_path("public/storage/".$folder_name), $mode = 0777, $recursive = true, $force = false);
				}
				$status = true;
				$message = "File successfully uploaded!";
				
				$filename = $request->file($input_file_key)->storeAs($folder_name,uniqid().".".$request->file($input_file_key)->getClientOriginalExtension(),'public');

				$display_filename = asset('public/default_images/yesdoc.png');
				$doc_anchor_tag = \AppHelper::getFile($filename);
			
			 } else {
				$status = false;
				$message = $message;
				$filename = "";
				$display_filename = asset('public/default_images/nodoc.png');
				$doc_anchor_tag = "javascript:;";
			}

			$result_array = array('status' => $status, 'message' => $message, 'filename' => $filename, 'display_filename' => $display_filename, 'doc_anchor_tag' => $doc_anchor_tag);

			return response()->json($result_array);
		}
	}

}
