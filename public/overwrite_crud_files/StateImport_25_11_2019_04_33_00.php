<?php
  
namespace App\Imports;
  
use App\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class StateImport implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new State([
						'country_id'=>isset('App\Country'::where('name','like',$row[0])->first()->id)?'App\Country'::where('name','like',$row[0])->first()->id:'',
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