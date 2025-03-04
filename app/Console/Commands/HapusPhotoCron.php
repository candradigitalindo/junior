<?php

namespace App\Console\Commands;

use App\Models\Photocek;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class HapusPhotoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hapus:photo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus Photo Cek';


    public function handle()
    {
        $photos = Photocek::where('created_at', '<=', Carbon::now()->subMonths(2))->latest()->get();
        foreach ($photos as $photo) {
            if ($photo->photo == null) {
                # code...
            } else {
                Storage::disk('local')->delete('public/photocek/' . $photo->photo);
                $photo->update(['photo' => null]);
            }
        }
    }
}
