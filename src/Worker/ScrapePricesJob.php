<?php
namespace GW2Exchange\Job;

use App\User;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScrapePricesJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;
    private $itemIds;
    /**
     * Create a new job instance.
     *
     * @param  string $itemIdsJSON
     * @return void
     */
    public function __construct($itemIdsJSON)
    {
        $this->itemIds = json_decode($itemIdsJSON);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fp = fopen("text.txt","a+");
        fwrite($fp, "hi\n");
        fclose($fp);
    }
}