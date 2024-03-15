<?php
  
namespace App\Imports;
  
use App\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class CityImport implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new City([
						'state_id'=>isset('App\State'::where('name','like',$row[0])->first()->id)?'App\State'::where('name','like',$row[0])->first()->id:'',
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