<div class="form-group">
  <label for="tipo">Tipo</label>
  <select id="tipo" name="tipo" class="form-control clean_equipo" required>
    <option value="" selected disabled>__ Seleccione __</option>
    <?php
    foreach ($this->d['tipos'] as $tipo) {
      echo "<option value='{$tipo['id']}'>{$tipo['tipo']}</option>";
    }
    ?>
  </select>
  <div class="invalid-feedback">
    Tipo es requerido. Seleccione un tipo
  </div>
</div>

<div class="form-group">
  <label for="modelo">Modelo</label>
  <input type="text" id="modelo" name="modelo" class="form-control clean_equipo" pattern="[A-Za-z0-9 ]+" required>
  <div class="invalid-feedback">
    Modelo es requerido.
  </div>
</div>

<div class="form-group">
  <label for="n_serie">Serie</label>
  <input type="text" id="n_serie" name="n_serie" class="form-control clean_equipo" pattern="[A-Za-z0-9 ]+" required>
  <div class="invalid-feedback">
    Serie es requerido.
  </div>
</div>

<div class="form-group">
  <label for="descripcion">Descripción</label>
  <textarea id="descripcion" name="descripcion" class="form-control clean_equipo" required cols="30" rows="10"></textarea>
  <div class="invalid-feedback">
    Descripción es requerido.
  </div>
</div>