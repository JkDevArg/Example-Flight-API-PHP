<?php
require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=php_api','root',''));

Flight::route('GET /alumnos', function () {
    $query = Flight::db()->prepare("SELECT * FROM `alumnos`");
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});

Flight::route('GET /alumnos/@id', function ($id) {
    $query = Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id = $id");
    $query->execute();
    $datos = $query->fetch();
    Flight::json($datos);
});

Flight::route('POST /alumnos', function () {
    $name = (Flight::request()->data->nombres);
    $last_name = (Flight::request()->data->apellidos);

    $insert = "INSERT INTO alumnos (nombres,apellidos) VALUES(?,?)";
    $query = Flight::db()->prepare($insert);
    $query->bindParam(1,$name);
    $query->bindParam(2,$last_name);
    $query->execute();
    Flight::json(['status'=>'201', 'message'=>'Alumno creado correctamente']);
});

Flight::route('DELETE /alumnos', function () {
    $id = (Flight::request()->data->id);

    $delete = "DELETE FROM alumnos WHERE id = ?;";
    $query = Flight::db()->prepare($delete);
    $query->bindParam(1,$id);
    $query->execute();
    Flight::json(['status'=>'200', 'message'=>'Alumno borrado correctamente']);
});

Flight::route('PUT /alumnos', function () {
    $id = (Flight::request()->data->id);
    $name = (Flight::request()->data->nombres);
    $last_name = (Flight::request()->data->apellidos);

    $update = "UPDATE alumnos SET nombres = ?, apellidos = ? WHERE id = ?";
    $query = Flight::db()->prepare($update);
    $query->bindParam(1,$name);
    $query->bindParam(2,$last_name);
    $query->bindParam(3,$id);
    $query->execute();
    Flight::json(['status'=>'200', 'message'=>'Alumno actualizado correctamente']);
});

Flight::route('GET /mantenimiento', function () {
    Flight::halt(200, 'Servicio en mantenimiento...');
});



Flight::start();
