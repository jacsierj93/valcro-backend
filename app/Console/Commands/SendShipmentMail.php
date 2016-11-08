<?php
namespace App\Console\Commands;

use App\Models\Sistema\Notifications\NotificationModule;
use App\Models\Sistema\Shipments\Shipment;
use App\Models\Sistema\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class SendShipmentMail extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailShipment:send {id}';

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
        $noti = NotificationModule::find($this->argument('id'));
        $model = Shipment::find($noti->doc_id);
        $model->usuario = $this->user ;
        $model->items = $model->items()->get();
        $dat = $noti->data()->get();

        $send= $noti->senders()->get();

        $senders = ['subject'=>$noti->asunto , 'to'=>$send->where('tipo','to'), 'cc'=>$send->where('tipo','cc'), 'ccb'=>$send->where('tipo','ccb')];
        $data = [];
        $data['text'] =[];

        foreach ($dat->where('tipo','text') as $aux){
            $data['text'][$aux->key] = $aux->value;
        }

        $noti->send_mail($noti->plantilla,$senders,['model'=>$model, 'data'=>$data] );
    }


}