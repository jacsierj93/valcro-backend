<?php
namespace App\Console\Commands;

use App\Models\Sistema\Notifications\NotificationModule;
use App\Models\Sistema\Shipments\Shipment;
use App\Models\Sistema\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class MailAlert extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MailAlert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    /**
     * The drip e-mail service.
     *
     * @var DripEmailer
     */
    protected $drip;

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer  $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = \App\Models\Sistema\MailModels\MailAlert::where('periodo',1)->get();
        foreach ($model as $aux){
            $aux->asunto = Carbon::now();

            $aux->sendMail();
        }
        $this->info(''.sizeof($model));
    }


}