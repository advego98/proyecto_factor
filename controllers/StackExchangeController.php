<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\web\Response;

class StackExchangeController extends Controller
{
    // Acción para obtener las preguntas recientes de Stack Overflow
    public function actionRecentQuestions($tagged, $todate = null, $fromdate = null)
    {
        // Formateo del tipo de dato de respuesta
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (empty($tagged)) {
            return [
                'success' => false,
                'message' => 'El parámetro de búsqueda "tagged" es requerido.',
            ];
        } 

        $client = new Client();

        // Seteo de datos para la consulta
        $datosEnvio = array(
            'tagged' => $tagged,
            'site' => 'stackoverflow',
        );

        if (!empty($todate)) {
            $datosEnvio['todate'] = $todate;
        }
    
        if (!empty($fromdate)) {
            $datosEnvio['fromdate'] = $fromdate;
        }
      
        // llamada a la API de stack exchange
        $response = $client ->createRequest()
                            ->setMethod('GET')
                            ->setUrl('https://api.stackexchange.com/2.3/questions')
                            ->setData($datosEnvio)
                            ->send();


        // Tratamiento de la respuesta obtenida
         if ($response->isOk) {
            
            // Guardado de los datos en la base de datos
            foreach ($response->data['items'] as $item) {
                Yii::$app->db->createCommand()->insert('preguntas', [
                    'question_id' => $item['question_id'],
                    'title' => $item['title'],
                    'creation_date' => date('Y-m-d H:i:s', $item['creation_date']),
                    'last_activity_date' => date('Y-m-d H:i:s', $item['last_activity_date']),
                    'score' => $item['score'],
                    'view_count' => $item['view_count'],
                    'answer_count' => $item['answer_count'],
                    'is_answered' => $item['is_answered'],
                    'tags' => implode(',', $item['tags']),
                    'owner_user_id' => $item['owner']['user_id'] ?? null,
                    'owner_display_name' => $item['owner']['display_name'] ?? null,
                    'link' => $item['link'],
                ])->execute();
            }

            return [
                'success' => true,
                'data' => $response->data['items'],
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No se pudo obtener los datos de Stack Exchange',
            ];
        }
        
    }
}
