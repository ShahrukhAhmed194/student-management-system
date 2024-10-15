<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
// use App\Models\{ZoomConfig, ZoomUserAccount, LiveSession, LiveSessionRecordingDetails};
use App\Models\{ZoomConfig, ZoomUserAccountTbl, ClassSessionRecord, ClassSession};
use App\Services\CommonServices;
use Carbon\Carbon;
use DB;

class LiveSessionRecordingSaveScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:livesessionrecordingsavescheduler';

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
        $this->commonServices = new CommonServices();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         
        $get_zoomconfig = ZoomConfig::where('status', 1)->first();
        
        // $get_hostmeetingdetails = $this->db->where('status', 1)->get('meetinghost_details_tbl')->result();
        // foreach($get_hostmeetingdetails as $single){
            // d("MY Topic ". $single->meetingid_topic. ' '. $single->meeting_rowid);
           
            $servertoserver_accesstoken = $this->serverToServerAccessToken($get_zoomconfig->accountid);
            
            // $authorization_bearer = "'Authorization: Bearer ". $servertoserver_accesstoken."'";
            // $authorization_bearer = $servertoserver_accesstoken;
            // dd($authorization_bearer);
            // $zoomaccountusers = $this->db->select('*')->from('zoom_useraccount_tbl')->get()->result();
            // $zoomaccountusers = $this->db->select('*')->from('zoom_useraccount_tbl')->where('is_active', 1)->get()->result();
            $zoomaccountusers = ZoomUserAccountTbl::where('is_active', 1)->get();

            // $zoomUsers = array(
            //     'shahabuddinp91@gmail.com', 'leadacademy.dhaka@gmail.com', 'bsagor.kl@gmail.com'
            // );

            // foreach($zoomaccountusers as $zooo_user){
            //     d('Email: '.$zooo_user->email);
            // }
            // dd($zoomaccountusers);
            $today = date('Y-m-d');
            $fromdate = date('Y-m-d', strtotime("-1 days"));
            foreach($zoomaccountusers as $z_user){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.zoom.us/v2/users/'.$z_user->email.'/recordings?from='.$fromdate.'&to='.$today.'&page_size=30',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        // ========= lead access token ================
                        "Authorization: Bearer $servertoserver_accesstoken"
                    ),
                ));
    
                $responseRecordlist = curl_exec($curl);
                curl_close($curl);
                
                $jsondecorded_reclist = json_decode($responseRecordlist);
                // d('total_records:: '.$jsondecorded_reclist->total_records);

                $meeting_list = $jsondecorded_reclist->meetings;
                // dd($meeting_list);
                foreach($meeting_list as $meeting){                
                    // d('UUID:: '.$meeting->uuid);
                    // $this->db->where('meeting_rowid', $get_hosttopicrecords->meeting_rowid)->delete('meeting_recordingdetails_tbl');
                    $recording_fileslist = $meeting->recording_files;
                    
                        if($recording_fileslist){
                            $sl = 0;
                            foreach($recording_fileslist as $record){
                              $meeting_uuid = $record->meeting_id;

                                if($record->recording_type == 'shared_screen_with_speaker_view' 
                                    || $record->recording_type == 'shared_screen_with_speaker_view(CC)'
                                    && $record->status == 'completed'){
                                    $sl++;
                                        
                                        $download_url = $record->download_url."?access_token=$servertoserver_accesstoken";
                                    

                                        $liveSessionRecordingInfo = ClassSessionRecord::where('uuid', $meeting_uuid)->first();
                                        
                                        if($liveSessionRecordingInfo){
                                            
                                          $liveSessionName = "DA-".time()."-".$liveSessionRecordingInfo->classSession->sessionClass->name.'.'.$record->file_type;
                                          
                                          $fileName = (!empty($liveSessionName) ? $liveSessionName : 'DA-'.time().'.'.$record->file_type);
                                          $dest = public_path() .'/assets/uploads/vimeorecord'. DIRECTORY_SEPARATOR . $fileName;
                                          
                                          $ch = curl_init($download_url);
                                          curl_exec($ch);
                                          if (!curl_errno($ch)) {
                                              $info = curl_getinfo($ch);
                                              $downloadLink = $info['redirect_url'];
                                          }
                                          curl_close($ch);

                                          if($downloadLink) {
                                              copy($downloadLink, $dest);

                                              ClassSessionRecord::where('uuid', $meeting_uuid)->update([
                                                'recording_downloaded' => date('Y-m-d H:m:i'),
                                              ]);
                                          }
                                        
                                          // if($recordingdetails){
                                              if(filesize($dest) == $record->file_size){
                                                  $filedata = array(
                                                      'path' => $dest,
                                                      'description' => "DA Class Recorded Video",
                                                      'file_type' => $record->file_type,
                                                      'original_name' => $fileName,
                                                  );

                                                  $uploadVideoData        = $this->commonServices->zoomUploadVideo($filedata);
                                                  $vimeoUploadedResponses = json_decode($uploadVideoData);
                                                  
                                                  
                                                  $vimeoUrlExplode = explode('/', $vimeoUploadedResponses->link);
                                                  
                                                $full_iframe_arrays = explode(' ', $vimeoUploadedResponses->html);
                                                $iframe_links = explode('"', $full_iframe_arrays[1]);
                                                $recording_link = $iframe_links[1];

                                                  // $video_id               = str_replace("/videos/","",$uploadVideoData);
                                                  ClassSessionRecord::where('uuid', $meeting_uuid)->update([
                                                    // 'meeting_id' => $meeting->id,
                                                    'recording_start' => date('Y-m-d H:i:s', strtotime($record->recording_start)),
                                                    'recording_end' => date('Y-m-d H:i:s', strtotime($record->recording_end)),
                                                    'file_type' => $record->file_type,
                                                    'file_size' => $record->file_size,
                                                    'play_url' => $record->play_url,
                                                    'download_url' => $download_url,
                                                    'status' => $record->status,
                                                    'recording_type' => $record->recording_type,
                                                    'video_id' => (!empty($vimeoUrlExplode[3]) ? $vimeoUrlExplode[3] : 0),
                                                    'vimeo_embed_html' => (!empty($vimeoUploadedResponses->html) ? $vimeoUploadedResponses->html : null),
                                                    'recording_link' => $recording_link,
                                                    'recording_uploaded' => date('Y-m-d H:m:i'),
                                                  ]);
                                                  
                                                  if($meeting_uuid){
                                                    
                                                    ClassSession::where('uuid', $meeting_uuid)->update([
                                                        'status' => 'completed',
                                                    ]);

                                                      // ============ its for delete from my server directory =================
                                                      unlink($dest);
                                                      // =============== close ================
                                                      $this->recordingDeleteByUuid($meeting_uuid, $servertoserver_accesstoken);

                                                  }
                                              }
                                          // }

                                        }
                                          
                                  }
                            }
                        }
                    // }
                }
            
            }
            // d('finished');
        // }
        
        return 0;
    }

    public function serverToServerAccessToken($accountid){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$accountid",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic MXBpaXR4WkZUc0tWQWRWUnU4SUFudzpHQnA0NHVQTkdOZXNINTJFOG10a3RiSjBLTnFxSUpmUw==',
            'Cookie: TS018dd1ba=01cfbc656fb82bfded7f1892bfb0adadbd1e16ce76a036dc4403356359018c22867f4cb1b79f9fb204f9edb682b40f03e7f0001c7b; TS01f92dc5=01cfbc656fb82bfded7f1892bfb0adadbd1e16ce76a036dc4403356359018c22867f4cb1b79f9fb204f9edb682b40f03e7f0001c7b; __cf_bm=Yq2lJrLzX0O2RtqKFnu2FTSiph77LKKcL3znAEqhJcA-1670051770-0-AS4hEoylEk6GjbfAsvD4Rx+HnBCG7Cw7BALHOtlDkJSp/UajhZfoyHd8VN0rbqILC8p5gzcBSiixoGRNWy23Fvg=; _zm_chtaid=97; _zm_ctaid=1gwq7OjkTPyWgmZqC1Ve_Q.1670051770335.f340ae652b072f295d6ee40300253f31; _zm_mtk_guid=212f317839d44a33bdddae3ae19ec43e; _zm_page_auth=us06_c_Xvm6l5n3S0Kgrb3l9vDnGw; _zm_ssid=us06_c_CjY6mcg_Ske477mcBGdZbw; _zm_visitor_guid=212f317839d44a33bdddae3ae19ec43e; cred=371E1296C8E2C411F3705A041E413301'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response)->access_token;
    }

    public function recordingDeleteByUuid($meeting_uuid, $servertoserver_accesstoken){
      // ============== its for delete from zoom panel =====================
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.zoom.us/v2/meetings/'.$meeting_uuid.'/recordings?action=trash',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer $servertoserver_accesstoken",
          'Cookie: TS018dd1ba=016e61231ea3f07a9e80d48b7b4db6804251c3796e6b3d6de7d0feb4a45cc6f86635af2b077951be46f39a49f2520dd3685be6ea02; _zm_mtk_guid=3d42407c081c4cea8da5c63df3ecbbc3; TS01f92dc5=016e61231ea3f07a9e80d48b7b4db6804251c3796e6b3d6de7d0feb4a45cc6f86635af2b077951be46f39a49f2520dd3685be6ea02; cred=927D75A9AC8651BE992FEF564D42635C'
      ),
      ));

      $delete_response = curl_exec($curl);
      ClassSessionRecord::where('uuid', $meeting_uuid)->update([
        'recording_deleted' => date('Y-m-d H:m:i'),
      ]);

      curl_close($curl);
      // d($delete_response);
    }
}
