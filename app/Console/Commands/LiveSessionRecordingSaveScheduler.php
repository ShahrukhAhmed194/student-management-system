<?php

namespace App\Console\Commands;

use App\Models\ClassSession;

use App\Models\ClassSessionRecord;

use App\Models\StartClassSession;

use App\Models\TempSessionRecord;
use App\Models\ZoomConfig;
use App\Models\ZoomUserAccountTbl;use App\Services\CommonServices;use Carbon\Carbon;use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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

        ini_set('max_execution_time', 5000);
        $getTempSession = TempSessionRecord::get();
        if ($getTempSession) {
            $get_zoomconfig = ZoomConfig::where('status', 1)->first();
            $servertoserver_accesstoken = $this->serverToServerAccessToken($get_zoomconfig->accountid);

            foreach ($getTempSession as $tempSession) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.zoom.us/v2//meetings/' . $tempSession->uuid . '/recordings?ttl=1',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        "Accept: application/json",
                        "Authorization: Bearer $servertoserver_accesstoken",
                        "Cookie: __cf_bm=DN1YfaSNwTTzc4ODkZprWmiZWN1jQ8_4t_6Xkw6O0LI-1719652720-1.0.1.1-nw2TpHwr1ASvsCXKuANdYDKnd9ms9ju7gQxAKEH7lkTJlq4ttH9jsCNH8SOgoq80K7Oo8wpjiudYfRRi0sDytQ; _zm_csp_script_nonce=yuP5hETWSe2VNJsLNWoSzg; _zm_mtk_guid=207431abad494e3eab660ec6f0778f53; _zm_page_auth=us06_c_sriWAb1qSECSIixtAU7vrw; _zm_ssid=us06_c_xp1FyNZrTKWdn99bwPSfeA; _zm_visitor_guid=207431abad494e3eab660ec6f0778f53; cred=14780EBF046A87079A2BBBA6DDDCC5E7",
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $jsondecorded_reclist = json_decode($response);

                if (@$jsondecorded_reclist->code != 3301) {
                    $recordingList = $jsondecorded_reclist->recording_files;

                    if ($recordingList) {
                        $sl = 0;
                        foreach ($recordingList as $record) {
                            $meeting_uuid = $record->meeting_id;

                            if ($record->recording_type == 'shared_screen_with_speaker_view' && $record->status == 'completed') {
                                $sl++;

                                $download_url = $record->download_url . "?access_token=$servertoserver_accesstoken";

                                ClassSessionRecord::create([
                                    'recording_id' => $record->id,
                                    'uuid' => $meeting_uuid,
                                    'meeting_id' => $jsondecorded_reclist->id,
                                ]);

                                $classSessionRecordData = array(
                                    'Started' => 'LIVE_REC_MAP_START ' . date('Y-m-d H:m:i'),
                                    'action' => 'CSR_INSERT',
                                    'data' => "UUID: " . $meeting_uuid . " RecordingID: " . $record->id,
                                );
                                Log::channel('liveSchedule')->info($classSessionRecordData);

                                $liveSessionRecordingInfo = ClassSessionRecord::where('recording_id', $record->id)->first();

                                if ($liveSessionRecordingInfo) {

                                    // $liveSessionName = "DA-".time()."-".$liveSessionRecordingInfo->classSession->sessionClass->name.'.'.$record->file_type;
                                    $liveSessionName = "DA-CSI-".$tempSession->class_session_id.'-' . time() . '-' . $sl . '.' . $record->file_type;

                                    $fileName = (!empty($liveSessionName) ? $liveSessionName : 'DA-CSI-'.$tempSession->class_session_id.'-' . time() . '-' . $sl . '.' . $record->file_type);
                                    $dest = public_path() . '/assets/uploads/vimeorecord' . DIRECTORY_SEPARATOR . $fileName;

                                    $ch = curl_init($download_url);
                                    curl_exec($ch);
                                    if (!curl_errno($ch)) {
                                        $info = curl_getinfo($ch);
                                        $downloadLink = $info['redirect_url'];
                                    }
                                    curl_close($ch);

                                    if ($downloadLink) {
                                        copy($downloadLink, $dest);
                                        $recording_downloaded = date('Y-m-d H:m:i');

                                        ClassSessionRecord::where('recording_id', $record->id)->update([
                                            'recording_downloaded' => date('Y-m-d H:m:i'),
                                        ]);
                                    }

                                    if (filesize($dest) == $record->file_size) {
                                        $filedata = array(
                                            'path' => $dest,
                                            'description' => "DA Class Recorded Video",
                                            'file_type' => $record->file_type,
                                            'original_name' => $fileName,
                                        );

                                        $uploadVideoData = $this->commonServices->zoomUploadVideo($filedata);
                                        $vimeoUploadedResponses = json_decode($uploadVideoData);

                                        $vimeoUrlExplode = explode('/', $vimeoUploadedResponses->link);

                                        $full_iframe_arrays = explode(' ', $vimeoUploadedResponses->html);
                                        $iframe_links = explode('"', $full_iframe_arrays[1]);
                                        $recording_link = $iframe_links[1];

                                        // echo $recording_link."<br>";
                                        ClassSessionRecord::where('recording_id', $record->id)->update([
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
                                            'recording_link' => (!empty($recording_link) ? $recording_link : ''),
                                            'recording_uploaded' => date('Y-m-d H:m:i'),
                                        ]);

                                        $recordingVimeoUploadData = array(
                                            'action' => 'CSR_UPDATED',
                                            'data' => "UUID: " . $meeting_uuid . " RecordingID: " . $record->id . " VideoID " . (!empty($vimeoUrlExplode[3]) ? $vimeoUrlExplode[3] : 0) . " Recording Start Time " . date('Y-m-d H:i:s', strtotime($record->recording_start)),
                                        );
                                        Log::channel('liveSchedule')->info($recordingVimeoUploadData);

                                        if ($meeting_uuid) {
                                            // ============ its for delete from my server directory =================
                                            unlink($dest);
                                            // =============== close ================
                                        }
                                    }
                                }

                            }
                        }

                        if ($meeting_uuid) {
                            StartClassSession::where('uuid', $meeting_uuid)->update([
                                'status' => 'Completed',
                            ]);

                            ClassSession::where('uuid', $meeting_uuid)->update([
                                // 'status' => 'Completed',
                                'recording_link' => (!empty($recording_link) ? $recording_link : ''),
                            ]);

                            TempSessionRecord::where('uuid', $meeting_uuid)->update(['is_delete' => true]);

                            $startClassSessionData = array(
                                'End' => 'LIVE_REC_MAP_END ' . date('Y-m-d H:m:i'),
                            );
                            Log::channel('liveSchedule')->info($startClassSessionData);

                            $this->recordingDeleteByUuid($meeting_uuid, $servertoserver_accesstoken);
                        }
                    }
                }
            }
        }

        return 0;
    }

    public function serverToServerAccessToken($accountid)
    {
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
                'Cookie: TS018dd1ba=01cfbc656fb82bfded7f1892bfb0adadbd1e16ce76a036dc4403356359018c22867f4cb1b79f9fb204f9edb682b40f03e7f0001c7b; TS01f92dc5=01cfbc656fb82bfded7f1892bfb0adadbd1e16ce76a036dc4403356359018c22867f4cb1b79f9fb204f9edb682b40f03e7f0001c7b; __cf_bm=Yq2lJrLzX0O2RtqKFnu2FTSiph77LKKcL3znAEqhJcA-1670051770-0-AS4hEoylEk6GjbfAsvD4Rx+HnBCG7Cw7BALHOtlDkJSp/UajhZfoyHd8VN0rbqILC8p5gzcBSiixoGRNWy23Fvg=; _zm_chtaid=97; _zm_ctaid=1gwq7OjkTPyWgmZqC1Ve_Q.1670051770335.f340ae652b072f295d6ee40300253f31; _zm_mtk_guid=212f317839d44a33bdddae3ae19ec43e; _zm_page_auth=us06_c_Xvm6l5n3S0Kgrb3l9vDnGw; _zm_ssid=us06_c_CjY6mcg_Ske477mcBGdZbw; _zm_visitor_guid=212f317839d44a33bdddae3ae19ec43e; cred=371E1296C8E2C411F3705A041E413301',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response)->access_token;
    }

    public function recordingDeleteByUuid($meeting_uuid, $servertoserver_accesstoken)
    {
        // ============== its for delete from zoom panel =====================
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.zoom.us/v2/meetings/' . $meeting_uuid . '/recordings?action=trash',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $servertoserver_accesstoken",
                'Cookie: TS018dd1ba=016e61231ea3f07a9e80d48b7b4db6804251c3796e6b3d6de7d0feb4a45cc6f86635af2b077951be46f39a49f2520dd3685be6ea02; _zm_mtk_guid=3d42407c081c4cea8da5c63df3ecbbc3; TS01f92dc5=016e61231ea3f07a9e80d48b7b4db6804251c3796e6b3d6de7d0feb4a45cc6f86635af2b077951be46f39a49f2520dd3685be6ea02; cred=927D75A9AC8651BE992FEF564D42635C',
            ),
        ));

        $delete_response = curl_exec($curl);
        //   ClassSessionRecord::where('recording_id', $recording_id)->update([
        //     'recording_deleted' => date('Y-m-d H:m:i'),
        //   ]);

        curl_close($curl);
    }

}
