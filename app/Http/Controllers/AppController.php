<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /*
     * Стартовая страница
     */
    public function welcome()
    {
        return view('welcome');
    }

    /*
     * Загрузка данных
     */
    public function updateCurrencies()
    {

        $client = new Client();
        try {

            $request = $client->get('http://phisix-api3.appspot.com/stocks.json');

        } catch (ConnectException $e) {

            // This is will catch all connection timeouts
            return response()->json(['error' => 'Нет подключения к серверу'], 504);

        } catch (ClientException $e) {

            // This will catch all 400 level errors.
            return response()->json(['error' => 'При обновлении произошла ошибка'], $e->getResponse()->getStatusCode());

        }

        return response()->json(json_decode($request->getBody()));
    }
}
