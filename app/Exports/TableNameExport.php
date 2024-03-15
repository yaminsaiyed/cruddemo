<?php
namespace App\Exports;
use App\TableName;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;

class TableNameExport implements FromCollection, WithHeadings,WithEvents,WithTitle,ShouldAutoSize
{

    
  public function collection()
  {

    $condition=\Session::get('tablename_export');
    
    $tablename = TableName::select('name','description','long_description','very_long_description','date','time','datetime','price','country_id','image','image_two','status','sort_order')->where($condition)->get();
    
    $export_array=array();
   
    foreach ($tablename as $key => $value) {
        
        
		$export_array[$key]['name']=$value->name;
		$export_array[$key]['description']=$value->description;
		$export_array[$key]['long_description']=$value->long_description;
		$export_array[$key]['very_long_description']=$value->very_long_description;
		$export_array[$key]['date']=$value->date;
		$export_array[$key]['time']=$value->time;
		$export_array[$key]['datetime']=$value->datetime;
		$export_array[$key]['price']=$value->price;
		$export_array[$key]['country']=$value->get_country->name;
		$export_array[$key]['image']=$value->image;
		$export_array[$key]['image_two']=$value->image_two;
		$export_array[$key]['status']=($value->status==1?"Active":"Inactive");
		$export_array[$key]['sort_order']=$value->sort_order;
    }
    return collect($export_array);
  }

  public function headings(): array
    {
        return [
            ['Name','Description','Long Description','Very Long Description','Date','Time','Datetime','Price','Country','Image','Image Two','Status','Sort Order'],
            ['Required : YES','Required : NO','Required : NO','Required : NO','Required : YES','Required : YES','Required : YES','Required : YES','Required : NO','Required : NO','Required : NO','Required : YES','Required : NO'],
            ['Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Text','Type : Number','Type : Number'],
        ];
    }

public function title(): string
    {
        return 'TableName Export';
    }

    public function registerEvents(): array
    {

    	
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },

        ];
    }
}