<?php

interface ICRUD
{
    public static function TraerTodos():array;
    public  function Agregar():bool;
    public function Modificar(int $id):bool;
    public static function Eliminar(int $id):bool;
}

    
