<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
    <title>Confirmación de Matrícula</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f5f7fa;
            padding: 20px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .title {
            font-size: 22px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .text {
            font-size: 16px;
            line-height: 1.6;
        }
        ul {
            padding-left: 18px;
        }
        li {
            margin-bottom: 6px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
        a {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">Confirmacion de Matricula</div>

        <div class="text">
            <p>Hola <strong>{{ $pago->cliente ?? 'Estudiante' }}</strong>,</p>

            <p>Tu matricula en el curso <strong>{{ $pago->curso_nombre ?? 'NOMBRE DEL CURSO' }}</strong> ha sido registrada exitosamente.</p>

            <p>A continuación te compartimos tus credenciales de acceso a la plataforma Moodle:</p>

            <ul>
                <li><strong>Usuario:</strong> {{ $pago->identificacion }}</li>
                <li><strong>Password temporal:</strong> {{ $pago->datos_moodle['password'] ?? '(no disponible)' }}</li>
            </ul>

            <p>Puedes acceder al campus virtual haciendo clic en el siguiente enlace:</p>

            <p><a href="https://educacion.montalvomining.com" target="_blank">https://educacion.montalvomining.com</a></p>

            <p>Una vez dentro, te recomendamos cambiar tu contraseña para mayor seguridad.</p>

            <p>¡Bienvenido(a) y muchos exitos en tu aprendizaje!</p>
        </div>

        <div class="footer">
            Este correo fue enviado automaticamente desde Montalvo Educacion. No respondas a este mensaje.
        </div>
    </div>
</body>
</html>