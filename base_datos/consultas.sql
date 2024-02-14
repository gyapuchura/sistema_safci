SELECT dato_laboral.idestablecimiento_salud, establecimiento_salud.establecimiento_salud 
FROM personal, dato_laboral, establecimiento_salud 
WHERE personal.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
GROUP BY dato_laboral.idestablecimiento_salud


SELECT dato_laboral.idestablecimiento_salud FROM personal, dato_laboral 
WHERE personal.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.iddepartamento='9' GROUP BY dato_laboral.idestablecimiento_salud


SELECT dato_laboral.idestablecimiento_salud FROM personal, dato_laboral, establecimiento_salud 
WHERE personal.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND establecimiento_salud.latitud !='' AND dato_laboral.iddepartamento='1' 
GROUP BY dato_laboral.idestablecimiento_salud

SELECT dato_laboral.idestablecimiento_salud, establecimiento_salud.establecimiento_salud 
FROM personal, dato_laboral, establecimiento_salud WHERE personal.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND establecimiento_salud.latitud !='' AND dato_laboral.iddepartamento='1' 
GROUP BY dato_laboral.idestablecimiento_salud

/** consulta para los niveles de EESS *****/

SELECT establecimiento_salud.idnivel_establecimiento, nivel_establecimiento.nivel_establecimiento 
FROM personal, dato_laboral, establecimiento_salud, nivel_establecimiento WHERE personal.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND establecimiento_salud.idnivel_establecimiento=nivel_establecimiento.idnivel_establecimiento 
GROUP BY establecimiento_salud.idnivel_establecimiento

/****** establecimientos asociados a personal SAFCI ******/

SELECT dato_laboral.idestablecimiento_salud, establecimiento_salud.establecimiento_salud, establecimiento_salud.latitud, establecimiento_salud.longitud
FROM personal, dato_laboral, establecimiento_salud WHERE personal.iddato_laboral=dato_laboral.iddato_laboral
AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND dato_laboral.iddepartamento='1' AND establecimiento_salud.idnivel_establecimiento='2' GROUP BY dato_laboral.idestablecimiento_salud


/****** cuenta establecimientos asociados a personal SAFCI con latitud y longitud *****/
SELECT dato_laboral.idestablecimiento_salud, establecimiento_salud.establecimiento_salud,
establecimiento_salud.latitud, establecimiento_salud.longitud 
FROM personal, dato_laboral, establecimiento_salud 
WHERE personal.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND establecimiento_salud.latitud !='' AND dato_laboral.iddepartamento='1' 
GROUP BY dato_laboral.idestablecimiento_salud

/** areas de influencia nacional *****/
SELECT area_influencia.idarea_influencia, departamento.departamento, red_salud.red_salud, establecimiento_salud.establecimiento_salud, 
tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia, area_influencia.habitantes, area_influencia.familias, nombre.nombre, nombre.paterno, nombre.materno 
FROM area_influencia, departamento, red_salud, tipo_area_influencia, establecimiento_salud, usuarios, nombre
WHERE area_influencia.iddepartamento=departamento.iddepartamento AND area_influencia.idred_salud=red_salud.idred_salud 
AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND area_influencia.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre ORDER BY area_influencia. DESC 

/******** areas de influencia por depadrtramento y tipo de area de influencia ******/

SELECT area_influencia.idarea_influencia, departamento.departamento, red_salud.red_salud, 
establecimiento_salud.establecimiento_salud, tipo_area_influencia.tipo_area_influencia, area_influencia.area_influencia,
nombre.nombre, nombre.paterno, nombre.materno 
FROM area_influencia, departamento, red_salud, tipo_area_influencia, establecimiento_salud, usuarios, nombre
WHERE area_influencia.iddepartamento=departamento.iddepartamento 
AND area_influencia.idred_salud=red_salud.idred_salud 
AND area_influencia.idtipo_area_influencia=tipo_area_influencia.idtipo_area_influencia 
AND area_influencia.idestablecimiento_salud=establecimiento_salud.idestablecimiento_salud 
AND area_influencia.idusuario=usuarios.idusuario AND usuarios.idnombre=nombre.idnombre 
AND area_influencia.iddepartamento='4' AND area_influencia.idtipo_area_influencia='1' 
ORDER BY area_influencia.idarea_influencia DESC 



/** REPORTE APROBADOS ***/

SELECT inscripcion.idinscripcion, evento.codigo, nombre.ci, nombre.nombre, nombre.paterno, nombre.materno,
departamento.departamento, inscripcion.nota_final, comentario_evaluacion.comentario_evaluacion 
FROM inscripcion, evento, nombre, dato_laboral, departamento, comentario_evaluacion
WHERE inscripcion.idevento=evento.idevento AND inscripcion.idcomentario_evaluacion=comentario_evaluacion.idcomentario_evaluacion AND 
inscripcion.idnombre=nombre.idnombre AND inscripcion.iddato_laboral=dato_laboral.iddato_laboral 
AND dato_laboral.iddepartamento=departamento.iddepartamento AND inscripcion.idestado_inscripcion='2'
AND inscripcion.idevento='11';