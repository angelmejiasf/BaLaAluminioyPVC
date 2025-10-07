<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/config.php';

class AdminController {

    // USUARIOS //
    
    public function index() {
        require_once __DIR__ . '/../views/admin/admin.php';
    }


    public function listarUsuarios() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        global $pdo;
        $stmt = $pdo->prepare("SELECT id_usuario, usuario, nombre, apellido1, apellido2, telefono, email FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require '../app/views/admin/usuarios.php';
    }

    public function crearUsuario() {
        session_start();

        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        require '../app/views/admin/crear_usuario.php'; 
    }

    public function guardarUsuario() {
        session_start();
        global $pdo;
        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoge y valida los datos
            $usuario = $_POST['usuario'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellido1 = $_POST['apellido1'] ?? '';
            $apellido2 = $_POST['apellido2'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $email = $_POST['email'] ?? '';
            $password_plano = $_POST['password'] ?? '';
            $password_encriptado = password_hash($password_plano, PASSWORD_DEFAULT);
    
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, contrasena, nombre, apellido1, apellido2, telefono, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$usuario, $password_encriptado, $nombre, $apellido1, $apellido2, $telefono, $email]);
               $_SESSION['mensaje_usuario'] = "✅ Usuario creado correctamente.";
            } catch (PDOException $e) {
                 $_SESSION['mensaje_usuario_error'] = "❌ Error al crear usuario";
            }
        }
        // SIEMPRE cargar usuarios antes de mostrar la vista
        $stmt = $pdo->query("SELECT * FROM usuarios WHERE id_usuario != 1");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header("Location: /index.php?url=admin/listarUsuarios");
    }


    public function eliminarUsuario() {
        session_start();

        // Solo el admin puede eliminar usuarios
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        // Obtener el id del usuario a eliminar desde GET
        $id_usuario = $_GET['id'] ?? null;

        if (!$id_usuario) {
            $_SESSION['mensaje_usuario'] = "ID de usuario no especificado.";
        } else {
            // No permitir que el admin se elimine a sí mismo
            if ($id_usuario == 1) {
                $_SESSION['mensaje_usuario'] = "No puedes eliminar el usuario administrador principal.";
            } else {
                // Ejecutar el borrado
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
                try {
                    $stmt->execute([$id_usuario]);
                    $_SESSION['mensaje_usuario'] = "✅ Usuario eliminado correctamente.";
                } catch (PDOException $e) {
                    $_SESSION['mensaje_usuario'] = "❌ Error al eliminar usuario";
                }
            }
        }

        header("Location: /index.php?url=admin/listarUsuarios");
        exit();
    }


    public function editarUsuario() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        global $pdo;

        // Cargar lista de usuarios
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si hay un id, cargar datos de ese usuario
        $id_usuario = $_GET['id'] ?? null;
        $usuario = null;
        if ($id_usuario) {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        require '../app/views/admin/editar_usuario.php';
    }


   public function actualizarUsuario() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        $id_usuario = $_POST['id_usuario'] ?? null;
        $usuario = $_POST['usuario'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido1 = $_POST['apellido1'] ?? '';
        $apellido2 = $_POST['apellido2'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$id_usuario) {
            $_SESSION['mensaje_usuario'] = "❌ ID de usuario no especificado.";
            header("Location: /index.php?url=admin/listarUsuarios");
            exit();
        }

        try {
            $password = $_POST['password'] ?? '';

            if (!empty($password)) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET usuario=?, nombre=?, apellido1=?, apellido2=?, telefono=?, contrasena=? WHERE id_usuario=?");
                $stmt->execute([$usuario, $nombre, $apellido1, $apellido2, $telefono, $passwordHash, $id_usuario]);
                $_SESSION['mensaje_usuario'] = "✅ Usuario actualizado y contraseña modificada.";
            } else {
                $stmt = $pdo->prepare("UPDATE usuarios SET usuario=?, nombre=?, apellido1=?, apellido2=?, telefono=? WHERE id_usuario=?");
                $stmt->execute([$usuario, $nombre, $apellido1, $apellido2, $telefono, $id_usuario]);
                $_SESSION['mensaje_usuario'] = "✅ Usuario actualizado correctamente.";
            }

        } catch (PDOException $e) {
            $_SESSION['mensaje_error'] = "❌ Error al actualizar usuario: " . $e->getMessage();
        }

        header("Location: /index.php?url=admin/listarUsuarios");
        exit();
    }


    // FACTURAS //
    public function listarFacturas() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        global $pdo;

        // Obtener todos los usuarios para el select
        $stmtUsuarios = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios");
        $stmtUsuarios->execute();
        $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

        // Obtener el filtro de usuario desde GET
        $cliente = $_GET['cliente'] ?? null;

        // Consulta SQL base con JOIN
        $sql = "
            SELECT f.id_factura, f.numero_factura, f.fecha, f.descripcion, f.monto, f.estado, f.pdf, 
                u.usuario AS nombre_usuario
            FROM facturas f
            JOIN usuarios u ON f.id_usuario = u.id_usuario
        ";
        $params = [];
        if ($cliente) {
            $sql .= " WHERE f.id_usuario = ?";
            $params[] = $cliente;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require '../app/views/admin/facturas.php';
    }
    public function verPdfFactura() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        $nombre = $_GET['archivo'] ?? '';
        $ruta = __DIR__ . '/../uploads/facturas/' . basename($nombre);

        if (!file_exists($ruta)) {
            http_response_code(404);
            exit('Archivo no encontrado');
        }

        

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        readfile($ruta);
        exit;
    }


    public function guardarFactura() {
        session_start();

        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        $id_usuario = $_POST['id_usuario'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $archivo_pdf = $_FILES['archivo_pdf'] ?? null;
        $numero_factura = $_POST['numero_factura'] ?? null;
        $fecha = $_POST['fecha'] ?? date('Y-m-d');


        $mensaje = "";

        if ($archivo_pdf && $archivo_pdf['error'] === UPLOAD_ERR_OK) {
            // Carpeta privada fuera de public
            $nombre_archivo = basename($archivo_pdf['name']);
            $directorio_privado = __DIR__ . '/../uploads/facturas/';
            $ruta_destino = $directorio_privado . $nombre_archivo;

            if (!is_dir($directorio_privado)) {
                mkdir($directorio_privado, 0777, true);
            }

            if (move_uploaded_file($archivo_pdf['tmp_name'], $ruta_destino)) {
                $stmt = $pdo->prepare("INSERT INTO facturas (id_usuario, descripcion, monto, pdf, numero_factura, fecha) VALUES (?, ?, ?, ?, ?, ?)");

                try {
                    $stmt->execute([$id_usuario, $descripcion, $precio, $nombre_archivo, $numero_factura,$fecha]);
                    $_SESSION['mensaje_factura'] = "✅ Factura guardada correctamente.";
                } catch (PDOException $e) {
                    $_SESSION['mensaje_error'] = "❌ Error al guardar factura";
                }
            } else {
                $_SESSION['mensaje_error'] = "❌ Error al mover el archivo PDF.";
            }
        } else {
            $_SESSION['mensaje_error'] = "❌ No se subió ningún archivo o hubo un error.";
        }

        header("Location:/index.php?url=admin/listarFacturas");
        exit();
    }



    public function crearFactura() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $mensaje = $_SESSION['mensaje_factura'] ?? '';
        unset($_SESSION['mensaje_factura']);

     
        // Cargar vista y pasar $usuarios
        require '../app/views/admin/crear_factura.php';

        exit();
    }

    public function eliminarFactura() {
        session_start();
        
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        // Obtener el id del usuario a eliminar desde GET
        $id_factura = $_GET['id'] ?? null;

        if (!$id_factura) {
            // Si no se pasa ID, mostrar mensaje de error
            $mensaje = "ID de factura no especificado.";
        } else {
                $stmt = $pdo->prepare("DELETE FROM facturas WHERE id_factura = ?");
                try {
                    $stmt->execute([$id_factura]);
                    $mensaje = "✅ Factura eliminada correctamente.";
                } catch (PDOException $e) {
                    $mensaje = "❌ Error al eliminar factura ";
                }
            
        }
            $_SESSION['mensaje_factura'] = $mensaje;
            header("Location:/index.php?url=admin/listarFacturas");
            exit();
    }

    public function editarFactura() {


        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        global $pdo;

        // Cargar lista de usuarios para el select
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar lista de todas las facturas para el select
        $stmt = $pdo->prepare("SELECT id_factura, numero_factura, descripcion FROM facturas");
        $stmt->execute();
        $todas_las_facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar datos de la factura a editar
        $id_factura = $_GET['id'] ?? null;
        
        $factura = null;
        if ($id_factura) {
            $stmt = $pdo->prepare("SELECT * FROM facturas WHERE id_factura = ?");
            $stmt->execute([$id_factura]);
            $factura = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        require '../app/views/admin/editar_factura.php';
    }


    public function actualizarFactura() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
    
        $id_factura = $_POST['id_factura'] ?? null;
        $id_usuario = $_POST['id_usuario'] ?? null;
        $descripcion = $_POST['descripcion'] ?? '';
        $monto = $_POST['monto'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $numero_factura = $_POST['numero_factura'] ?? '';
        $fecha = $_POST['fecha'] ?? date('Y-m-d');  // Recoge la fecha editada
    
        if (!$id_factura) {
            $_SESSION['mensaje_factura'] = "❌ ID de factura no especificado.";
            header("Location: /index.php?url=admin/listarFacturas");
            exit();
        }
    
        $stmt = $pdo->prepare("UPDATE facturas SET id_usuario=?, descripcion=?, monto=?, estado=?, numero_factura=?, fecha=? WHERE id_factura=?");
        try {
            $stmt->execute([$id_usuario, $descripcion, $monto, $estado, $numero_factura, $fecha, $id_factura]);
            $_SESSION['mensaje_factura'] = "✅ Factura actualizada correctamente.";
        } catch (PDOException $e) {
            $_SESSION['mensaje_error'] = "❌ Error al actualizar factura:";        }
    
        header("Location: /index.php?url=admin/listarFacturas");
        exit();
    }



    // PRESUPUESTOS //
    public function listarPresupuestos() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        global $pdo;

        // Obtener todos los usuarios para el select
        $stmtUsuarios = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios");
        $stmtUsuarios->execute();
        $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

        // Obtener el filtro de usuario desde GET
        $cliente = $_GET['cliente'] ?? null;

        // Consulta SQL base con JOIN
        $sql = "
            SELECT p.id_presupuesto, p.numero_presupuesto, p.fecha, p.descripcion, p.monto, p.estado, p.pdf, 
                u.usuario AS nombre_usuario
            FROM presupuestos p
            JOIN usuarios u ON p.id_usuario = u.id_usuario
        ";
        $params = [];
        if ($cliente) {
            $sql .= " WHERE p.id_usuario = ?";
            $params[] = $cliente;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $presupuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require '../app/views/admin/presupuestos.php';
    }

    public function guardarPresupuesto() {
        session_start();

        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        $id_usuario = $_POST['id_usuario'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $archivo_pdf = $_FILES['archivo_pdf'] ?? null;
        $numero_presupuesto = $_POST['numero_presupuesto'] ?? null;
        $fecha = $_POST['fecha'] ?? date('Y-m-d');

        
        

        $mensaje = "";

        if ($archivo_pdf && $archivo_pdf['error'] === UPLOAD_ERR_OK) {
            $nombre_archivo = basename($archivo_pdf['name']);
            $ruta_destino = __DIR__ . '/../uploads/presupuestos/' . $nombre_archivo;

            if (!is_dir(dirname($ruta_destino))) {
                mkdir(dirname($ruta_destino), 0777, true);
            }

            if (move_uploaded_file($archivo_pdf['tmp_name'], $ruta_destino)) {
                
                $stmt = $pdo->prepare("INSERT INTO presupuestos (id_usuario, descripcion, monto, pdf, numero_presupuesto, fecha) VALUES (?, ?, ?, ?, ?, ?)");

                try {
                    $stmt->execute([$id_usuario, $descripcion, $precio, $nombre_archivo, $numero_presupuesto, $fecha]);
                    $_SESSION['mensaje_presupuesto'] = "✅ Presupuesto guardado correctamente.";
                } catch (PDOException $e) {
                    $_SESSION['mensaje_presupuesto_error'] = "❌ Error al guardar presupuesto";
                }
            } else {
                echo "Error al mover el archivo PDF.";
            }
        } else {
            echo "No se subió ningún archivo o hubo un error.";
        }

        header("Location:/index.php?url=admin/listarPresupuestos");
        exit();
    }

    public function crearPresupuesto() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $mensaje = $_SESSION['mensaje_presupuesto'] ?? '';
        unset($_SESSION['mensaje_presupuesto']);

     
        // Cargar vista y pasar $usuarios
        require '../app/views/admin/crear_presupuesto.php';

        exit();
    }

    public function eliminarPresupuesto() {
        session_start();

        
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        // Obtener el id del usuario a eliminar desde GET
        $id_factura = $_GET['id'] ?? null;

        if (!$id_factura) {
            // Si no se pasa ID, mostrar mensaje de error
            $mensaje = "ID de presupuesto no especificado.";
        } else {
                $stmt = $pdo->prepare("DELETE FROM presupuestos WHERE id_presupuesto = ?");
                try {
                    $stmt->execute([$id_factura]);
                    $_SESSION['mensaje_presupuesto'] = "✅ Presupuesto eliminado correctamente.";
                } catch (PDOException $e) {
                   $_SESSION['mensaje_presupuesto_error'] = "❌ Error al eliminar presupuesto";
                }
            
        }
            $_SESSION['mensaje_presupuesto'] = $mensaje;
            header("Location:/index.php?url=admin/listarPresupuestos");
            exit();
    }

    public function editarPresupuesto() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        global $pdo;

        // Cargar lista de usuarios para el select (si aplica)
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar lista de todos los presupuestos para el selector
        $stmt = $pdo->prepare("SELECT id_presupuesto, numero_presupuesto, descripcion, estado FROM presupuestos");
        $stmt->execute();
        $todos_los_presupuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar datos del presupuesto a editar
        $id_presupuesto = $_GET['id'] ?? null;
        $presupuesto = null;
        if ($id_presupuesto) {
            $stmt = $pdo->prepare("SELECT * FROM presupuestos WHERE id_presupuesto = ?");
            $stmt->execute([$id_presupuesto]);
            $presupuesto = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        require '../app/views/admin/editar_presupuesto.php';
    }

    public function actualizarPresupuesto() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;

        $id_presupuesto = $_POST['id_presupuesto'] ?? null;
        $id_usuario = $_POST['id_usuario'] ?? null;
        $descripcion = $_POST['descripcion'] ?? '';
        $monto = $_POST['monto'] ?? '';
        $numero_presupuesto = $_POST['numero_presupuesto'] ?? '';
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        $estado=$_POST['estado'] ?? '';

        if (!$id_presupuesto) {
            $_SESSION['mensaje_presupuesto_error'] = "❌ ID de presupuesto no especificado.";
            header("Location: /index.php?url=admin/listarPresupuestos");
            exit();
        }

        // Obtener el nombre del PDF actual
        $stmt = $pdo->prepare("SELECT pdf FROM presupuestos WHERE id_presupuesto = ?");
        $stmt->execute([$id_presupuesto]);
        $presupuesto_existente = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre_archivo_pdf = $presupuesto_existente['pdf'];

        // Si se sube un nuevo PDF, reemplazarlo
        if ($nuevo_pdf && $nuevo_pdf['error'] === UPLOAD_ERR_OK) {
            $nombre_archivo = basename($nuevo_pdf['name']);
            $ruta_destino = __DIR__ . '/../uploads/presupuestos/' . $nombre_archivo;

            if (!is_dir(dirname($ruta_destino))) {
                mkdir(dirname($ruta_destino), 0777, true);
            }

            if (move_uploaded_file($nuevo_pdf['tmp_name'], $ruta_destino)) {
                // Opcional: Borra el PDF antiguo si lo deseas
                if ($nombre_archivo_pdf && file_exists(__DIR__ . '/../uploads/presupuestos/' . $nombre_archivo_pdf)) {
                    unlink(__DIR__ . '/../uploads/presupuestos/' . $nombre_archivo_pdf);
                }
                $nombre_archivo_pdf = $nombre_archivo;
            } else {
                $_SESSION['mensaje_presupuesto_error'] = "❌ Error al subir el nuevo PDF.";
                header("Location: /index.php?url=admin/listarPresupuestos");
                exit();
            }
        }

        $stmt = $pdo->prepare("UPDATE presupuestos SET id_usuario=?, descripcion=?, monto=?, numero_presupuesto=?, pdf=?, estado=?, fecha=? WHERE id_presupuesto=?");
        try {
            $stmt->execute([$id_usuario, $descripcion, $monto, $numero_presupuesto, $nombre_archivo_pdf, $estado, $fecha, $id_presupuesto]);
            $_SESSION['mensaje_presupuesto'] = "✅ Presupuesto actualizado correctamente.";
        } catch (PDOException $e) {
            $_SESSION['mensaje_presupuesto_error'] = "❌ Error al actualizar presupuesto: " ;
        }

        header("Location: /index.php?url=admin/listarPresupuestos");
        exit();
    }

    public function verPdfPresupuesto() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        $nombre = $_GET['archivo'] ?? '';
        $ruta = __DIR__ . '/../uploads/presupuestos/' . basename($nombre);

        if (!file_exists($ruta)) {
            http_response_code(404);
            exit('Archivo no encontrado');
        }

        // Aquí puedes agregar lógica de permisos si lo deseas

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        readfile($ruta);
        exit;
    }

    public function generarPresupuesto(){
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;
        // Consulta usuarios
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1 ORDER BY usuario");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar vista y pasar $usuarios
        require '../app/views/admin/generar_presupuesto.php';

        exit();
    }

    public function descargarPresupuesto() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        $cliente_id = $_POST['cliente'] ?? '';

        $nombre_cliente = "Cliente no encontrado";

        if (!empty($cliente_id)) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT usuario, nombre, apellido1, apellido2 FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$cliente_id]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($cliente) {
                $nombre_cliente = trim($cliente['nombre'] . ' ' . $cliente['apellido1'] . ' ' . $cliente['apellido2']);
            }
        }

    $numero_presupuesto   = $_POST['numero_presupuesto'] ?? 'N/A';
    $validez              = $_POST['validez'] ?? '30 días';
    $metodo_pago          = $_POST['metodo_pago'] ?? 'Transferencia';
    $cliente_id           = $_POST['cliente'] ?? '';
    $direccion_cliente    = $_POST['direccion_cliente'] ?? '';
    $fecha_raw            = $_POST['fecha'] ?? date('Y-m-d');
    $dateObj              = DateTime::createFromFormat('Y-m-d', $fecha_raw);
    $fecha                = ($dateObj) ? $dateObj->format('d-m-Y') : date('d-m-Y');
    $conceptos            = $_POST['concepto'] ?? [];
    $cantidades           = $_POST['cantidad'] ?? [];
    $precios              = $_POST['precio'] ?? [];
    $imagenes             = $_FILES['imagen'] ?? null;

    $nombre_cliente = "Cliente no encontrado";
    if (!empty($cliente_id)) {
        $stmt = $pdo->prepare("SELECT usuario, nombre, apellido1, apellido2 FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$cliente_id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cliente) {
            $nombre_cliente = trim($cliente['nombre'] . ' ' . $cliente['apellido1'] . ' ' . $cliente['apellido2']);
        }
    }

    $totales = [];
    $total_general = 0;
    for ($i = 0; $i < count($conceptos); $i++) {
        $cantidad = isset($cantidades[$i]) ? floatval($cantidades[$i]) : 0;
        $precio = isset($precios[$i]) ? floatval($precios[$i]) : 0;
        $total = $cantidad * $precio;
        $totales[] = $total;
        $total_general += $total;
    }

    require_once(__DIR__ . '/../libraries/MyPDF.php');
    $pdf = new MyPDF('P', 'mm', 'A4');
    $pdf->AddFont('DejaVu', '', 'DejaVuSans.ttf', true);
    $pdf->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true);
    $pdf->AddFont('DejaVu', 'I', 'DejaVuSans-Oblique.ttf', true);
    $pdf->AddFont('DejaVu', 'BI', 'DejaVuSans-BoldOblique.ttf', true);
    $pdf->AddPage();

    // Encabezado empresa
    $pdf->SetFont('DejaVu', 'B', 13);
    $pdf->Cell(0, 10, 'BaLa Aluminio y PVC', 0, 1, 'R');
    $pdf->SetFont('DejaVu', '', 10);
    $pdf->Cell(0, 6, 'B75838581', 0, 1, 'R');
    $pdf->Cell(0, 6, 'Calle Isabel II Nº 11 Bajo B', 0, 1, 'R');
    $pdf->Cell(0, 6, '28982 Parla, Madrid, España', 0, 1, 'R');
    $pdf->Cell(0, 6, 'balaaluminioypvc.sl@gmail.com', 0, 1, 'R');
    $pdf->Cell(0, 6, 'balaaluminioypvcsl.com', 0, 1, 'R');
    $pdf->Cell(0, 6, '636481331', 0, 1, 'R');
    $pdf->Ln(10);

    // Datos presupuesto y cliente
    $pdf->SetFont('DejaVu', 'B', 11);
    $pdf->Cell(0, 7, 'Presupuesto Nº: ' . $numero_presupuesto, 0, 1, 'L');
    $pdf->Cell(0, 7, 'Fecha: ' . $fecha, 0, 1, 'L');
    $pdf->Cell(0, 7, 'Validez: ' . $validez, 0, 1, 'L');
    $pdf->Cell(0, 7, 'Método de pago: ' . $metodo_pago, 0, 1, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('DejaVu', '', 10);
    $pdf->Cell(0, 6, 'Cliente: ' . $nombre_cliente, 0, 1, 'L');
    $pdf->Cell(0, 6, 'Dirección: ' . $direccion_cliente, 0, 1, 'L');
    $pdf->Ln(8);

    // Tabla - cabecera
    $w = [28, 52, 18, 28, 28];
    $pdf->SetFont('DejaVu', 'B', 9);
    $pdf->SetFillColor(37, 97, 144);
    $pdf->SetTextColor(255);
    $pdf->Cell($w[0], 8, 'Imagen', 1, 0, 'C', true);
    $pdf->Cell($w[1], 8, 'Concepto', 1, 0, 'C', true);
    $pdf->Cell($w[2], 8, 'Cantidad', 1, 0, 'C', true);
    $pdf->Cell($w[3], 8, 'Precio', 1, 0, 'C', true);
    $pdf->Cell($w[4], 8, 'Total', 1, 1, 'C', true);

    $pdf->SetFont('DejaVu', '', 9);
    $pdf->SetTextColor(0);
    $pdf->SetFillColor(240, 240, 240);

    $lineHeight = 5;
    $altoMinFila = 40;



for ($i = 0; $i < count($conceptos); $i++) {
    $concepto = $conceptos[$i];
    $cantidad = $cantidades[$i];
    $precio_unitario = number_format($precios[$i], 2, ',', '.');
    $total_item = number_format($totales[$i], 2, ',', '.');

    // ---------- 1. Calcular altura necesaria del concepto ----------
    $nbLineas = $pdf->NbLines($w[1], $concepto); // cuenta líneas necesarias
    $alturaConcepto = $nbLineas * $lineHeight;
    $h = max($altoMinFila, $alturaConcepto);

    // ---------- 2. Comprobar salto de página ----------
   $pdf->CheckPageBreak($h);


    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // ---------- 3. Celda Imagen ----------
    $pdf->Rect($x, $y, $w[0], $h); // borde de la celda
    if ($imagenes && isset($imagenes['tmp_name'][$i]) && $imagenes['tmp_name'][$i] !== '' && $imagenes['error'][$i] == 0) {
        $mime = mime_content_type($imagenes['tmp_name'][$i]);
        $ext = null;
        if ($mime == 'image/jpeg') $ext = '.jpg';
        elseif ($mime == 'image/png') $ext = '.png';
        elseif ($mime == 'image/gif') $ext = '.gif';

        if ($ext) {
            $tmp_img = tempnam(sys_get_temp_dir(), 'imgpdf_') . $ext;
            copy($imagenes['tmp_name'][$i], $tmp_img);

            list($imgWidth, $imgHeight) = getimagesize($tmp_img);

            $maxW = $w[0] - 4;
            $maxH = $h - 4;

            $ratio = min($maxW / $imgWidth, $maxH / $imgHeight);
            $newW = $imgWidth * $ratio;
            $newH = $imgHeight * $ratio;

            $xImg = $x + ($w[0] - $newW) / 2;
            $yImg = $y + ($h - $newH) / 2;

            $pdf->Image($tmp_img, $xImg, $yImg, $newW, $newH);
            unlink($tmp_img);
        }
    }

    // ---------- 4. Celda Concepto ----------
    $pdf->SetXY($x + $w[0], $y);
    $pdf->MultiCell($w[1], $lineHeight, $concepto, 1, 'L', true);

    // Recolocar para las demás celdas
    $pdf->SetXY($x + $w[0] + $w[1], $y);

    // ---------- 5. Resto de columnas ----------
    $pdf->Cell($w[2], $h, $cantidad, 1, 0, 'C', true);
    $pdf->Cell($w[3], $h, $precio_unitario . ' €', 1, 0, 'R', true);
    $pdf->Cell($w[4], $h, $total_item . ' €', 1, 0, 'R', true);

    // ---------- 6. Avanzar Y ----------
    $pdf->SetY($y + $h);
}




    $pdf->Ln(8);

    $pdf->SetFont('DejaVu', 'B', 10);
    $pdf->Cell(array_sum($w) - $w[4], 8, 'Total', 1, 0, 'C');
    $pdf->Cell($w[4], 8, number_format($total_general, 2, ',', '.') . ' €', 1, 1, 'C');

    $total_iva = $total_general * 1.21;
    $pdf->Cell(array_sum($w) - $w[4], 8, 'Total con IVA (21%)', 1, 0, 'C');
    $pdf->Cell($w[4], 8, number_format($total_iva, 2, ',', '.') . ' €', 1, 1, 'C');

    $pdf->Ln(8);

    $pdf->SetFont('DejaVu', '', 9);
    $observaciones = "Observaciones:\n- Número de cuenta para la transferencia: \n- Los precios incluyen IVA.\n- El plazo de entrega máximo es de 6 semanas desde la aprobación del presupuesto.\n- El pago se realizará en dos plazos: 50% al inicio y 50% al finalizar.\n- La garantía es de 5 años.\n- Este presupuesto es válido durante 30 días naturales desde la emisión.";
    $pdf->MultiCell(0, 6, $observaciones, 0, 'L');

    $pdf->SetFont('DejaVu', 'I', 8);
    $pdf->Cell(0, 10, 'Para aceptar este presupuesto, firme y devuelva una copia a BaLa Aluminio y PVC S.L.', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Atentamente, BaLa Aluminio y PVC S.L. CIF. B75838581', 0, 1, 'L');

    $pdf->Output('D', 'presupuesto.pdf');
    exit();
}

    // CONTABILIDAD

    public function contabilidad(){
        $this->mostrarContabilidad();
    }

    
    // Total ventas de facturas pagadas
    private function getVentasPorEstado($estado) {
        global $pdo;
        $sql = "SELECT SUM(monto) AS total FROM facturas WHERE estado = :estado";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['estado' => $estado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    
    private function getFacturas($estado = null) {
        global $pdo;
        
        $sql = "SELECT f.numero_factura, f.id_usuario, u.usuario AS nombre_cliente, f.fecha, f.monto, f.pdf, f.estado 
                FROM facturas f 
                LEFT JOIN usuarios u ON f.id_usuario = u.id_usuario";
        
        if ($estado && in_array($estado, ['pagada', 'atrasada', 'pendiente'])) {
            $sql .= " WHERE f.estado = :estado";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['estado' => $estado]);
        } else {
            $stmt = $pdo->query($sql);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getPresupuestos($estado = null) {
        global $pdo;
        $sql = "SELECT p.numero_presupuesto, p.id_usuario, u.usuario AS nombre_cliente, p.fecha, p.monto, p.estado 
                FROM presupuestos p
                LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario";
        
        $estadosValidos = ['aceptado', 'rechazado', 'enviado'];
        if ($estado && in_array($estado, $estadosValidos)) {
            $sql .= " WHERE p.estado = :estado";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['estado' => $estado]);
        } else {
            $stmt = $pdo->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    private function getTotalPresupuestosPorEstado($estado) {
        global $pdo;
        $sql = "SELECT SUM(monto) AS total FROM presupuestos WHERE estado = :estado";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['estado' => $estado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function listarCompras() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
        
        $compras = $this->getCompras();
        
        require '../app/views/admin/compras.php';  // Vista para listar compras
    }

    private function getCompras() {
        global $pdo;
        $sql = "SELECT id_compra, concepto, precio, fecha, adjunto FROM compras ORDER BY fecha DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getTotalCompras() {
        global $pdo;
        $sql = "SELECT SUM(precio) AS total FROM compras";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
    
    public function verAdjuntoCompra() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        $nombre = $_GET['archivo'] ?? '';
        $ruta = __DIR__ . '/../uploads/compras/' . basename($nombre);
    
        if (!file_exists($ruta)) {
            http_response_code(404);
            exit('Archivo no encontrado');
        }
    
        // Detectar tipo MIME (puede mejorarse)
        $ext = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            default:
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $nombre . '"');
                break;
        }
        header('Content-Disposition: inline; filename="' . $nombre . '"');
        readfile($ruta);
        exit;
    }


    public function nuevaCompra() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
    
        $stmt = $pdo->prepare("SELECT id_usuario, usuario FROM usuarios WHERE id_usuario != 1");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $mensaje = $_SESSION['mensaje_compra'] ?? '';
        unset($_SESSION['mensaje_compra']);
    
        require '../app/views/admin/nueva_compra.php';
    }

   public function guardarCompra() {
        session_start();
    
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
    
        $concepto = $_POST['concepto'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $fecha = $_POST['fecha'] ?? null;
        $adjunto = $_FILES['adjunto'] ?? null;
    
        $nombreArchivo = null;
        if ($adjunto && $adjunto['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = basename($adjunto['name']);
            $directorio = __DIR__ . '/../uploads/compras/';
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $nombreArchivo = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nombreArchivo);
            $rutaDestino = $directorio . $nombreArchivo;
    
            if (!move_uploaded_file($adjunto['tmp_name'], $rutaDestino)) {
                $_SESSION['mensaje_compra'] = "❌ Error al subir archivo adjunto.";
                header("Location: /index.php?url=admin/nuevaCompra");
                exit();
            }
        }
    
        $stmt = $pdo->prepare("INSERT INTO compras (concepto, precio, fecha, adjunto) VALUES (?, ?, ?, ?)");
        try {
            $stmt->execute([$concepto, $precio, $fecha, $nombreArchivo]);
            $_SESSION['mensaje_compra'] = "✅ Compra guardada correctamente.";
        } catch (PDOException $e) {
            $_SESSION['mensaje_compra'] = "❌ Error al guardar compra: " . $e->getMessage();
        }
        
        header("Location: /index.php?url=admin/contabilidad&tipo=compras");
        exit();


    }

    public function eliminarCompra() {
        session_start();
    
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
    
        $id_compra = $_GET['id'] ?? null;
    
        if (!$id_compra) {
            $_SESSION['mensaje_compra'] = "ID de compra no especificado.";
            header("Location:/index.php?url=admin/listarCompras");
            exit();
        }
    
        try {
            $stmt = $pdo->prepare("DELETE FROM compras WHERE id_compra = ?");
            $stmt->execute([$id_compra]);
            $_SESSION['mensaje_compra'] = "✅ Compra eliminada correctamente.";
        } catch (PDOException $e) {
            $_SESSION['mensaje_error'] = "❌ Error al eliminar compra.";
        }
        header("Location: /index.php?url=admin/contabilidad&tipo=compras");
        exit();
    }


    public function editarCompra() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
    
        $id_compra = $_GET['id'] ?? null;
        if (!$id_compra) {
            $_SESSION['mensaje_error'] = "❌ ID de compra no especificado.";
            header("Location: /index.php?url=admin/listarCompras");
            exit();
        }
    
        $stmt = $pdo->prepare("SELECT * FROM compras WHERE id_compra = ?");
        $stmt->execute([$id_compra]);
        $compra = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$compra) {
            $_SESSION['mensaje_error'] = "❌ Compra no encontrada.";
            header("Location: /index.php?url=admin/listarCompras");
            exit();
        }
    
        // Cargar la vista para editar compra y pasar $compra
        require '../app/views/admin/editar_compra.php';
        }
    
        public function actualizarCompra() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
    
        $id_compra = $_POST['id_compra'] ?? null;
        $concepto = $_POST['concepto'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        $adjunto_actual = $_POST['adjunto_actual'] ?? null; // Nombre archivo previo
        $adjunto_nuevo = $_FILES['adjunto'] ?? null;
    
        if (!$id_compra) {
            $_SESSION['mensaje_error'] = "❌ ID de compra no especificado.";
            header("Location: /index.php?url=admin/listarCompras");
            exit();
        }
    
        // Procesar nuevo archivo adjunto si se sube
        $nombreArchivo = $adjunto_actual;
        if ($adjunto_nuevo && $adjunto_nuevo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($adjunto_nuevo['name']));
            $directorio = __DIR__ . '/../uploads/compras/';
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $rutaDestino = $directorio . $nombreArchivo;
            if (!move_uploaded_file($adjunto_nuevo['tmp_name'], $rutaDestino)) {
                $_SESSION['mensaje_compra'] = "❌ Error al subir el nuevo archivo adjunto.";
                header("Location: /index.php?url=admin/listarCompras");
                exit();
            }
            // Opcional: borrar archivo adjunto anterior si existe y es diferente
            if ($adjunto_actual && $adjunto_actual !== $nombreArchivo && file_exists($directorio . $adjunto_actual)) {
                unlink($directorio . $adjunto_actual);
            }
        }
    
        // Actualizar datos
        $stmt = $pdo->prepare("UPDATE compras SET concepto=?, precio=?, fecha=?, adjunto=? WHERE id_compra=?");
        try {
            $stmt->execute([$concepto, $precio, $fecha, $nombreArchivo, $id_compra]);
            $_SESSION['mensaje_compra'] = "✅ Compra actualizada correctamente.";
        } catch (PDOException $e) {
            $_SESSION['mensaje_error'] = "❌ Error al actualizar compra: " . $e->getMessage();
        }
    
        header("Location: /index.php?url=admin/contabilidad&tipo=compras");;
        exit();
        }

        public function obtenerTotalesContabilidad() {
            global $pdo;
    
            $sqlPagadas = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado = 'pagada' AND fecha >= CURDATE() - INTERVAL 30 DAY";
            $sqlSinCobrar = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado IN ('pendiente', 'atrasada')";
            $sqlPresupuestos = "SELECT IFNULL(SUM(monto),0) FROM presupuestos WHERE estado IN ('aceptado', 'enviado')";
    
            $totalFacturasPagadas = $pdo->query($sqlPagadas)->fetchColumn();
            $totalFacturasSinCobrar = $pdo->query($sqlSinCobrar)->fetchColumn();
            $totalPresupuestosAceptados = $pdo->query($sqlPresupuestos)->fetchColumn();
  
            return [
                'totalFacturasPagadas' => $totalFacturasPagadas,
                'totalFacturasSinCobrar' => $totalFacturasSinCobrar,
                'totalPresupuestosAceptados' => $totalPresupuestosAceptados,
            ];
        }
    
        // Función para cargar la página de contabilidad con totales
   public function mostrarContabilidad() {
        session_start();
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
            header("Location: /index.php?url=auth/login");
            exit();
        }
    
        global $pdo;
        $tipo = $_GET['tipo'] ?? 'inicio';
        $filtroEstado = $_GET['estado'] ?? null;
        $filtroEstadoPresupuesto = $_GET['estado_presupuesto'] ?? null;
    
        $facturas = $this->getFacturas($filtroEstado);
        $presupuestos = $this->getPresupuestos($filtroEstadoPresupuesto);
    
        if ($filtroEstado && in_array($filtroEstado, ['pagada', 'atrasada', 'pendiente'])) {
            $totalFiltrado = $this->getVentasPorEstado($filtroEstado);
        } else {
            $totalFiltrado = 0;
        }
    
        $totalPresupuestosAceptados = $this->getTotalPresupuestosPorEstado('aceptado') ?? 0;
        $totalPresupuestosEnviados = $this->getTotalPresupuestosPorEstado('enviado') ?? 0;
        $totalPresupuestosRechazados = $this->getTotalPresupuestosPorEstado('rechazado') ?? 0;
    
        if ($filtroEstadoPresupuesto && in_array($filtroEstadoPresupuesto, ['aceptado', 'enviado', 'rechazado'])) {
            $totalPresupuestoFiltrado = $this->getTotalPresupuestosPorEstado($filtroEstadoPresupuesto);
        } else {
            $totalPresupuestoFiltrado = 0;
        }
    
        $compras = $this->getCompras();
        $totalCompras = $this->getTotalCompras();
    
                // Totales avanzados para dashboard inicio
               // Obtener valores para inicio (dashboard)
        $pendientes = $this->getTotalesFacturasPendientes();
        $cobradas = $this->getTotalesFacturasCobradas();
        
        $pendienteCobroTotal = $pendientes['total'];
        $atrasadoTotal = $pendientes['atrasado'];
        $noVencidoTotal = $pendientes['noVencido'];
        
        $cobrado60Total = $cobradas['total60'];
        $cobrado30Total = $cobradas['total30'];
        $cobrado3060Total = $cobradas['total3060'];
        
        $totalCompras = $this->getTotalCompras();
        
        $totales = [
            'totalPresupuestosAceptados' => floatval($totalPresupuestosAceptados),
            'totalPresupuestosEnviados' => floatval($totalPresupuestosEnviados),
            'totalPresupuestosRechazados' => floatval($totalPresupuestosRechazados),
            // Puedes añadir aquí otros totales si usas $totales en la vista para otros datos
        ];
        
        $periodo = $_GET['periodo'] ?? 'year';
        $resumen = $this->getResumenBeneficio($periodo);
        
        $ingresosPeriodo = $resumen['ingresos'];
        $gastosPeriodo = $resumen['gastos'];
        $beneficioPeriodo = $resumen['beneficio'];


        require '../app/views/admin/contabilidad.php';

    }

    
    // Obtiene totales de facturas cobradas últimos 60 días y subdivisión últimos 30 y entre 30-60 días
    private function getTotalesFacturasCobradas() {
        global $pdo;
    
        $sql60 = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado = 'pagada' AND fecha >= CURDATE() - INTERVAL 60 DAY";
        $sql30 = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado = 'pagada' AND fecha >= CURDATE() - INTERVAL 30 DAY";
        $sql3060 = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado = 'pagada' AND fecha < CURDATE() - INTERVAL 30 DAY AND fecha >= CURDATE() - INTERVAL 60 DAY";
    
        $total60 = $pdo->query($sql60)->fetchColumn();
        $total30 = $pdo->query($sql30)->fetchColumn();
        $total3060 = $pdo->query($sql3060)->fetchColumn();
    
        return ['total60' => $total60, 'total30' => $total30, 'total3060' => $total3060];
    }

    private function getTotalesFacturasPendientes() {
        global $pdo;
    
        $sqlTotal = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado IN ('pendiente', 'atrasada')";
        $sqlAtrasado = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado = 'atrasada'";
        $sqlNoVencido = "SELECT IFNULL(SUM(monto),0) FROM facturas WHERE estado = 'pendiente'";
    
        $total = $pdo->query($sqlTotal)->fetchColumn();
        $atrasado = $pdo->query($sqlAtrasado)->fetchColumn();
        $noVencido = $pdo->query($sqlNoVencido)->fetchColumn();
    
        return ['total' => $total, 'atrasado' => $atrasado, 'noVencido' => $noVencido];
    }

// Devuelve array con ingresos, gastos y beneficio neto según el periodo
    private function getResumenBeneficio($periodo = 'year') {
        global $pdo;
    
        switch ($periodo) {
            case '30d':
                $fechaInicio = "CURDATE() - INTERVAL 30 DAY";
                break;
            case 'trimestre':
                $fechaInicio = "CURDATE() - INTERVAL 3 MONTH";
                break;
            case 'year':
            default:
                $fechaInicio = "DATE_FORMAT(CURDATE(), '%Y-01-01')";
                break;
        }
    
        // Ingresos = sum(facturas pagadas) entre fechas
        $sqlIngresos = "SELECT IFNULL(SUM(monto),0) AS total FROM facturas WHERE estado = 'pagada' AND fecha >= $fechaInicio";
        $ingresos = $pdo->query($sqlIngresos)->fetchColumn();
    
        // Gastos = sum(compras) entre fechas
        $sqlGastos = "SELECT IFNULL(SUM(precio),0) AS total FROM compras WHERE fecha >= $fechaInicio";
        $gastos = $pdo->query($sqlGastos)->fetchColumn();
    
        // Beneficio neto
        $beneficio = $ingresos - $gastos;
    
        return [
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'beneficio' => $beneficio
        ];
    }



    }

