<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\{ClassSession, ZoomRecordDA, ClassSessionRecord};
use App\Models\User;
use Carbon\Carbon;
class HourlyClassSessionMeetingMergeScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:hourlyclasssessionmeetingmergescheduler';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $today = date('Y-m-d');
        $todaysMeetingInfos =  ZoomRecordDA::select('meeting_uuid', 'vimeo_embed_html', 'status')
                                            ->whereDate('start_time', $today)
                                            ->where('status', 'completed')
                                            ->get();
        dd($todaysMeetingInfos);
        // foreach($todaysMeetingInfos as $meeting){
        //     $full_iframe_arrays = explode(' ', $meeting->vimeo_embed_html);
        //     $iframe_links = explode('"', $full_iframe_arrays[1]);
        //     $recording_link = $iframe_links[1];
        //     $status = $meeting->status;
            
        //     $getClassSessionInfo = ClassSession::where('uuid', $meeting->meeting_uuid)->first();
            
            
        //     if($getClassSessionInfo->sessionClass){
        //         if($getClassSessionInfo->sessionClass->isZoomAutomated == 1){
        //             ClassSession::where('uuid', $meeting->meeting_uuid)
        //                         // ->where('session_date', $today)
        //                         ->whereNull('recording_link')
        //                         ->update([
        //                             'recording_link'=> (!empty($recording_link) ? $recording_link : ''),
        //                             'status'=> (!empty($status) ? $status : ''),
        //                         ]);
        //         }
        //     }
            
        // }

        return 0;
    }
}