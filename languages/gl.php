<?php

return array(

	'cloudintegration' => 'Nube',
	'cloudintegration:cloudintegrations' => 'Nube',
	'cloudintegration:group:tool:option:enable' => 'Activar a Nube do grupo',

	// General
	'cloudintegration:add' => "Vincular un ficheiro da Nube",
	'cloud:add' => "Vincular un ficheiro da Nube",
	'cloudintegration:edit' => "Editar o Vinculo da Nube",

	'cloudintegration:owner' => "Nube de %s",
	'cloudintegration:friends' => "Nube de contactos",
	'cloudintegration:everyone' => 'Nube de todo o sitio',

	'cloudintegration:download' => "Descargar",
	'cloudintegration:open' => "Abrir nunha xanela nova",
	'cloudintegration:view' => "Ver",
	'cloudintegration:edit' => "Editar",
	'cloudintegration:none' => 'Sen Nube',
	'cloudintegration:nofiles' => 'Non hai ficheiros.',
	'cloudintegration:unknown' => 'Ficheiro compartido descoñecido.',

	'cloudintegration:share' => "Compartir",
	'cloudintegration:share:view:dc' => "Ver descrición e comentarios",
	'cloudintegration:share:get:info' => "O ficheiro compartiuse con anterioridade e utilízase a mesma ligazón.",
	'cloudintegration:share:new' => "Novo recurso compartido",
	'cloudintegration:share:new:info' => "Unha configuración nova do recurso compartido elimina a configuración anterior  <br/> e  borra por completo o recurso compartido anteriormente en Elgg.",
	'cloudintegration:share:create' => "Crear recurso compartido",
	'cloudintegration:share:password:optional' => "Contrasinal (opcional)",
	'cloudintegration:share:password:repeat' => "Repetir contrasinal",

	'cloudintegration:share:sys:correct' => "Ficheiro compartido correctamente",
	'cloudintegration:share:sys:save:correct' => "Ficheiro gardado correctamente",
	'cloudintegration:share:access:error' => "Erro: o ficheiro compartido non se pode escribir",
	'cloudintegration:share:save:error' => "Erro: o ficheiro compartido non se pode gardar",
	'cloudintegration:share:duplicate:error' => "Erro: o ficheiro compartido xa existe",
	'cloudintegration:share:notfound:error' => "Erro: non se localizou o ficheiro compartido",

	'cloudintegration:unshare' => "Deixar de compartir",
	'cloudintegration:unshare:remove:all' => 'Eliminar de Elgg',
	'cloudintegration:unshare:remove:group' => 'Eliminar do grupo',
	'cloudintegration:unshare:remove:here' => 'Eliminar unicamente de aquí',
	'cloudintegration:unshare:remove:owner' => 'Eliminar do seu propio espazo',
	'cloudintegration:unshare:info:shared' => 'Pode deixar de compartir o ficheiro ou eliminalo de Elgg',
	'cloudintegration:unshare:info:noshared' => 'Este ficheiro xa non se comparte desda a Nube ou hai un problema de conexión.',

	'cloudintegration:unshare:sys:correct' => "deixouse de compartir o ficheiro",

	'cloudintegration:group' => 'Documentos nube',
	'cloudintegration:visible:true' => 'Visible',
	'cloudintegration:visible:false' => 'Invisible',
	'cloudintegration:visibility:sys:correct' => 'Visibilidade cambiada correctamente',
	'cloudintegration:visibility:save:error' => 'Problemas ao cambiar a visibilidade',

	// River

	'cloudintegration:notify:summary' => 'Novo ficheiro da Nube compartido chamado %s',
	'cloudintegration:notify:subject' => 'Novo ficheiro da Nube compartido: %s',
	'cloudintegration:notify:body' =>
'%s engadido un novo ficheiro da Nube compartido: %s

Ligazón: %s

%s

Mira e comenta o ficheiro da Nube compartido:
%s
',

	'river:create:object:cloudintegration' => '%s compartiu %s',
	'river:comment:object:cloudintegration' => '%s comenta no ficheiro da Nube compartido %s',
	'cloudintegration:river:annotate' => 'un comentario no ficheiro da Nube compartido',
	'cloudintegration:river:item' => 'un item',

	//
	// Api
	// ********

	'cloudintegration:api:sharetype:0' => 'Usuario',
	'cloudintegration:api:sharetypes:0' => 'Usuarios',
	'cloudintegration:api:sharetype:1' => 'Grupo',
	'cloudintegration:api:sharetypes:1' => 'Grupos',
	'cloudintegration:api:sharetype:3' => 'Ligazón pública',
	'cloudintegration:api:sharetypes:3' => 'Ligazóns públicas',

	'cloudintegration:api:permissions:1' => 'Ler',
	'cloudintegration:api:permissions:2' => 'Actualizar',
	'cloudintegration:api:permissions:4' => 'Crear',
	'cloudintegration:api:permissions:8' => 'Borrar',
	'cloudintegration:api:permissions:16' => 'Compartir',
	'cloudintegration:api:permissions:31' => 'Todo',

	//
	// Widgets
	// ********

	// Shares
	'cloudintegration:widgets:shares:name' => 'Ficheiros da Nube compartidos',
	'cloudintegration:widgets:shares:description' => 'Compartir os seus propios ficheiros públicos desda a Nube.',
	'cloudintegration:widgets:shares:number:label' => 'Número de ficheiros compartidos para mostrar',
	'cloudintegration:widgets:shares:toshare:label' => 'Para compartir',
	'cloudintegration:widgets:shares:toshare:op:public' => 'Só ficheiros públicos',
	'cloudintegration:widgets:shares:toshare:op:all' => 'Todos os meus ficheiros compartidos',
	'cloudintegration:widgets:shares:noshare' => 'Non hai ficheiros compartidos.',
	'cloudintegration:widgets:shares:folder:label' => 'Cartafol para compartir',
	'cloudintegration:widgets:shares:error' => 'Erro Nube',

	// MetaShares
	'cloudintegration:widgets:metashares:name' => 'Ficheiros compartidos',
	'cloudintegration:widgets:metashares:description' => 'Comparta os seus ficheiros da Nube.',
	'cloudintegration:widgets:metashares:number:label' => 'Número de ficheiros para mostrar',
	'cloudintegration:widgets:metashares:noshare' => 'Non compartiu ficheiros.',

	// 
	// Settings
	// ********

	// User Settings
	'cloudintegration:usersettings:message' => '', //Descriptive message
	'cloudintegration:usersettings:label:cloudintegration:url' => 'URL do servidor da Nube (só https)',
	'cloudintegration:usersettings:help:cloudintegration:url' => 'Se fica en branco, utilizarase o URL por defecto.',
	'cloudintegration:usersettings:legend:credentials' => 'Credenciais da Nube',
	'cloudintegration:usersettings:label:credential:user' => 'Usuario',
	'cloudintegration:usersettings:label:credential:password' => 'Contrasinal',
	'cloudintegration:usersettings:label:credential:passwordagain' => 'Repetir contrasinal',
	'cloudintegration:usersettings:label:credential:unlink' => 'Desvincular conta?',
	'cloudintegration:usersettings:error:password' => 'Erro: contrasinal non válido',
	'cloudintegration:usersettings:error:credential' => 'Erro: as credenciais non son válidas',
	'cloudintegration:usersettings:error:empty' => 'Erro: non se gardaron as credenciais, campos baleiros',
	'cloudintegration:usersettings:info:misconfigured' => 'A conta da Nube está mal configurada.',
	'cloudintegration:usersettings:info:configure:here' => 'Configurar',

	// General
	'cloudintegration:settings:legend:general' => 'Xeral',
	'cloudintegration:settings:label:secure' => 'Permitir servidores non seguros (http)',
	'cloudintegration:settings:help:secure' => 'Activar só para depuración (non se recomenda para a produción).',
	'cloudintegration:settings:label:url:default' => 'Servidor por defecto da Nube',
	'cloudintegration:settings:help:url:default' => 'Unicamente servidor seguro (https)',
	'cloudintegration:settings:label:url:custom' => 'Quere permitir o uso de servidores da Nube externos?',
	'cloudintegration:settings:help:url:custom' => 'O usuario pode indicar un servidor da Nube diferente.',
	'cloudintegration:settings:label:custom:credential' => 'Quere activar un formulario de credenciais para a Nube?',
	'cloudintegration:settings:help:custom:credential' => 'Establecer credenciais do servidor da Nube na configuración dos usuarios.',
	'cloudintegration:settings:error:cloudintegration:url:secure' => 'Erro: o servidor da Nube non é seguro.',

	// User options
	'cloudintegration:settings:legend:users' => 'Opcións de usuario',
	'cloudintegration:settings:label:own:enable' => 'Permitir a Nube no espazo de usuario?',
	'cloudintegration:settings:help:own:enable' => 'Se está desactivado, só aparece en espazos.',

);

?>
