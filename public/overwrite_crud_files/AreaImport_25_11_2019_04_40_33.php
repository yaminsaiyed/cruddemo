<?php
  
namespace App\Imports;
  
use App\Area;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class AreaImport implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new Area([
						'city_id'=>isset('App\City'::where('name','like',$row[0])->first()->id)?'App\City'::where('name','like',$row[0])->first()->id:'',
						'name'=>$row[1],
						'status'=>(strtolower($row[2])=='active'?1:0),
						'sort_order'=>$row[3]
						]);
    }

     public function startRow(): int
    {
        return 3;
    }
}