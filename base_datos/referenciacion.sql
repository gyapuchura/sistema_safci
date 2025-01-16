ALTER TABLE carpeta_familiar ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE carpeta_familiar ADD FOREIGN KEY (idred_salud) REFERENCES red_salud (idred_salud);
ALTER TABLE carpeta_familiar ADD FOREIGN KEY (idestablecimiento_salud) REFERENCES establecimiento_salud (idestablecimiento_salud);
ALTER TABLE carpeta_familiar ADD FOREIGN KEY (idmunicipio) REFERENCES municipios (idmunicipio);
ALTER TABLE carpeta_familiar ADD FOREIGN KEY (idarea_influencia) REFERENCES area_influencia (idarea_influencia);
ALTER TABLE carpeta_familiar ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE carpeta_familiar ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE determinante_salud_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE determinante_salud_cf ADD FOREIGN KEY (iddeterminante_salud) REFERENCES determinante_salud (iddeterminante_salud);
ALTER TABLE determinante_salud_cf ADD FOREIGN KEY (idcat_determinante_salud) REFERENCES cat_determinante_salud (idcat_determinante_salud);
ALTER TABLE determinante_salud_cf ADD FOREIGN KEY (iditem_determinante_salud) REFERENCES item_determinante_salud (iditem_determinante_salud);
ALTER TABLE determinante_salud_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE item_determinante_salud ADD FOREIGN KEY (iddeterminante_salud) REFERENCES determinante_salud (iddeterminante_salud);
ALTER TABLE item_determinante_salud ADD FOREIGN KEY (idcat_determinante_salud) REFERENCES cat_determinante_salud (idcat_determinante_salud);

ALTER TABLE cat_determinante_salud ADD FOREIGN KEY (iddeterminante_salud) REFERENCES determinante_salud (iddeterminante_salud);

ALTER TABLE usuarios ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);

ALTER TABLE integrante_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE area_influencia ADD FOREIGN KEY (idtipo_area_influencia) REFERENCES tipo_area_influencia (idtipo_area_influencia);
ALTER TABLE area_influencia ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE area_influencia ADD FOREIGN KEY (idred_salud) REFERENCES red_salud (idred_salud);
ALTER TABLE area_influencia ADD FOREIGN KEY (idestablecimiento_salud) REFERENCES establecimiento_salud (idestablecimiento_salud);
ALTER TABLE area_influencia ADD FOREIGN KEY (idnacion) REFERENCES nacion (idnacion);
ALTER TABLE area_influencia ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE ubicacion_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE ubicacion_cf ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE ubicacion_cf ADD FOREIGN KEY (idred_salud) REFERENCES red_salud (idred_salud);
ALTER TABLE ubicacion_cf ADD FOREIGN KEY (idmunicipio) REFERENCES municipios (idmunicipio);
ALTER TABLE ubicacion_cf ADD FOREIGN KEY (idestablecimiento_salud) REFERENCES establecimiento_salud (idestablecimiento_salud);
ALTER TABLE ubicacion_cf ADD FOREIGN KEY (idarea_influencia) REFERENCES area_influencia (idarea_influencia);
ALTER TABLE ubicacion_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE transporte_cf ADD FOREIGN KEY (idtransporte) REFERENCES transporte (idtransporte);
ALTER TABLE transporte_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE idioma_cf ADD FOREIGN KEY (ididioma) REFERENCES idioma (ididioma);
ALTER TABLE idioma_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE idioma_cf ADD FOREIGN KEY (idorigen_idioma) REFERENCES origen_idioma (idorigen_idioma);
ALTER TABLE integrante_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_cf ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre); 
ALTER TABLE integrante_cf ADD FOREIGN KEY (idgrupo_etareo_cf) REFERENCES grupo_etareo_cf (idgrupo_etareo_cf);
ALTER TABLE integrante_cf ADD FOREIGN KEY (idparentesco) REFERENCES parentesco (idparentesco);
ALTER TABLE integrante_cf ADD FOREIGN KEY (idnacion) REFERENCES nacion (idnacion);
ALTER TABLE integrante_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE nombre ADD FOREIGN KEY (idgenero) REFERENCES genero (idgenero);
ALTER TABLE nombre ADD FOREIGN KEY (idnacionalidad) REFERENCES nacionalidad (idnacionalidad);
ALTER TABLE integrante_ap_sano ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_ap_sano ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_ap_sano ADD FOREIGN KEY (idgrupo_cf) REFERENCES grupo_cf (idgrupo_cf);
ALTER TABLE integrante_ap_sano ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE integrante_factor_riesgo ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_factor_riesgo ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_factor_riesgo ADD FOREIGN KEY (idgrupo_cf) REFERENCES grupo_cf (idgrupo_cf);
ALTER TABLE integrante_factor_riesgo ADD FOREIGN KEY (idfactor_riesgo_cf) REFERENCES factor_riesgo_cf (idfactor_riesgo_cf);
ALTER TABLE integrante_factor_riesgo ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE integrante_morbilidad ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_morbilidad ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_morbilidad ADD FOREIGN KEY (idgrupo_cf) REFERENCES grupo_cf (idgrupo_cf);
ALTER TABLE integrante_morbilidad ADD FOREIGN KEY (idmorbilidad_cf) REFERENCES morbilidad_cf (idmorbilidad_cf);
ALTER TABLE integrante_morbilidad ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE integrante_discapacidad ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_discapacidad ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_discapacidad ADD FOREIGN KEY (idgrupo_cf) REFERENCES grupo_cf (idgrupo_cf);
ALTER TABLE integrante_discapacidad ADD FOREIGN KEY (idtipo_discapacidad_cf) REFERENCES tipo_discapacidad_cf (idtipo_discapacidad_cf);
ALTER TABLE integrante_discapacidad ADD FOREIGN KEY (idnivel_discapacidad_cf) REFERENCES nivel_discapacidad_cf (idnivel_discapacidad_cf);
ALTER TABLE integrante_discapacidad ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrant (idintegrante_cf);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idestado_civil) REFERENCES estado_civil (idestado_civil);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idnivel_instruccion) REFERENCES nivel_instruccion (idnivel_instruccion);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idprofesion) REFERENCES profesion (idprofesion);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idcontribuye_cf) REFERENCES contribuye_cf (idcontribuye_cf);
ALTER TABLE integrante_datos_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);


ALTER TABLE red_salud ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);

ALTER TABLE municipios ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);

ALTER TABLE municipios ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE municipios ADD FOREIGN KEY (idprovincia) REFERENCES provincias (idprovincia);

ALTER TABLE provincias ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);

ALTER TABLE establecimiento_salud ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idred_salud) REFERENCES red_salud (idred_salud);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idmunicipio) REFERENCES municipios (idmunicipio);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idtipo_establecimiento) REFERENCES tipo_establecimiento (idtipo_establecimiento);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idnivel_establecimiento) REFERENCES nivel_establecimiento (idnivel_establecimiento);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idsubsector_salud) REFERENCES subsector_salud (idsubsector_salud);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (iddependencia_institucion) REFERENCES dependencia_institucion (iddependencia_institucion);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idambito_local) REFERENCES ambito_local (idambito_local);
ALTER TABLE establecimiento_salud ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE integrante_defuncion ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_defuncion ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_defuncion ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE integrante_subsector_salud ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_subsector_salud ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_subsector_salud ADD FOREIGN KEY (idsubsector_salud) REFERENCES subsector_salud (idsubsector_salud);
ALTER TABLE integrante_subsector_salud ADD FOREIGN KEY (idsubsector_elige) REFERENCES subsector_elige (idsubsector_elige);
ALTER TABLE integrante_subsector_salud ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE integrante_beneficiario ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_beneficiario ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_beneficiario ADD FOREIGN KEY (idprograma_social) REFERENCES programa_social (idprograma_social);
ALTER TABLE integrante_beneficiario ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE integrante_tradicional ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE integrante_tradicional ADD FOREIGN KEY (idintegrante_cf) REFERENCES integrante_cf (idintegrante_cf);
ALTER TABLE integrante_tradicional ADD FOREIGN KEY (idmedicina_tradicional) REFERENCES medicina_tradicional (idmedicina_tradicional);
ALTER TABLE integrante_tradicional ADD FOREIGN KEY (idlugar_atencion_trad) REFERENCES lugar_atencion_trad (idlugar_atencion_trad);
ALTER TABLE integrante_tradicional ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE socio_economica_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE socio_economica_cf ADD FOREIGN KEY (idsocio_economica) REFERENCES socio_economica (idsocio_economica);
ALTER TABLE socio_economica_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE tenencia_animales_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE tenencia_animales_cf ADD FOREIGN KEY (idtenencia_animales) REFERENCES tenencia_animales (idtenencia_animales);
ALTER TABLE tenencia_animales_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE estructura_familiar_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE estructura_familiar_cf ADD FOREIGN KEY (idestructura_familiar) REFERENCES estructura_familiar (idestructura_familiar);
ALTER TABLE estructura_familiar_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE etapa_familiar_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE etapa_familiar_cf ADD FOREIGN KEY (idetapa_familiar) REFERENCES etapa_familiar (idetapa_familiar);
ALTER TABLE etapa_familiar_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE funcionalidad_familiar_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE funcionalidad_familiar_cf ADD FOREIGN KEY (idfuncionalidad_familiar) REFERENCES funcionalidad_familiar (idfuncionalidad_familiar);
ALTER TABLE funcionalidad_familiar_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE evaluacion_salud_familiar_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE evaluacion_salud_familiar_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE ayuda_familiar_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE ayuda_familiar_cf ADD FOREIGN KEY (idayuda_familiar) REFERENCES ayuda_familiar (idayuda_familiar);
ALTER TABLE ayuda_familiar_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE evaluacion_familiar_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE evaluacion_familiar_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE notificacion_ep ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE notificacion_ep ADD FOREIGN KEY (idmunicipio) REFERENCES municipios (idmunicipio);
ALTER TABLE notificacion_ep ADD FOREIGN KEY (idred_salud) REFERENCES red_salud (idred_salud);
ALTER TABLE notificacion_ep ADD FOREIGN KEY (idestablecimiento_salud) REFERENCES establecimiento_salud (idestablecimiento_salud);
ALTER TABLE notificacion_ep ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
 
ALTER TABLE registro_enfermedad ADD FOREIGN KEY (idnotificacion_ep) REFERENCES notificacion_ep (idnotificacion_ep);
ALTER TABLE registro_enfermedad ADD FOREIGN KEY (idsospecha_diag) REFERENCES sospecha_diag (idsospecha_diag);
ALTER TABLE registro_enfermedad ADD FOREIGN KEY (idgrupo_etareo) REFERENCES grupo_etareo (idgrupo_etareo);
ALTER TABLE registro_enfermedad ADD FOREIGN KEY (idgenero) REFERENCES genero (idgenero);
ALTER TABLE registro_enfermedad ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE sospecha_diag ADD FOREIGN KEY (idcat_registro) REFERENCES cat_registro (idcat_registro);
 
ALTER TABLE registro_evento_notificacion ADD FOREIGN KEY (idnotificacion_ep) REFERENCES notificacion_ep (idnotificacion_ep);
ALTER TABLE registro_evento_notificacion ADD FOREIGN KEY (idevento_notificacion) REFERENCES evento_notificacion (idevento_notificacion);
ALTER TABLE registro_evento_notificacion ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE personal ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE personal ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE personal ADD FOREIGN KEY (idnombre_datos) REFERENCES nombre_datos (idnombre_datos);
ALTER TABLE personal ADD FOREIGN KEY (idnombre_academico) REFERENCES nombre_academico (idnombre_academico);
ALTER TABLE personal ADD FOREIGN KEY (iddato_laboral) REFERENCES dato_laboral (iddato_laboral);
ALTER TABLE personal ADD FOREIGN KEY (idestado_personal) REFERENCES estado_personal (idestado_personal);

ALTER TABLE nombre_datos ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE nombre_datos ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE nombre_datos ADD FOREIGN KEY (idformacion_academica) REFERENCES formacion_academica (idformacion_academica);
ALTER TABLE nombre_datos ADD FOREIGN KEY (idprofesion) REFERENCES profesion (idprofesion);
ALTER TABLE nombre_datos ADD FOREIGN KEY (idespecialidad_medica) REFERENCES especialidad_medica (idespecialidad_medica);
ALTER TABLE nombre_datos ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);

ALTER TABLE nombre_academico ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE nombre_academico ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE nombre_academico ADD FOREIGN KEY (idprofesion) REFERENCES profesion (idprofesion);
ALTER TABLE nombre_academico ADD FOREIGN KEY (idespecialidad_medica) REFERENCES especialidad_medica (idespecialidad_medica);
ALTER TABLE nombre_academico ADD FOREIGN KEY (idformacion_academica) REFERENCES formacion_academica (idformacion_academica);

ALTER TABLE dato_laboral ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE dato_laboral ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE dato_laboral ADD FOREIGN KEY (iddependencia) REFERENCES dependencia (iddependencia);

ALTER TABLE evento_safci ADD FOREIGN KEY (iddepartamento) REFERENCES departamento (iddepartamento);
ALTER TABLE evento_safci ADD FOREIGN KEY (idmunicipio) REFERENCES municipios (idmunicipio);
ALTER TABLE evento_safci ADD FOREIGN KEY (idestablecimiento_salud) REFERENCES establecimiento_salud (idestablecimiento_salud);
ALTER TABLE evento_safci ADD FOREIGN KEY (idcat_evento_safci) REFERENCES cat_evento_safci (idcat_evento_safci);
ALTER TABLE evento_safci ADD FOREIGN KEY (idtipo_evento_safci) REFERENCES tipo_evento_safci (idtipo_evento_safci);
ALTER TABLE evento_safci ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE atencion_safci ADD FOREIGN KEY (idevento_safci) REFERENCES evento_safci (idevento_safci);
ALTER TABLE atencion_safci ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE atencion_safci ADD FOREIGN KEY (idarea_influencia) REFERENCES area_influencia (idarea_influencia);
ALTER TABLE atencion_safci ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE especialidad_atencion ADD FOREIGN KEY (idevento_safci) REFERENCES evento_safci (idevento_safci);
ALTER TABLE especialidad_atencion ADD FOREIGN KEY (idatencion_safci) REFERENCES atencion_safci (idatencion_safci);
ALTER TABLE especialidad_atencion ADD FOREIGN KEY (idespecialidad_medica) REFERENCES especialidad_medica (idespecialidad_medica);
ALTER TABLE especialidad_atencion ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE especialidad_atencion ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE diagnostico_atencion ADD FOREIGN KEY (idevento_safci) REFERENCES evento_safci (idevento_safci);
ALTER TABLE diagnostico_atencion ADD FOREIGN KEY (idatencion_safci) REFERENCES atencion_safci (idatencion_safci);
ALTER TABLE diagnostico_atencion ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE diagnostico_atencion ADD FOREIGN KEY (idpatologia) REFERENCES patologia (idpatologia);
ALTER TABLE diagnostico_atencion ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE tratamiento ADD FOREIGN KEY (idevento_safci) REFERENCES evento_safci (idevento_safci);
ALTER TABLE tratamiento ADD FOREIGN KEY (idatencion_safci) REFERENCES atencion_safci (idatencion_safci);
ALTER TABLE tratamiento ADD FOREIGN KEY (idespecialidad_atencion) REFERENCES especialidad_atencion (idespecialidad_atencion);
ALTER TABLE tratamiento ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE tratamiento ADD FOREIGN KEY (iddiagnostico_atencion) REFERENCES diagnostico_atencion (iddiagnostico_atencion);
ALTER TABLE tratamiento ADD FOREIGN KEY (idpatologia) REFERENCES patologia (idpatologia);
ALTER TABLE tratamiento ADD FOREIGN KEY (idtipo_medicamento) REFERENCES tipo_medicamento (idtipo_medicamento);
ALTER TABLE tratamiento ADD FOREIGN KEY (idmedicamento) REFERENCES medicamento (idmedicamento);

ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idficha_ep) REFERENCES ficha_ep (idficha_ep);
ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idregistro_enfermedad) REFERENCES registro_enfermedad (idregistro_enfermedad);
ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idnotificacion_ep) REFERENCES notificacion_ep (idnotificacion_ep);
ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idsospecha_diag) REFERENCES sospecha_diag (idsospecha_diag);
ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idsemana_ep) REFERENCES semana_ep (idsemana_ep);
ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idestado_paciente) REFERENCES estado_paciente (idestado_paciente);
ALTER TABLE seguimiento_ep ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE ficha_ep ADD FOREIGN KEY (idnotificacion_ep) REFERENCES notificacion_ep (idnotificacion_ep);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idregistro_enfermedad) REFERENCES registro_enfermedad (idregistro_enfermedad);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idsospecha_diag) REFERENCES sospecha_diag (idsospecha_diag);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idgrupo_etareo) REFERENCES grupo_etareo (idgrupo_etareo);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idgenero) REFERENCES genero (idgenero);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);

ALTER TABLE idioma_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE transporte_cf ADD FOREIGN KEY (idcarpeta_familiar) REFERENCES carpeta_familiar (idcarpeta_familiar);
ALTER TABLE transporte_cf ADD FOREIGN KEY (idusuario) REFERENCES usuarios (idusuario);

ALTER TABLE ficha_ep ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);
ALTER TABLE ficha_ep ADD FOREIGN KEY (idnombre) REFERENCES nombre (idnombre);


