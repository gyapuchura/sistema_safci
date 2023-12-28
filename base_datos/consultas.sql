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