<?php
namespace App\Http\Controllers;

use Aws\Sqs\SqsClient; 
use Aws\Exception\AwsException;
use Illuminate\Http\Request;

class MeliController extends Controller {

    public function enviaSQS(Request $request)
    {
        #dd($request->all());
        
        $client = SqsClient::factory([
            'credentials' => [
                'key' => 'AKIA4YR4IZRDXK3MTDNB', 
                'secret'=> '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'
            ],
            'region' => 'us-east-1',
            'version' => '2012-11-05'
        ]);
        
        $params = [
#            'DelaySeconds' => 10,
            'MessageAttributes' => [
                "titulo" => [
                    'DataType' => "String",
                    'StringValue' => $request->titulo
                ],
                "categoria" => [
                    'DataType' => "String",
                    'StringValue' => $request->categoria
                ],
                "preco" => [
                    'DataType' => "String",
                    'StringValue' => $request->preco
                ],
                "quantidade" => [
                    'DataType' => "String",
                    'StringValue' => $request->quantidade
                ],
                "descricao" => [
                    'DataType' => "String",
                    'StringValue' => $request->descricao
                ],
                "fotos" => [
                    'DataType' => "String",
                    'StringValue' => json_encode($request->fotos)
                ],
                "token" => [
                    'DataType' => "String",
                    'StringValue' => $request->token
                ],
            ],
            'MessageBody' => "Information about current NY Times fiction bestseller for week of 12/11/2016.",
            'QueueUrl' => 'https://sqs.us-east-1.amazonaws.com/877373475911/sqstreinamento'
        ];
        
        try {
           return $result = $client->sendMessage($params);
#          var_dump($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

}
