<?php
function agregar_webservice(){
$cnx=bdd_conectar();
?>
<form action="<?php echo $_SERVER['PHP_SELF']?>?action=guardarnuevo" method="POST" id="add" name="add">
<h3 class="frm-title-x">Agregar Web Service</h3>
	<fieldset ><legend> Ingreso de Web Service</legend>
	<table width="100%" align="center">
		<TR class="frm-fld-x-odd">
			<TD width="20%">Nombre del Web Service</TD>
			<TD>
				<input type='text' tabindex="1" name="nombre_web_service" id="nombre_web_service" maxlength="100" size="100" />
			</TD>
		</TR>
		<TR class="frm-fld-x">
			<TD width="20%">URL del Web Service</TD>
			<TD>
				<input type='text' tabindex="2" name="url_web_service" id="url_web_service" maxlength="150" size="100" />
			</TD>
		</TR>
		<TR class="frm-fld-x-odd">
			<TD width="20%">Nombre de la Funcion de consulta</TD>
			<TD>
				<input type='text' tabindex="3" name="nombre_func_web_service" id="nombre_func_web_service" maxlength="100" size="100" />
			</TD>
		</TR>
		<TR class="frm-fld-x">
			<TD width="20%">Credenciales de Usuario</TD>
			<TD>
				<input type='text' tabindex="4" name="credenciales_usuario" id="credenciales_usuario" maxlength="150" size="100" />
			</TD>
		</TR>

		<TR class="frm-fld-x-odd">
			<TD width="20%">Sentencia de consulta del Web Service</TD>
			<TD>
				<textarea tabindex="5" name="sentencia_consulta" id="sentencia_consulta" rows="7" cols="80"></textarea>
			</TD>
		</TR>
		<TR class="frm-fld-x">
			<TD width="20%">Comentario</TD>
			<TD width="80%">
				<textarea tabindex="6" name="comentario" id="comentario" rows="7" cols="80"></textarea>
			</TD>			
		</TR>
	</table>
	<table width="100%">	
		<tr class="frm-fld-x-odd" colspan="1">
			<TD width="100%"  align="center">
				<input type="hidden" name="action" value="guardarnuevo" />
				<label for="Add">&nbsp;</label>
				<input tabindex="5" class="frm-btn-x" type="submit" name="add" title="Agregar Nuevo" id="Add" value="Adicionar" />
				<input tabindex="6" class="frm-btn-x" type="button" name="cancel" title="Cancelar" id="Cancel" value="Cancelar" onclick="javascript:window.location=('index.php');" />
			<!--	<input  tabindex="7" class="frm-btn-x" type="button" name="probar" title="Verifica si hace conexi&oacute;n con el Web Service" id="Probar Web Service" value="Probar Web Service"  onclick="probar_webserice()" />-->
			</TD>
		</tr>
</table>
</fieldset>
</form>
<script language="JavaScript" type="text/javascript"> var frmvalidator = new Validator("add");
frmvalidator.addValidation("nombre_web_service","req","Nombre del Web Service"); 
frmvalidator.addValidation("url_web_service","req","la URL para conectarse al Web Service es requerida"); 
frmvalidator.addValidation("nombre_func_web_service","req","Nombre de la funcion que hace la consulta al Web Service"); 
frmvalidator.addValidation("sentencia_consulta","req","Sentencia que hace la consulta al Web Service"); 
</script>
<?php
bdd_cerrar($cnx);
}


function grabar_nuevo_webservice(){
$cnx = bdd_conectar();
$q = "INSERT INTO web_service (nombre_web_service, url_web_service, nombre_func_web_service, credenciales_usuario, sentencia_consulta, comentario) VALUES (
'".$_POST['nombre_web_service']."', 
'".$_POST['url_web_service']."', 
'".$_POST['nombre_func_web_service']."', 
'".$_POST['credenciales_usuario']."', 
'".$_POST['sentencia_consulta']."', 
'".$_POST['comentario']."')";
	$rs = bdd_pg_query($cnx, $q);
	$af = bdd_pg_affected_rows($rs);
	if ($af){ 
		?>
		<p class="ok">Registro modificado!</p>
		<p > Regresar a <a href="/indicadores/conexiones/webserice/">Web Service</a></p>
		<?php
	} else { 
		?>
		<p class="error">El registro no ha sufrido modificacion<br />
		<p > Regresar a <a href="/indicadores/conexiones/webserice/">Web Service</a></p>
		<?php echo pg_error($cnx);?></p>
		<?php
	}
	bdd_cerrar($cnx);
}


function listarTodos($table, $data, $url , $fields = '*', $per_page = 10) {
	$cnx = bdd_conectar();
	$actions = "Acciones";
	$aAdd = "Activar";
	$aEdit = "Bloquear";
	$aDelete = "Asignar";
	$q = 'SELECT '.$fields.' FROM '.$table;
	$rs = bdd_pg_query($cnx, $q);
	if ($rs) { 
		?><div id="paginador">
  		<?php 
		$url = $_SERVER['PHP_SELF'];	
		$start = 0;
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
                if ($start!=0){
                        $q1=$q." LIMIT ".$per_page." offset ".$start;
                }else{
                $q1=$q." LIMIT 10";
                }
		$result = bdd_pg_query($cnx, $q1);  
		$rs2 = bdd_pg_query($cnx, $q);
		$total_items = bdd_pg_num_rows($rs2);
		$range = 20;
		$pagination = paginacion($url, $total_items-1, $per_page, $start, 3, 'pageoftotal');
		echo $pagination;
		?></div>
		<?php
		$num = bdd_pg_num_rows($rs);
		if ($num > 0) { 
			?>
			<table  border="0" cellpadding="2" cellspacing="0" class="dataTable" width="100%">
  			<thead>
    			<?php
			$numf = pg_num_fields($rs);
			?>
    			<tr>
      			<?php
			$i = 0;
			while ($i < $numf  ) {
				$meta = pg_field_name($rs,$i); 
				$fname = $meta;
				switch ($fname) {
					case 'id_web_service':
						$fname = "ID";
					break;
					case 'nombre_web_service':
						$fname = "Nombre de Web Service";
					break;
					case 'url_web_service':
						$fname = "URL de Web Service";
					break;
					case 'nombre_func_web_service':
						$fname = "Funci&oacute;n";
					break;
					case 'comentario':
						$fname = "Comentario";
					break;
				}
				?>
				<th rowspan="2"><?php echo $fname; ?></th>
      				<?php
				$i++;
			} 
			?>
			<?php echo (count($data)>0)? "<th colspan=\"".count($data)."\" >".$actions."</th>" : NULL; ?> </tr>
			<tr>
      			<?php
			foreach($data as $value) {
				?>
      				<th><img align="middle" src="../../lib/<?php echo $value; ?>.png" alt="<?php echo $value; ?>" width="16" height="16" /></th>
     				<?php
			}
			?>
    			</tr>
 			</thead>
			<tbody>
    			<?php

			while ($reg = bdd_pg_fetch_row($result)) {
                            if ($reg[0]!=0){
				?>
    				<tr>
      				<?php
				$i = 0;
				while ($i < $numf ) {
 					switch ($i) {
						default:
							?>
      							<td><?php 
							echo $reg[$i]; 
							?></td>
      							<?php
						break;
					}	
					$i++;
				}
				foreach($data as $value) {
					if ($value =='Borrar'){
						?>
						<td><a href="#" onClick="disp_confirm('index.php?action=borrar&id=<?php echo $reg[0] ?>','no','&iquest; Esta seguro que quiere eliminar este registro ID:<?php echo $reg[0]?>?');"><?php echo $value; ?> </a></td>
						<?php 
					} 
					else 
					{ ?>
					<td><a href="<?php  $_SERVER['PHP_SELF']?> index.php?action=<?php echo strtolower($value); ?>&amp;id=<?php echo $reg[0]?>"> <?php echo $value; ?></a></td>
					<?php 
					}
				}
				?>
				</tr>
    				<?php
			}

                }
			?>
  			</tbody>
  			<?php
			?>
			</table>
			<?php
		} 
	} 
bdd_cerrar($cnx);
}

function editar_webservice($id){
	$cnx = bdd_conectar();
	$q = '	SELECT 
			web_service.id_web_service, 
			web_service.nombre_web_service, 
			web_service.url_web_service, 
			web_service.nombre_func_web_service, 
			web_service.credenciales_usuario, 
			web_service.sentencia_consulta, 
			web_service.comentario
		FROM 
			public.web_service
		where 
			web_service.id_web_service='.$id;
	$rs = bdd_pg_query($cnx, $q);
	if ($rs) { 
		$reg = bdd_pg_fetch_row($rs)
		?>
		<h3>Editar Web Service</h3>
		<form action="<?php echo $_SERVER['PHP_SELF']?>?action=guardar" method="POST" id="edit" name="edit" >
			<fieldset ><legend> Editar Web Service </legend>
				<table width="100%" align="center">
					<TR class="frm-fld-x-odd">
						<TD width="20%">Nombre del Web Service</TD>
						<TD>
							<input type='text' tabindex="1" name="nombre_web_service" id="nombre_web_service" maxlength="100" size="100" value="<?php echo $reg[1]; ?>" />
						</TD>
					</TR>
					<TR class="frm-fld-x">
						<TD width="20%">URL del Web Service</TD>
						<TD>
							<input type='text' tabindex="2" name="url_web_service" id="url_web_service" maxlength="150" size="100"  value="<?php echo $reg[2]; ?>" />
						</TD>
					</TR>
					<TR class="frm-fld-x-odd">
						<TD width="20%">Nombre de la Funcion de consulta</TD>
						<TD>
							<input type='text' tabindex="3" name="nombre_func_web_service" id="nombre_func_web_service" maxlength="100" size="100"  value="<?php echo $reg[3]; ?>" />
						</TD>
					</TR>
					<TR class="frm-fld-x">
						<TD width="20%">Credenciales de Usuario</TD>
						<TD>
							<input type='text' tabindex="4" name="credenciales_usuario" id="credenciales_usuario" maxlength="150" size="100"  value="<?php echo $reg[4]; ?>" />
						</TD>
					</TR>
			
					<TR class="frm-fld-x-odd">
						<TD width="20%">Sentencia de consulta del Web Service</TD>
						<TD>
							<textarea tabindex="5" name="sentencia_consulta" id="sentencia_consulta" rows="7" cols="80"><?php echo $reg[5]; ?></textarea>
						</TD>
					</TR>
					<TR class="frm-fld-x">
						<TD width="20%">Comentario</TD>
						<TD width="80%">
							<textarea tabindex="6" name="comentario" id="comentario" rows="7" cols="80"><?php echo $reg[6]; ?></textarea>
						</TD>			
					</TR>
				</table>
				
				<table width="100%">	
					<tr class="frm-fld-x-odd">
						<TD colspan="1" align="center">
							<input type="hidden" name="action" value="guardar" />
							<input type="hidden" name="id" value="<?php echo $reg[0];?>" />
							<label for="Add">&nbsp;</label>
							<input tabindex="4" class="frm-btn-x" type="submit" name="Edit" title="Guardar" id="Edit" value="Guardar" />
							<input tabindex="5" class="frm-btn-x" type="button" name="cancel" title="Cancelar" id="Cancel" value="Cancelar" onclick="javascript:window.location=('<?php echo $_SERVER['PHP_SELF'];?>');"/>
							<input  tabindex="7" class="frm-btn-x" type="button" name="probar" title="Verifica si hace conexi&oacute;n con el Web Service" id="Probar Web Service" value="Probar Web Service" onclick="probar_webserice()" />
						</TD>
					</tr>
				</table>
	<div id="resultado"></div>
			</fieldset>
		</form>
		<script language="JavaScript" type="text/javascript"> var frmvalidator = new Validator("edit"); 
			frmvalidator.addValidation("nombre_web_service","req","Nombre del Web Service"); 
			frmvalidator.addValidation("url_web_service","req","la URL para conectarse al Web Service es requerida"); 
			frmvalidator.addValidation("nombre_func_web_service","req","Nombre de la funcion que hace la consulta al Web Service"); 
			frmvalidator.addValidation("sentencia_consulta","req","Sentencia que hace la consulta al Web Service"); 
		</script>
		<?php 
	} else { ?>
		<p class="error">Id not founded!</p>
		<?php 
	}
	bdd_cerrar($cnx);
}

function actualizar_webservice($id){
	$cnx = bdd_conectar();
	$nombre_web_service =(isset($_POST['nombre_web_service'])) ? $_POST['nombre_web_service'] : "";
	$url_web_service=(isset($_POST['url_web_service'])) ? $_POST['url_web_service'] : "";
	$nombre_func_web_service=(isset($_POST['nombre_func_web_service'])) ? $_POST['nombre_func_web_service'] : "";
	$credenciales_usuario = (isset($_POST['credenciales_usuario'])) ? $_POST['credenciales_usuario'] : "";
	$sentencia_consulta=(isset($_POST['sentencia_consulta'])) ? $_POST['sentencia_consulta'] : "";
	$comentario = (isset($_POST['comentario'])) ? $_POST['comentario'] : "";

	$q = "UPDATE web_service SET
			nombre_web_service= 	'".$nombre_web_service."'
		,	url_web_service=	'".$url_web_service."'
		,	nombre_func_web_service='".$nombre_func_web_service."'
		,	credenciales_usuario=	'".$credenciales_usuario."'
		,	sentencia_consulta= 	'".$sentencia_consulta."'
		,	comentario= 		'".$comentario."'
		where 
			id_web_service="	.$id;
	$rs = bdd_pg_query($cnx, $q);
	$af = bdd_pg_affected_rows($rs);
	//echo pg_error($cnx);
	if ($af){ 
		?>
		<p class="ok">Registro modificado!</p>
		<p > Regresar a <a href="conexion/">Rechazos</a></p>
		<?php
	} else { 
		?>
		<p class="error">El registro no ha sufrido modificacion<br />
		<p > Regresar a <a href="conexion/">Rechazos</a></p>
		  <?php echo mysqli_error($cnx);?></p>
		<?php
	}
	bdd_cerrar($cnx); 
}

function borrar_web_service($id){
	if ($id == NULL) {
		?>
		<p class="error"> Id no v&aacute;lido, intente nuevamente.</p>
		<?php
	} else {
		$cnx = bdd_conectar();
                $q = "DELETE FROM web_service WHERE id_web_service=".$id;
                $rs = @bdd_pg_query($cnx, $q);
                if ($rs){
                    $num=@bdd_pg_num_rows($rs);
                        ?>
                        <p class="ok"> Borrado exitosamente.</p>
                        <p > Regresar a <a href="/indicadores/conexiones/webservice/">Web Service</a></p>
                        <?php
                } else {
                        ?>
                        <p class="error">ha ocurrido un error, no eliminado, intente nuevamente.</p>
                         <?php
                }
	}
        bdd_cerrar($cnx);
}





?>