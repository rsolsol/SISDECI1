<?PHP

class MySQL
{

//Creamos una variable tipo privada para uso del estatus de la conexión con la BD.
private $conexion = null; //Inicializamos esta variable con NULL

//A continuación colocamos el constructor de la clase, hay dos maneras de iniciar el constructor en

//una clase, con la palabra reservada __construct(), en este caso utlizamos el segundo método

//para realizar el  constructor de la clase, que es simplemente colocando el nombre de la clase en

//este caso es MySQL podemos observarlo al inicio de la programación class MySQL, tomamos el

//nombre y creamos el método constructor public function MySQL(), PHP por defecto lo identifica

//como el constructor.

public function MySQL()
{

//Lo primero que realizamos en el constructor es preguntarle a el servidor que si existe un

//valor en conexion, como ya estamos analizando la clase, para poder obtener el valor de

//una variable que se encuentra en la clase desde cualquier método dentro de la misma es

//necesario hacer uso de la palabra reservada $this->, con esto hacemos referencia a la

//variable, esta puede ser publica o privada como en el caso de conexión, quedando de la

//siguiente manera.  $this->conexion.

if(!isset($this->conexion))
{

//Si esta condición se cumple quiere decir que no tiene ningún valor la variable privada

//conexión, por lo consiguiente inicializamos la conexión con el servidor.

$this->conexion = mysql_connect("***","***","***");
@mysql_select_db("***",$this->conexion); //La @ nos evita los mesajes de
//alerta en nuestro navegador en pantalla
}
//La siguiente condici�n nos va a servir mucho para poder estar manejando los mensajes
//de error cuando utilizemos m�todos rollback, evaluamos si la variable conexi�n no trae
//con el un mensaje de error.

if(!$this->conexion)
{
//Esto es lo m�gico, la palabra reservada throw hace un objeto de error y avienta una

//exception que puede ser le�da, cachada, recogida como le quieras llamar a la acci�n por un

//try{} catch(Exception $e)
{
}
throw new Exception('No Funciona la conexcion. El Error es el siguiente: '.mysql_error());
}

} //terminamos de ejecutar el constructor de la clase MySQL.

// El siguiente m�todo lo que hace es ejecutar una acci�n sobre la BD, con esto me refiero a que

//puede ser una INSERT, UPDATE, SELECT, de igual manera que el constructor, esta preparado

//para que nos diga que posibles errores puede ocurrir, y con esto me refiero a que puede ser desde

//un error de sintaxis  de SQL como el de alg�n error de conexi�n etc.

//Este m�todo recibe un valor $consulta, en este enviamos el SQL  que queremos ejecutar en nuestra

//BD, SELECT * FROM VENTAS

public function consulta($consulta)
{

//En la variable $resultado guardaremos el resultado de la ejecuci�n de la consulta en nuestra BD.

$resultado = mysql_query($consulta,$this->conexion) or die(mysql_error()); 

//La siguiente condici�n eval�a que la variable $resultado tenga un resultado positivo sobre la

//consulta.

// En caso que este no sea as�, volvemos a utilizar la palabra reservada throw y mandamos la

//exception para que este sea recogido por el cash en php desde donde se invoque.

if(!$resultado)
{
throw new Exception('No Funciona la Consulta. El Error es el siguiente: '.mysql_error());
}

else

{
return $resultado; //Si la consulta es exitosa, el m�todo regresa $resultado.

}
} //terminamos el m�todo p�blico para realizar una consulta en la base de datos.

//El siguiente grupo de m�todos nos ayudaran dentro de nuestra clase para poder manipular

//el resultado de la consulta que realicemos, como podemos observar les llame igual que la palabra

//reservada de PHP  y MYSQL, fetch_array, fetch_row, fetch_assoc,num_rows todas ellas tiene una

//particularidad, reciben el resultado de una consulta $consulta.

public function fetch_array($consulta)
{

return @mysql_fetch_array($consulta);

}

public function fetch_row($consulta)
{

return @mysql_fetch_row($consulta);

}

public function mysqlresult($consulta,$numero,$letra)
{

return @mysql_result($consulta,$numero,$letra);

}

public function fetch_assoc($consulta)
{

return @mysql_fetch_assoc($consulta);

}

public function num_rows($consulta)
{

return @mysql_num_rows($consulta);

}

///////////////////

//Este m�todo es muy importante en el desarrollo de un software ya que podemos obtener

//el ultimo registro ingresado en nuestra base de datos, obteniendo el id, siempre y cuando

//este sea un num�rico llave.

public function id_ultimo()

{

return @mysql_insert_id();

}

//El siguiente grupo de m�todos nos ayudaran a prepara una base de datos

//para utilizar try, cash,rollback,commit.

public function begin()
{

@mysql_query("BEGIN");

}

public function commit()
{
@mysql_query("COMMIT");
}

public function rollback()
{
@mysql_query("ROLLBACK");
}

//El ultimo m�todo que tengo en esta clase de conexi�n no va a servir para poder liberar

//de memoria las consultas realizadas a la BD. Recibe el resultado de una consulta.

public function liberar($consulta)
{
@mysql_free_result($consulta);
}

}//Terminamos la clase de conexion.
?>