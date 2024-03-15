<?php
  
namespace App\Imports;
  
use App\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class CountryImport implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new Country([
						'name'=>$row[0],
						'status'=>(strtolower($row[1])=='active'?1:0),
						'sort_order'=>$row[2]
						]);
    }

     public function startRow(): int
    {
        return 3;
    }
}