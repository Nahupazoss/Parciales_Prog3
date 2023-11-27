<?php
use ManejoDeUsuarios\AccesoDatos;
require_once "usuario.php";
require_once "ICRUD.php";

class Empleado  extends Usuario implements ICRUD
{
    public string $foto;
    public int $sueldo;

    public function __construct($id,$nombre,$correo,$clave,$id_perfil,string $foto,int $sueldo)
    {
        parent::__construct($id,$nombre,$correo,$clave,$id_perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }

    public static function TraerTodos(): array
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
        $empleados = array();
        $consulta = $pdo->query("SELECT * FROM  empleados");
        $consulta->execute();

        while($fila = $consulta->fetch())
        {
            $id =  $fila["id"];
            $nombre = $fila["nombre"];   
            $correo = $fila["correo"];
            $clave = $fila["clave"];
            $foto = $fila["foto"];
            $sueldo = $fila["sueldo"];
            $id_perfil = $fila["id_perfil"];

            if($id != null)
            {
                $item = new Empleado($id,$nombre,$correo,$clave,$id_perfil,$foto,$sueldo); 
            }
            else
            {
                $item = new Empleado($id,$nombre,$correo,$clave,$id_perfil,$foto,$sueldo); 
            }
            array_push($empleados, $item);
        }
        return $empleados;  
    }

    public function Agregar(): bool
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
        $consulta = $pdo->prepare("INSERT INTO empleados (correo, nombre, clave, foto, sueldo, id_perfil)"
                                                             . "VALUES(:correo, :nombre, :clave , :foto , :sueldo , :id_perfil)"); 

        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);        
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

        if($consulta->execute())
        {
            return true;
        } 
        else
        {
            return false;
        } 
    }

    public function Modificar(int $id): bool
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
        $consulta = $pdo->prepare("UPDATE empleados SET correo = :correo, nombre = :nombre, clave = :clave, foto = :foto ,sueldo = :sueldo ,id_perfil = :id_perfil 
                                WHERE id = :id");

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);        
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':sueldo', $this->sueldo, PDO::PARAM_INT);
        $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

        if ($consulta->execute() && $consulta->rowCount() > 0) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public static function Eliminar(int $id): bool
    {
        $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
        $sql = $pdo->prepare("DELETE FROM empleados WHERE id = :id");     
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $modificado = $sql->execute();

            if($modificado && $sql->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false; 
            }
    }

}