<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class CsvData implements FromCollection
{
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return collect([
            \App\Services\HelperService::getJsonDataFromUploadedFile($this->params['fileName'], true)
        ]);
    }
}
