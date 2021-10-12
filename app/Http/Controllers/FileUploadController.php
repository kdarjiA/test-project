<?php

namespace App\Http\Controllers;

use App\Exports\CsvData;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(FileUploadRequest $request)
    {
        $file     = $request->file;
        $fileName = $file->getClientOriginalName();
        if (!is_dir(public_path('uploads'))) {
            mkdir(public_path('uploads'));
        }
        $file->move(public_path('uploads'), $fileName);
        return back()
            ->with('success', 'You have successfully uploaded a file '. $fileName)
            ->with('file', $fileName);
    }

    public function exportUsingPackage(Request $request, $fileName = '')
    {
        $download_file_name = str_replace('.json', '.csv', $fileName);
        $params = ['fileName' => $fileName];
        return Excel::download(new CsvData($params), $download_file_name, \Maatwebsite\Excel\Excel::CSV);
    }

    public function export(Request $request, $fileName = '')
    {
        $download_file_name = str_replace('.json', '.csv', $fileName);
        $data               = [];
        $json_data          = \App\Services\HelperService::getJsonDataFromUploadedFile($fileName);
        if (!empty($json_data)) {
            $data = $json_data;
        }
        $headers  = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$download_file_name",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $key => $value) {
                fputcsv($file, array($key, $value));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
