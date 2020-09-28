<?php

namespace App\Http\Controllers\API\VA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;

class VABTNController extends Controller
{
    public function createVA(Request $request)
    {

            try {
                $curl = curl_init();
                $tajeer = "4726";
                $iduser = auth()->user()->id;
                $phone = \DB::table('users')
                            ->select(\DB::raw('substring(phone, 1, 9) as phone'))
                            ->where('id', $iduser)
                            ->first()->phone;
                $code = "001";
                $name = \DB::table('users')
                            ->select('name')
                            ->where('id', $iduser)
                            ->first()->name;
                $va = "9$tajeer$code$phone";
                $body = [
                        'ref' => '1234567',
                        'va' => $va,
                        'nama' => $name,
                        'layanan' => 'PT. Energi Bangsa Solusindo',
                        'kodelayanan' => '990011',
                        'jenisbayar' => 'Bayar Produk',
                        'kodejenisbyr' => '001',
                        'nogiro' => '',
                        'noid' => '24082020',
                        'tagihan' => '10000',
                        'flag' => 'F',
                        'expired' => '',
                        'reserve' => '1234567',
                        'description' => 'Bayar Produk di Tajeer.id'
                    ];
                    $body = json_encode($body);
                    $string = "TAJEERID:$body:URmoIEr1oVpHuklz30L66Ga9tbIEyAxh";
                    $secret = "vJruvbeTup";
                    $signature = hash_hmac('sha256', $string, $secret);
                
            
                // Check if initialization had gone wrong*    
                if ($curl === false) {
                    throw new Exception('failed to initialize');
                }
                

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://vabtn-dev.btn.co.id:9021/v1/tajeerid/createVA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "id: TAJEERID",
                "key: URmoIEr1oVpHuklz30L66Ga9tbIEyAxh",
                "signature: $signature"
            ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response);
            
        if ($response === false) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
            }

            curl_close($curl);
            
            return response()->json($response);
        } catch(\Exception $e) {

            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        
        }
    }
    public function inquiryVA()
    {
        $curl = curl_init();
        $tajeer = "4726";
        $iduser = auth()->user()->id;
        $phone = \DB::table('users')
                    ->select(\DB::raw('substring(phone, 1, 9) as phone'))
                    ->where('id', $iduser)
                    ->first()->phone;
        $code = "001";
        $name = \DB::table('users')
                    ->select('name')
                    ->where('id', $iduser)
                    ->first()->name;
        $va = "9$tajeer$code$phone";

        $body = [
            'ref' => '1234567',
            'va' => $va
        ];
        $body = json_encode($body);
        $string = "TAJEERID:$body:URmoIEr1oVpHuklz30L66Ga9tbIEyAxh";
        $secret = "vJruvbeTup";
        $signature = hash_hmac('sha256', $string, $secret);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://vabtn-dev.btn.co.id:9021/v1/tajeerid/inqVA",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$body,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "id: TAJEERID",
            "key: URmoIEr1oVpHuklz30L66Ga9tbIEyAxh",
            "signature: $signature"
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);

        curl_close($curl);
        return response()->json($response);

    }
    public function updateVA()
    {
        $curl = curl_init();

        $tajeer = "4726";
        $iduser = auth()->user()->id;
        $phone = \DB::table('users')
                    ->select(\DB::raw('substring(phone, 1, 9) as phone'))
                    ->where('id', $iduser)
                    ->first()->phone;
        $code = "001";
        $name = \DB::table('users')
                    ->select('name')
                    ->where('id', $iduser)
                    ->first()->name;
        $va = "9$tajeer$code$phone";
        $body = [
            'ref' => '1234567',
            'va' => $va,
            'nama' => $name,
            'layanan' => 'PT. ENERGI BANGSA SOLUSINDO',
            'kodelayanan' => '990011',
            'jenisbayar' => 'Bayar Produk Tajeer',
            'kodejenisbyr' => '001',
            'nogiro' => '',
            'noid' => '001002004',
            'tagihan' => '10000',
            'flag' => 'F',
            'expired' => '',
            'expired' => '',
            'reserve' => '1234567',
            'description' => 'Bayar produk tajeer.id'
        ];
        $body = json_encode($body);
        $string = "TAJEERID:$body:URmoIEr1oVpHuklz30L66Ga9tbIEyAxh";
        $secret = "vJruvbeTup";
        $signature = hash_hmac('sha256', $string, $secret);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://vabtn-dev.btn.co.id:9021/v1/tajeerid/updVA",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$body,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "id: TAJEERID",
            "key: URmoIEr1oVpHuklz30L66Ga9tbIEyAxh",
            "signature: $signature"
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);

        curl_close($curl);
        return response()->json($response);
    }
    public function deleteVA()
    {
        $curl = curl_init();

        $tajeer = "4726";
        $iduser = auth()->user()->id;
        $phone = \DB::table('users')
                    ->select(\DB::raw('substring(phone, 1, 9) as phone'))
                    ->where('id', $iduser)
                    ->first()->phone;
        $code = "001";
        $va = "9$tajeer$code$phone";
        $body = [
            'ref' => '1234567',
            'va' => $va
        ];
        $body = json_encode($body);
        $string = "TAJEERID:$body:URmoIEr1oVpHuklz30L66Ga9tbIEyAxh";
        $secret = "vJruvbeTup";
        $signature = hash_hmac('sha256', $string, $secret);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://vabtn-dev.btn.co.id:9021/v1/tajeerid/deleteVA",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$body,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "id: TAJEERID",
            "key: URmoIEr1oVpHuklz30L66Ga9tbIEyAxh",
            "signature: $signature"
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);

        curl_close($curl);
        return response()->json($response);

    }

    public function reportVA()
    {
        $curl = curl_init();

        $string = "TAJEERID:{}:URmoIEr1oVpHuklz30L66Ga9tbIEyAxh";
        $secret = "vJruvbeTup";
        $signature = hash_hmac('sha256', $string, $secret);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://vabtn-dev.btn.co.id:9021/v1/tajeerid/report",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "id: TAJEERID",
            "key: URmoIEr1oVpHuklz30L66Ga9tbIEyAxh",
            "signature: $signature"
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);

        curl_close($curl);
        return response()->json($response);
    }
}
