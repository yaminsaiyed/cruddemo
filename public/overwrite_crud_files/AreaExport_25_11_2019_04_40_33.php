<?php
namespace App\Exports;
use App\Area;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;

class AreaExport implements FromCollection, WithHeadings,WithEvents,WithTitle//,ShouldAutoSize
{

    
  public function collection()
  {

    $condition=\Session::get('area_export');
    
    $area = Area::select('city_id','name','status','sort_order')->where($condition)->get();
    
    $export_array=array();
   
    foreach ($area as $key => $value) {
        
        
		$export_array[$key]['city']=$value->get_city->name;
		$export_array[$key]['name']=$value->name;
		$export_array[$key]['status']=($value->status==1?"Active":"Inactive");
		$export_array[$key]['sort_order']=$value->sort_order;
    }
    return collect($export_array);
  }

  public function headings(): array
    {
        return [
            ['City','Name','Status','Sort Order'],
            ['Required : YES','Required : YES','Required : YES','Required : NO'],
            ['Type : Text','Type : Text','Type : Number','Type : Number'],
        ];
    }

public function title(): string
    {
        return 'Area Export';
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