<div class="col-4 form-group">
  <label for="iddoc">Tipo de Documento</label>
  <select id="iddoc" name="iddoc" class="form-control input_cliente" required>
    <?php
    foreach ($this->d['documentos'] as $tipo) {
      echo "<option value='$tipo[id]'>$tipo[nombre]</option>";
    }
    ?>
  </select>
  <div class="invalid-feedback">
    Tipo es requerido. Seleccione un tipo
  </div>
</div>

<div class="col-8 form-group">
  <label for="seriedoc">N° Documento</label>
  <div class="input-group">
    <input type="text" id="seriedoc" name="seriedoc" class="form-control input_cliente" pattern="[0-9]+" minlength="8" maxlength="8" required>
    <div class="input-group-append">
      <button class="btn btn-primary" id="search_cliente"><i class="fa fa-search"></i> Buscar</button>
    </div>
    <div class="invalid-feedback">
      seriedoc es requerido y debe tener 8 digitos
    </div>
  </div>
</div>

<div class="col-12 form-group">
  <label for="nombres">Nombres</label>
  <input type="text" id="nombres" name="nombres" class="form-control input_cliente" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ ]+" required>
  <div class="invalid-feedback">
    Nombre es requerido. Ingrese solo letras y espacios
  </div>
</div>

<div class="col-7 form-group">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" class="form-control input_cliente" required>
  <div class="invalid-feedback">
    Email es requerido. Ingrese un email valido
  </div>
</div>

<div class="col-5 form-group">
  <label for="telefono">Teléfono</label>
  <input type="tel" id="telefono" name="telefono" class="form-control input_cliente" pattern="[0-9]+" minlength="9" maxlength="9" required>
  <div class="invalid-feedback">
    Teléfono es requerido. Ingrese un telefono valido
  </div>
</div>

<div class="col-12 form-group">
  <label for="direccion">Dirección</label>
  <input type="text" id="direccion" name="direccion" class="form-control input_cliente" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0-9-. ]+">
  <div class="invalid-feedback">
    Dirección es requerido
  </div>
</div>