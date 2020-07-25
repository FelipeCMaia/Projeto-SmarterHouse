<?php

class ManagerUser
{
    public function SelecionaUsuario($id_usuario)
    {
        $ch = curl_init();
        $link = "http://localhost/smarterapi/v1/manutencao-usuario/seleciona/".strval($id_usuario)."";

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $link);

        $result = curl_exec($ch);
        $json = json_decode($result);
        curl_close($ch);
        
        return $json;
    }
}

