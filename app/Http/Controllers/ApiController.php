<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    function makeCodeImg(){
        $uuid = uniqid();
        $this -> getImg("https://ydj.alltobid.com/PreCheckInApi/ImgCode/GenerateVerificationImage?".time(),public_path().'/codeimg/'.$uuid.".jpg",$uuid);
        return ['img' => public_path().'/codeimg/'.$uuid.'.jpg',
            'file' => file_get_contents(public_path().'/codetxt/'.$uuid.".txt")];

        return response() -> json([
            'img' => public_path().'/codeimg/'.$uuid.'.jpg',
            'file' => file_get_contents(public_path().'/codetxt/'.$uuid.".txt"),
        ]);

    }

    function getImg($url = "", $filename = "",$uuid)
    {
        $cookie_file = tempnam('./temp', 'cookie');
        //去除URL连接上面可能的引号
        //$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
        $hander = curl_init();
        $fp = fopen($filename,'wb');
        curl_setopt($hander,CURLOPT_URL,$url);
        curl_setopt($hander,CURLOPT_FILE,$fp);
        curl_setopt($hander,CURLOPT_HEADER,0);
        curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
        //curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
        curl_setopt($hander,CURLOPT_TIMEOUT,60);
        curl_setopt($hander,CURLOPT_COOKIEJAR,$cookie_file);

        file_put_contents(public_path().'/codetxt/'.$uuid.'.txt',$cookie_file);
        //var_dump($cookie_file);
        curl_exec($hander);
        curl_close($hander);
        fclose($fp);
        Return true;
    }

    function getImage(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://ydj.alltobid.com/PreCheckInApi/ImgCode/GenerateVerificationImage?".time());
        curl_setopt($curl, CURLOPT_REFERER, '');
        curl_setopt($curl, CURLOPT_USERAGENT, 'Baiduspider');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        header('Content-type: image/JPEG');
        echo $result;
    }


    function postUrl(){
        if(isset($_POST['card']) && isset($_POST['mobile']) && isset($_POST['code'])){
            //var_dump($_POST['file']);
            $cookie_file = $_POST['file'];
            //var_dump($cookie_file);exit;
            $arr = [
                'LoginMobile' => $_POST['mobile'],
                'LoginCertID' => $_POST['card'],
                'LoginVerificationCode' => $_POST['code'],
            ];
            //var_dump(json_encode($arr));
            $post_data = [
                'parameter' => json_encode($arr)
            ];

            $url="https://ydj.alltobid.com/PreCheckInApi/account/login";
            $ch=curl_init($url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file); //使用提交后得到的cookie数据做参数
            $contents=curl_exec($ch);
            curl_close($ch);

            //var_dump($contents);

            $url="https://ydj.alltobid.com/PreCheckInApi/PreCheckIn/GetCurUserInfo?nc=0.748475713151120";
            $curl_data = [
                'nc' => '0.748475713151120'
            ];
            $ch=curl_init($url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);
            curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file); //使用提交后得到的cookie数据做参数
            $res=curl_exec($ch);
            curl_close($ch);
            echo $res;

        }
    }

    function page(){
        $data = $this -> makeCodeImg();

        return view('page') -> with([
            'data' => $data
        ]);
    }
}
