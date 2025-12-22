<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearOldPdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-old-pdfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   public function handle()
{
    $expiredBills = BillData::where('is_pdf', 1)
        ->whereDate('pdf_generate_date', '<', now()->subDays(30))
        ->get();

    foreach ($expiredBills as $bill) {
        Storage::delete('public/' . $bill->pdf_path);

        $bill->update([
            'is_pdf' => 0,
            'pdf_generate_date' => null,
            'pdf_path' => null,
        ]);
    }
}
}
