<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MoodleController extends Controller
{
    protected $client;
    protected $url;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = 'https://educacion.montalvomining.com/webservice/rest/server.php'; // https://tusitio.com/webservice/rest/server.php
        $this->token = '5eca07037964bef5e65278b5551a30fb'; // token generado
    }

    // 1. Listar cursos
    public function listarCursos()
    {
        $response = $this->callMoodleApi('core_course_get_courses');
        return response()->json($response);
    }

    // 2. Verificar si el usuario existe
public function buscarUsuarioPorEmail($email)
{
    // Como estás usando el email como username, buscamos por ambos campos
    $campos = ['email', 'username'];

    foreach ($campos as $campo) {
        $response = $this->callMoodleApi('core_user_get_users_by_field', [
            'field' => $campo,
            'values[0]' => $email
        ]);

        if (is_array($response) && count($response) > 0) {
            return $response[0];
        }
    }

    return null;
}



    // 3. Crear usuario (si no existe)
public function crearUsuario($datos)
{
    $response = $this->callMoodleApi('core_user_create_users', [
    'users[0][username]' => 'testuser_' . rand(1000,9999),
    'users[0][password]' => 'Test2024!abc',
    'users[0][firstname]' => 'Juan',
    'users[0][lastname]' => 'Pérez',
    'users[0][email]' => 'juan' . rand(1000,9999) . '@correo.com',
    'users[0][auth]' => 'manual'
]);

    // 1. Intentar buscar el usuario primero
    $usuarioExistente = $this->buscarUsuarioPorEmail($datos['email']);

    if (!empty($usuarioExistente) && isset($usuarioExistente['id'])) {
        \Log::info('Usuario ya existe en Moodle, se usará ese.', ['id' => $usuarioExistente['id']]);
        return $usuarioExistente;
    }

    // 2. Intentar crearlo
    $response = $this->callMoodleApi('core_user_create_users', [
        'users[0][username]' => $datos['username'],
        'users[0][password]' => $datos['password'],
        'users[0][firstname]' => $datos['firstname'],
        'users[0][lastname]' => $datos['lastname'],
        'users[0][email]' => $datos['email'],
        'users[0][auth]' => 'manual'
    ]);

    // 3. Verifica si se creó correctamente
    if (is_array($response) && isset($response[0]['id'])) {
        \Log::info('Usuario creado en Moodle.', ['id' => $response[0]['id']]);
        return $response[0];
    }

    // 4. Si hubo error por username existente, intentamos de nuevo buscarlo
    if (
        is_array($response)
        && isset($response['errorcode'])
        && $response['errorcode'] === 'invalidparameter'
        && isset($response['debuginfo'])
        && str_contains($response['debuginfo'], 'Username already exists')
    ) {
        \Log::warning('Username ya existía, buscando el usuario por email...');

        $usuario = $this->buscarUsuarioPorEmail($datos['email']);
        \Log::info('Usuario recuperado correctamente después del error de duplicado', $usuario);

        if (!empty($usuario) && isset($usuario['id'])) {
            \Log::info('Usuario encontrado luego del error de duplicado.', ['id' => $usuario['id']]);
            return $usuario;
        }
    }

    // 5. Último recurso: registrar el error
    \Log::error('Error al crear usuario en Moodle', ['response' => $response]);

    return [
        'error' => true,
        'message' => 'No se pudo crear el usuario en Moodle',
        'debug' => $response
    ];
}



// 4. Verifica si el usuario ya está matriculado en el curso
public function estaMatriculado($userId, $courseId)
{
    $response = $this->callMoodleApi('core_enrol_get_users_courses', [
        'userid' => $userId
    ]);

    // Validar que la respuesta sea un array (lista de cursos)
    if (!is_array($response)) {
        \Log::error('❌ Error en core_enrol_get_users_courses', [
            'userid' => $userId,
            'response' => $response
        ]);
        return false;
    }

    foreach ($response as $curso) {
        if (isset($curso['id']) && $curso['id'] == $courseId) {
            return true;
        }
    }

    return false;
}

    // 5. Matricular usuario al curso
public function matricularUsuario($userId, $courseId, $roleId = 5)
{
    \Log::info('📌 Verificando si el usuario ya está matriculado', [
        'userId' => $userId,
        'courseId' => $courseId
    ]);

    if ($this->estaMatriculado($userId, $courseId)) {
        \Log::info('✅ Usuario ya estaba matriculado previamente.', [
            'userId' => $userId,
            'courseId' => $courseId
        ]);
        return ['status' => 'ya_matriculado'];
    }

    \Log::info('🚀 Intentando matricular usuario en curso...', [
        'userId' => $userId,
        'courseId' => $courseId,
        'roleId' => $roleId
    ]);

    $response = $this->callMoodleApi('enrol_manual_enrol_users', [
        'enrolments[0][roleid]' => $roleId,
        'enrolments[0][userid]' => $userId,
        'enrolments[0][courseid]' => $courseId
    ]);

    \Log::info('📥 Respuesta de matrícula Moodle', [
        'response' => $response
    ]);

    return ['status' => 'matriculado', 'curso_id' => $courseId, 'response' => $response];
}


    // 6. Flujo completo: crear + verificar + matricular
    public function crearYMatricular(Request $request)
    {
        $datos = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'course_id' => 'required|integer',
        ]);
\Log::info('datos para matricular:', ['datos' => $datos]);
        // 1. Crear usuario o recuperar existente
        $usuario = $this->crearUsuario($datos);
        \Log::info('User para matricular:', ['usuario' => $usuario]);

        if (isset($usuario['error']) && $usuario['error'] === true) {
    return response()->json([
        'status' => 'error',
        'message' => $usuario['message'],
        'debug' => $usuario['debug']
    ], 500);
}

        $userId = $usuario['id'];
     \Log::info('User ID para matricular:', ['id' => $userId]);
if (!isset($usuario['id'])) {
    return response()->json([
        'status' => 'error',
        'message' => 'No se pudo obtener el ID del usuario para matricular',
        'usuario' => $usuario
    ]);
}

        // 2. Matricular
        $matricula = $this->matricularUsuario($userId, $datos['course_id']);
     \Log::info(' matricular:', ['matricula' => $matricula]);

        return response()->json([
            'usuario' => $usuario,
            'matricula' => $matricula
        ]);
    }
    

    // Método general para consumir Moodle Web Service
  protected function callMoodleApi($function, $params = [])
{
    \Log::info('📤 Llamando función Moodle API: ' . $function, [
        'params' => $params
    ]);

    $response = $this->client->post($this->url, [
        'form_params' => array_merge([
            'wstoken' => $this->token,
            'wsfunction' => $function,
            'moodlewsrestformat' => 'json'
        ], $params)
    ]);

    $json = json_decode($response->getBody(), true);

    \Log::info('📥 Respuesta de Moodle API (' . $function . ')', [
        'response' => $json
    ]);

    return $json;
}


}
