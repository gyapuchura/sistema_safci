SELECT idintegrante_subsector_salud, idintegrante_cf FROM integrante_subsector_salud AS child 
WHERE idintegrante_cf IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM integrante_cf AS parent WHERE parent.idintegrante_cf = child.idintegrante_cf );

SELECT idintegrante_defuncion, idintegrante_cf FROM integrante_defuncion AS child 
WHERE idintegrante_cf IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM integrante_cf AS parent WHERE parent.idintegrante_cf = child.idintegrante_cf );

SELECT idintegrante_datos_cf, idintegrante_cf FROM integrante_datos_cf AS child 
WHERE idintegrante_cf IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM integrante_cf AS parent WHERE parent.idintegrante_cf = child.idintegrante_cf );

SELECT idintegrante_beneficiario, idintegrante_cf FROM integrante_beneficiario AS child 
WHERE idintegrante_cf IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM integrante_cf AS parent WHERE parent.idintegrante_cf = child.idintegrante_cf );

SELECT idintegrante_tradicional, idintegrante_cf FROM integrante_tradicional AS child 
WHERE idintegrante_cf IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM integrante_cf AS parent WHERE parent.idintegrante_cf = child.idintegrante_cf );

SELECT idintegrante_factor_riesgo, idintegrante_cf FROM integrante_factor_riesgo AS child 
WHERE idintegrante_cf IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM integrante_cf AS parent WHERE parent.idintegrante_cf = child.idintegrante_cf );


SELECT idpersonal, idusuario FROM personal AS child 
WHERE idnombre_datos IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM nombre_datos AS parent WHERE parent.idnombre_datos = child.idnombre_datos );

SELECT idpersonal, idusuario FROM personal AS child 
WHERE idnombre_academico IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM nombre_academico AS parent WHERE parent.idnombre_academico = child.idnombre_academico );

SELECT idpersonal, idusuario FROM personal AS child 
WHERE iddato_laboral IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM dato_laboral AS parent WHERE parent.iddato_laboral = child.iddato_laboral );

SELECT idtratamiento, idevento_safci FROM tratamiento AS child 
WHERE iddiagnostico_atencion IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM diagnostico_atencion AS parent WHERE parent.iddiagnostico_atencion = child.iddiagnostico_atencion );

SELECT idtratamiento, idevento_safci FROM tratamiento AS child 
WHERE idprocedencia_medicamento IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM procedencia_medicamento AS parent WHERE parent.idprocedencia_medicamento = child.idprocedencia_medicamento );

SELECT idvacunacion_anim, idevento_vacunacion FROM vacunacion_anim AS child 
WHERE idevento_vacunacion IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM evento_vacunacion AS parent WHERE parent.idevento_vacunacion = child.idevento_vacunacion );

SELECT idevento, idestado_registro FROM evento AS child 
WHERE idestado_registro IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM estado_registro AS parent WHERE parent.idestado_registro = child.idestado_registro );

SELECT idevento, idtipo_inscripcion FROM evento AS child 
WHERE idtipo_inscripcion IS NOT NULL AND NOT EXISTS 
( SELECT NULL FROM tipo_inscripcion AS parent WHERE parent.idtipo_inscripcion = child.idtipo_inscripcion );