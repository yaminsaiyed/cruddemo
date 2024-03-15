<?php
  
namespace App\Imports;
  
use App\Slider;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class SliderImport implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new Slider([
						'title'=>$row[0],
						'subtitle'=>$row[1],
						'link'=>$row[2],
						'image'=>$row[3],
						'sort_order'=>$row[4],
						'status'=>(strtolower($row[5])=='active'?1:0)
						]);
    }

     public function startRow(): int
    {
        return 3;
    }
}