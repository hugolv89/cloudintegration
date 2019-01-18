<?php

return array(

	'cloudintegration' => 'Nube',
	'cloudintegration:cloudintegrations' => 'Nube',
	'cloudintegration:group:tool:option:enable' => 'Habilitar la Nube del grupo',

	// General
	'cloudintegration:add' => "Vincular un archivo de la Nube",
	'cloud:add' => "Vincular un archivo de la Nube",
	'cloudintegration:edit' => "Editar el vinculo de la Nube",

	'cloudintegration:owner' => "Nube de %s",
	'cloudintegration:friends' => "Nube de contactos",
	'cloudintegration:everyone' => 'Nube de todo el sitio',

	'cloudintegration:download' => "Descargar",
	'cloudintegration:open' => "Abrir en una nueva ventana",
	'cloudintegration:view' => "Ver",
	'cloudintegration:edit' => "Editar",
	'cloudintegration:none' => 'Sin Nube',
	'cloudintegration:nofiles' => 'No hay archivos.',
	'cloudintegration:unknown' => 'Archivo compartido desconocido.',

	'cloudintegration:share' => "Compartir",
	'cloudintegration:share:view:dc' => "Ver descripción y comentarios",
	'cloudintegration:share:get:info' => "El archivo se ha compartido con anterioridad y se utiliza el mismo enlace.",
	'cloudintegration:share:new' => "Nuevo recurso compartido",
	'cloudintegration:share:new:info' => "Una nueva configuración del recurso compartido elimina la configuración anterior  <br/> y borra por completo el recurso compartido anteriormente en Elgg.",
	'cloudintegration:share:create' => "Crear recurso compartido",
	'cloudintegration:share:password:optional' => "Contraseña (opcional)",
	'cloudintegration:share:password:repeat' => "Repetir contraseña",

	'cloudintegration:share:sys:correct' => "Archivo compartido correctamente",
	'cloudintegration:share:sys:save:correct' => "Archivo guardado correctamente",
	'cloudintegration:share:access:error' => "Error: el archivo compartido no se puede escribir",
	'cloudintegration:share:save:error' => "Error: el archivo compartido no se puede guardar",
	'cloudintegration:share:duplicate:error' => "Error: el archivo compartido ya existe",
	'cloudintegration:share:notfound:error' => "Error: no se ha encontrado el archivo compartido",

	'cloudintegration:unshare' => "Dejar de compartir",
	'cloudintegration:unshare:remove:all' => 'Eliminar de Elgg',
	'cloudintegration:unshare:remove:group' => 'Eliminar del grupo',
	'cloudintegration:unshare:remove:here' => 'Eliminar únicamente de aquí',
	'cloudintegration:unshare:remove:owner' => 'Eliminar de su propio espacio',
	'cloudintegration:unshare:info:shared' => 'Puede dejar de compartir el archivo o eliminarlo de Elgg',
	'cloudintegration:unshare:info:noshared' => 'Este archivo ya no se comparte desde la Nube o hay un problema de conexión.',

	'cloudintegration:unshare:sys:correct' => "se ha dejado de compartir el archivo",

	'cloudintegration:group' => 'Documentos nube',
	'cloudintegration:visible:true' => 'Visible',
	'cloudintegration:visible:false' => 'Invisible',
	'cloudintegration:visibility:sys:correct' => 'Visibilidad cambiada correctamente',
	'cloudintegration:visibility:save:error' => 'Problemas al cambiar la visibilidad',

	// River

	'cloudintegration:notify:summary' => 'Nuevo archivo de la Nube compartido llamado %s',
	'cloudintegration:notify:subject' => 'Nuevo archivo de la Nube compartido: %s',
	'cloudintegration:notify:body' =>
'%s añadido un nuevo archivo de la Nube compartido: %s

Enlace: %s

%s

Mira y comenta el archivo de la Nube compartido:
%s
',

	'river:create:object:cloudintegration' => '%s compartio %s',
	'river:comment:object:cloudintegration' => '%s comenta en el archivo de la Nube compartido %s',
	'cloudintegration:river:annotate' => 'un comentario en el archivo de la Nube compartido',
	'cloudintegration:river:item' => 'un item',

	//
	// Api
	// ********

	'cloudintegration:api:sharetype:0' => 'Usuario',
	'cloudintegration:api:sharetypes:0' => 'Usuarios',
	'cloudintegration:api:sharetype:1' => 'Grupo',
	'cloudintegration:api:sharetypes:1' => 'Grupos',
	'cloudintegration:api:sharetype:3' => 'Enlace público',
	'cloudintegration:api:sharetypes:3' => 'Enlaces públicos',

	'cloudintegration:api:permissions:1' => 'Leer',
	'cloudintegration:api:permissions:2' => 'Actualizar',
	'cloudintegration:api:permissions:4' => 'Crear',
	'cloudintegration:api:permissions:8' => 'Borrar',
	'cloudintegration:api:permissions:16' => 'Compartir',
	'cloudintegration:api:permissions:31' => 'Todo',

	//
	// Widgets
	// ********

	// Shares
	'cloudintegration:widgets:shares:name' => 'Archivos de la Nube compartidos',
	'cloudintegration:widgets:shares:description' => 'Compartir sus propios archivos públicos desde la Nube.',
	'cloudintegration:widgets:shares:number:label' => 'Número de archivos compartidos a mostrar',
	'cloudintegration:widgets:shares:toshare:label' => 'A compartir',
	'cloudintegration:widgets:shares:toshare:op:public' => 'Solo archivos públicos',
	'cloudintegration:widgets:shares:toshare:op:all' => 'Todos mis archivos compartidos',
	'cloudintegration:widgets:shares:noshare' => 'No hay archivos compartidos.',
	'cloudintegration:widgets:shares:folder:label' => 'Carpeta a compartir',
	'cloudintegration:widgets:shares:error' => 'Error Nube',

	// MetaShares
	'cloudintegration:widgets:metashares:name' => 'Archivos compartidos',
	'cloudintegration:widgets:metashares:description' => 'Comparta sus archivos de la Nube.',
	'cloudintegration:widgets:metashares:number:label' => 'Número de archivos a mostrar',
	'cloudintegration:widgets:metashares:noshare' => 'No ha compartido archivos.',

	// 
	// Settings
	// ********

	// User Settings
	'cloudintegration:usersettings:message' => '', //Descriptive message
	'cloudintegration:usersettings:label:cloudintegration:url' => 'URL del servidor de la Nube (solo https)',
	'cloudintegration:usersettings:help:cloudintegration:url' => 'Si permanece en blanco, se utilizará el URL por defecto.',
	'cloudintegration:usersettings:legend:credentials' => 'Credenciales de la Nube ',
	'cloudintegration:usersettings:label:credential:user' => 'Usuario',
	'cloudintegration:usersettings:label:credential:password' => 'Contraseña',
	'cloudintegration:usersettings:label:credential:passwordagain' => 'Repetir contraseña',
	'cloudintegration:usersettings:label:credential:unlink' => '¿Desvincular cuenta?',
	'cloudintegration:usersettings:error:password' => 'Error: contraseña no válida',
	'cloudintegration:usersettings:error:credential' => 'Error: las credenciales no son válidas',
	'cloudintegration:usersettings:error:empty' => 'Error: no se han guardado las credenciales, campos vacíos',
	'cloudintegration:usersettings:info:misconfigured' => 'La cuenta de la Nube está mal configurada.',
	'cloudintegration:usersettings:info:configure:here' => 'Configurar',

	// General
	'cloudintegration:settings:legend:general' => 'General',
	'cloudintegration:settings:label:secure' => 'Permitir servidores no seguros (http)',
	'cloudintegration:settings:help:secure' => 'Activar solo para depuración (no se recomienda para la producción).',
	'cloudintegration:settings:label:url:default' => 'Servidor por defecto de la Nube',
	'cloudintegration:settings:help:url:default' => 'Únicamente servidor seguro (https)',
	'cloudintegration:settings:label:url:custom' => '¿Desea permitir el uso de servidores de Nube externos?',
	'cloudintegration:settings:help:url:custom' => 'El usuario puede elegir un servidor de Nube diferente.',
	'cloudintegration:settings:label:custom:credential' => '¿Desea habilitar un formulario de credenciales para Nube?',
	'cloudintegration:settings:help:custom:credential' => 'Establecer credenciales del servidor de la Nube en la configuración de los usuarios.',
	'cloudintegration:settings:error:cloudintegration:url:secure' => 'Error: el servidor de la Nube no es seguro.',

	// User options
	'cloudintegration:settings:legend:users' => 'Opciones de usuario',
	'cloudintegration:settings:label:own:enable' => '¿Permitir Nube en el espacio de usuario?',
	'cloudintegration:settings:help:own:enable' => 'Si está desactivado, solo aparece en espacios.',

);

?>
