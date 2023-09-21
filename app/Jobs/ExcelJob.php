<?php

namespace App\Jobs;

use App\Events\RowCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Row;
use Illuminate\Support\Facades\Redis;

class ExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $spreadsheet = IOFactory::load($this->filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $totalRows = count($rows);
        Redis::set('excel_import_progress', 0); 

        
        for ($i = 1; $i < $totalRows; $i++) {
            $row = $rows[$i];
            Log::info($row);
            Row::create([
                'id' => $row[0],
                'name' => $row[1],
                'date' => Carbon::createFromFormat('d.m.y', $row[2])
            ]);

            event(new RowCreated($row));

            
            Redis::set('excel_import_progress', ($i / $totalRows) * 100);
        }
    }
}
