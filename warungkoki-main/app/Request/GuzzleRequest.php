<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class GuzzleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
        ]; 
    }

    public function getGuzzleRequest()

    {

        $client = new \GuzzleHttp\Client();

        $request = $client->get($url_api);

        $response = $request->getBody();

    

        return $response;

    }

    public function postGuzzleRequest()

    {

        $client = new \GuzzleHttp\Client();

        $url = $url_api;

    

        $myBody['name'] = "Demo";

        $request = $client->post($url,  ['body'=>$myBody]);

        $response = $request->send();

    

        return $response;

    }

    public function putGuzzleRequest()

    {

        $client = new \GuzzleHttp\Client();

        $url = $url_api;

        $myBody['name'] = "Demo";

        $request = $client->put($url,  ['body'=>$myBody]);

        $response = $request->send();

    

        return $response;

    }

    public function deleteGuzzleRequest()

    {

        $client = new \GuzzleHttp\Client();

        $url = $url_api;

        $request = $client->delete($url);

        $response = $request->send();

    

        return $response;

    }
}