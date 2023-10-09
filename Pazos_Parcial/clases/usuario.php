<?php
require_once "IBM.php";
    Class Usuario implements IBM
    {
        public int $id;
        public string $nombre;
        public string $correo;
        public string $clave;
        public int $id_perfil;


        public function __construct(int $id,string $nombre,string $correo,string $clave,int $id_perfil = 0)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->correo = $correo;
            $this->clave = $clave;
            $this->id_perfil = $id_perfil;
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function toJSON()
        {
            $json = array("nombre" => $this->nombre,
                        "correo" => $this->correo,
                        "clave" => $this->clave,
                        "id_perfil" => $this->id_perfil);

            return json_encode($json);
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function GuardarEnArchivoJSON()
    {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error al guardar.";

        $archivo = fopen("./archivos/usuarios.json", "a");

        $contenidoActual = file_get_contents("./archivos/usuarios.json");

        $objetosExistente = json_decode($contenidoActual);

        $objetosExistente[] = json_decode($this->ToJSON());

        $retorno = file_put_contents("./archivos/usuarios.json", json_encode($objetosExistente));

        if($retorno !== false)
        {
            $obj->exito = true;
            $obj->mensaje = "Guardado con éxito.";
        }

        fclose($archivo);
        return json_encode($obj);
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
    public static function TraerTodosJSON()
    {
        $usuarios = [];
        $ar = fopen("./archivos/usuarios.json", "r");

        while (!feof($ar)) 
        {
            $linea = fgets($ar);
            $usuario = json_decode($linea);
        
            if (isset($usuario)) 
            {
                $usuarios[] = $usuario;
            }
        }

    fclose($ar);

    return json_encode($usuarios, JSON_PRETTY_PRINT);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public  static function AgregarUsuario(Usuario $obj) : bool
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $consulta =$pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, id_perfil)"
                                                                 . "VALUES(:nombre, :correo, :clave , :id_perfil)"); 

            $consulta->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $obj->correo, PDO::PARAM_STR);        
            $consulta->bindValue(':clave', $obj->clave, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $obj->id_perfil, PDO::PARAM_INT);

            return $consulta->execute();  
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public static function traer() : array
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $usuarios = array();
            $consulta = $pdo->query("SELECT * FROM  usuarios");
            $consulta->execute();

            while($fila = $consulta->fetch())
            {
                $id =  $fila[0];   
                $nombre = $fila[1];
                $correo = $fila[2];
                $clave = $fila[3];
                $id_perfil = $fila[4];

                if($id_perfil != null)
                {
                    $item = new Usuario($id,$nombre,$correo,$clave,$id_perfil); 
                }
                else
                {
                    $item = new Usuario($nombre,$correo,$clave,$id,0);
                }
                array_push($usuarios, $item);
            }
            return $usuarios;  
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public static function traerUno(string $correo,string $clave)
        {
            try 
            {
                $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
                $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
                $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
                $consulta->execute();
        
                $usuario = $consulta->fetch(PDO::FETCH_OBJ);
        
                if ($usuario) 
                {
                    return new Usuario($usuario->id, $usuario->nombre, $usuario->correo, $usuario->clave, $usuario->id_perfil);
                } 
                else 
                {
                    return null; // Usuario no encontrado
                }
            } 
            catch (PDOException $e) 
            {
                // Manejar cualquier excepción de conexión aquí
                echo "Error de conexión a la base de datos: " . $e->getMessage();
                return null; // Devolver null en caso de error
            }
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function ModificarBD() : bool
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $consulta = $pdo->prepare("UPDATE usuarios SET id = :id, nombre = :nombre, correo = :correo, clave = :clave, id_perfil = :id_perfil WHERE id = :id");

            $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);        
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public static function EliminarBD(int $id) : bool
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");    
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            
            if($sql->execute())
            {
                return true;
            }
            else
            {
                return false; 
            }
            
        }
    
    }

