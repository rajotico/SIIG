<?php
session_start();
include_once("roles_opciones.php");
include_once("../../addons/general/general.php");
include_once("../../lib/menu.php");
$valido = (isset($_SESSION['uid']))? $_SESSION['uid'] : NULL;
$rol = (isset($_SESSION['rol']))? $_SESSION['rol'] : NULL;
if($valido<> null){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Asocial Opciones de menu a Roles</title>
	<script type="text/javascript" src="ajax1.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="../../addons/css/general.css"/>
	<script type="text/javascript" src="../../addons/js/general.js"></script>
	<script type="text/javascript" src="../../addons/js/gen_validatorv2.js"></script>
	<link rel="stylesheet" type="text/css" href="../../addons/tables/stripy_tables.css"/>
	<script language="JavaScript" type="text/javascript" src="../../addons/tables/core.js"></script>
	<script language="JavaScript" type="text/javascript" src="../../addons/tables/stripy_tables.js"></script>
	<link rel="stylesheet" type="text/css" href="../../addons/chromemenu/chrometheme/chromestyle.css"/>
	<script language="JavaScript1.5" type="text/javascript" src="../../addons/chromemenu/chromejs/chrome.js"></script>
    </head>
    <body>
        <table align="center" width="100%">
            <tr>
		<td align="center">
                    <img src="../../lib/logo_salud.png" width="800" height="90" />
		</td>
            </tr>
        </table>
	<p align="right" ><a href="/indicadores/usuarios/index.php">Cerrar sesi&oacute;n</a></p>
	<script language="JavaScript1.5" type="text/javascript" src="../../addons/js/MPJSBackLinks.js"></script>
	<table  border="0" cellpadding="2" cellspacing="0" class="dataTable" width="100%">
            <thead>
		<tr>
                    <th><?php echo menu($rol); ?></th>
		</tr>
            </thead>
	</table> <?php
        $accion = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : NULL;
        switch ($accion) {
                case 'asociar opciones de menu a rol':
                        $id = (isset($_REQUEST['id']))? $_REQUEST['id'] : NULL;
                        asociar($id);
                break;
                case 'guardarnuevo':
                        actualizar();
                break;
                case 'editar':
                        $id = (isset($_REQUEST['id']))? $_REQUEST['id'] : NULL;
                        editar_rol($id);
                break;
                case 'guardar':
                        $id = (isset($_REQUEST['id']))? $_REQUEST['id'] : NULL;
                        actualizar_rol($id);
                break;
                        case 'borrar':
                        $id = (isset($_REQUEST['id']))? $_REQUEST['id'] : NULL;
                        borrar_rol($id);

                break;
                default: 
                        print '<h2 align="center">Asociar Opciones de Menu a Rol</a></h2>';
                        $data = array('Asociar Opciones de Menu a Rol');
                        $urls = array('Asociar Opciones de Menu a Rol');
                        echo listarTodos('roles', $data, $urls, 'id_rol, rol, descripcion');
                break;
        }?>
    </body>
</html>
<?php
}else{
    echo "<script>document.location.href='/indicadores/usuarios/index.php'</script>";
}