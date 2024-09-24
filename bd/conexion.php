<?php

$hostname='localhost'; //nombre del servidor de base de datos

$database='proyecto'; //nombre de la base de datos que cree

$username='root'; //nombre de usuario de la base de datos - root es el nombre por defecto de la base de datos
                  // si es local siempre va a ser root - si es de la web siempre sera el de la web

$password=''; //contrasena que se pone para ingresar a la base de datos
              // local: no tiene contrasena - si es de la web sera la contrasena colocada en la web

$conexion=new mysqli($hostname,$username,$password,$database);  //new = crear un objeto
        //Existen 2 librerias de conexion de base de datos (msqli y pdo) la mas segura es pdo
        //Esta libreria llama los datos anteriores y hace la conexion
        //siempre va separado de los otros ya que este contiene todos los datos y se deja un espacio

if($conexion->connect_errno){

    echo "problemas de conexion";
}

?>
