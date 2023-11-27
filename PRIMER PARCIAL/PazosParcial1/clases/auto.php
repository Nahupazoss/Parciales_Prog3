<?php

namespace PazosNahuel
{

    class auto
    {
  
        public string $marca;
        public string $patente;
        public string $color;
        public float $precio;

        function __construct(string $marca, string $patente, string $color, float $precio )
        {
            $this->marca = $marca;
            $this->patente = $patente;
            $this->color = $color;
            $this->precio = $precio;
        
        }

        
        function ToJSON()
        {
            $retorno = array(
                'marca' => $this->marca,
                'patente' => $this->patente,
                'color' => $this->color,
                'precio' => $this->precio
            );

            return json_encode($retorno, true);
        }

        public static function GuardarEnArchivoJSON(string $path)
        {
            $obj = new \stdClass();
            $obj->exito = false;
            $obj->mensaje = "Error al guardar.";

            $archivo = fopen($path, "a");

            $contenidoActual = file_get_contents($path);

            $objetosExistente = json_decode($contenidoActual, true);
            $objetosExistente[] = json_decode($this->ToJSON());

            $retorno = file_put_contents($path, json_encode($objetosExistente));

            if($retorno !== false)
            {
                $obj->exito = true;
                $obj->mensaje = "Guardado con éxito.";
            }

            fclose($archivo);
            return json_encode($obj);
        }

        function guardarJSON($path)
        {
            $obj = new \stdClass();
            $obj->exito = false;
            $obj->mensaje = "Error al guardar.";

            $archivo = fopen($path, "a");

            $contenidoActual = file_get_contents($path);

            $objetosExistente = json_decode($contenidoActual);
            
            $objetosExistente[] = json_decode($this->ToJSON());

            $retorno = file_put_contents($path, json_encode($objetosExistente));

            if($retorno !== false)
            {
                $obj->exito = true;
                $obj->mensaje = "Guardado con éxito.";
            }

            fclose($archivo);
            return json_encode($obj);
        }
        
        
        public static function TraerTodosJSON(string $path)
        {
            $autos = [];
            $ar = fopen($path, "r");

            while (!feof($ar)) 
            {
                $linea = fgets($ar);
                $autos = json_decode($linea);
        
                if (isset($autos)) 
                {
                    $autos[] = $autos;
                }
            }

            fclose($ar);

            return json_encode($autos, JSON_PRETTY_PRINT);
        }
             
        static function traerJSON(): array
        {
            $path = './archivos/autos.json'; // va a cambiar
            $file = fopen($path, 'r');
        
            $retorno = array();
            while ($linea = fgets($file)) {
                $linea = trim($linea);
                $lectura = json_decode($linea, true);
        
                if (isset($lectura['marca']) && isset($lectura['patente']) && isset($lectura['color']) && isset($lectura['precio'])) {
                    array_push($retorno, new auto($lectura['marca'], $lectura['patente'],  $lectura['color'], $lectura['precio']));
                }
            }
        
            fclose($file);
        
            return $retorno;
        }
        
        static function verificarautoJSON($patente, $path)
        {
            $retorno = array(
                'éxito' => false,
                'mensaje' => 'El auto no está registrado.'
            );

            $sumatoriaDePrecios = 0;

            $array = auto::traerJSON($path);

            foreach($array as $autoAComprobar)
            {
                if( $autoAComprobar->patente == $patente)
                {
                    $retorno = array(
                        'éxito' => true,
                        'mensaje' => 'El auto esta registrado.'
                    );
        
                }
            }
            
        

            return json_encode($retorno, true);
            
        }

    }
}