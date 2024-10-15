<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use App\Models\{Category};

// use App\Services\{CourseServices};
use Vimeo\Laravel\Facades\Vimeo;
use Image;

class CommonServices{

    protected $courseServices;

    public function __construct()
    {

    }

    public function sendResponse($status, $title, $message, $data){
        $response = array(
          'status' => $status,
          'title' => $title,
          'message' => $message,
          'data' => $data
        );

        return json_encode($response);
    }

// =============== its for meeting record upload vimeo server ==============
  function zoomUploadVideo($filedata = null){
    // dd($filedata);
   $CLIENT_ID = '0f720dfa8d2c4386a254313712b7fb9da5a8281b';
   $CLIENT_SECRET = 'jp2uzQbxNrlXONacXTz63/vrolXjCBWkIB0zaHokCC8mlCEVsTOwuFtrwpAKUWjX1ROzJzV+pynWZannfbDZ9qkpalbjh5kQURPDfFHEgiBbg69/S/35fkzt4rUvTMpz';
   $ACCESS_TOKEN = '9934bd59f90bb90c5b4b3526cdfa78c9';
    $ATTACHMENT_TYPE = array(
                'MP4',
                'MOV',
                'MKV'
    );

    $file_name = $filedata['path'];
    $recordfileExtension = $filedata['file_type'];
    
    // $CI = get_instance();
    // $CI->vimeoClient = new \Vimeo\Vimeo($CLIENT_ID,$CLIENT_SECRET,$ACCESS_TOKEN);
   $vimeoInfo = new \Vimeo\Vimeo($CLIENT_ID,$CLIENT_SECRET,$ACCESS_TOKEN);
   
     if (!empty($file_name)) {
     $valid="";
    //  dd($_FILES["video_file"]);
     $file_extension = $recordfileExtension;
     
       if ((in_array(strtoupper($file_extension),$ATTACHMENT_TYPE))) {
          $valid = true;
      }
    //   dd($valid);
    //    d('V-File Name:: '.$file_name);
        if($valid == TRUE){
            // dd($valid);
            // $CI->videoURL= $file_name;
            // $file_name = $CI->videoURL;
            // d($file_name);
            try {
                // $uri = $CI->vimeoClient->upload($file_name, array(
                // $uri = Vimeo::upload($file_name, array(
                $uri = $vimeoInfo->upload($file_name, array(
                    // 'name' => 'VideoMetting' . time()
                    'name' => $filedata['original_name']
                ));
                
                // $video_data = $CI->vimeoClient->request($uri);
                $video_data = $vimeoInfo->request($uri);

                    if ($video_data['status'] == 200) {
                        $output = array(
                            "type" => "success",
                            // "name" => $video_data['name'],
                            "link" => $video_data['body']['link'],
                            "html" => $video_data['body']['embed']['html'],
                            "duration" => $video_data['body']['duration'],
                        );
                        // dd($output);
                        // $tsss= explode(',',$tss);
                        //   $str= str_replace('"',"",$output1['link']);
                        //   $output2=urldecode($str);
                        //   $tss= explode('/',$output2);

                        //   $video_id = substr(parse_url($tss[3], PHP_URL_PATH), 1);
                    }
                } catch (VimeoUploadException $e) {
                    echo ('Error Vimeo: VimeoUploadException');
                    $error = 'Error uploading ' . $file_name . "\n";
                    $error .= 'Server reported: ' . $e->getMessage() . "\n";
                    $output = array(
                        "type" => "error",
                        "error_message" => $error
                    );
                } catch (VimeoRequestException $e) {
                    echo ('Error Vimeo: VimeoRequestException');
                    $error = 'There was an error making the request.' . "\n";
                    $error .= 'Server reported: ' . $e->getMessage() . "\n";
                    $output = array(
                        "type" => "error",
                        "error_message" => $error
                    );
                }
            $response = json_encode($output);
    } else {
        echo ('else-1');
            $output = array(
                "type" => "error",
                "error_message" => "Invalid file type"
            );
            $response = json_encode($output);
    }
        return  $response;
        // exit();
    } else{
        echo ('else-2');
    }

  }


}
