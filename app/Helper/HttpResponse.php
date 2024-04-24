<?php


if(! function_exists('returnData')){
     function returnData($key , $value ,string $message = null){
        $data = [
             'success' => 'true',
              $key => $value ,
         ];

         if($message){
             $data['message'] = $message ;
         }

         return response()->json($data);
     }
}
