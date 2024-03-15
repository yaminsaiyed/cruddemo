<?php
  
namespace App\Imports;
  
use App\CmsPage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
  
class CmsPageImport implements ToModel ,WithStartRow
{
    
    public function model(array $row)
    {
        return new CmsPage([
						'title'=>$row[0],
						'short_description'=>$row[1],
						'long_description'=>$row[2],
						'meta_title'=>$row[3],
						'meta_description'=>$row[4],
						'meta_keyword'=>$row[5],
						'seo_keyword'=>$row[6],
						'status'=>(strtolower($row[7])=='active'?1:0),
						'sort_order'=>$row[8]
						]);
    }

     public function startRow(): int
    {
        return 3;
    }
}