ALTER TABLE `safci_db`.`personal` 
ADD INDEX `idusuario_idx` (`idusuario` ASC);
;
ALTER TABLE `safci_db`.`personal` 
ADD CONSTRAINT `idusuario`
  FOREIGN KEY (`idusuario`)
  REFERENCES `safci_db`.`usuarios` (`idusuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;