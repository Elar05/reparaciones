<div class="col-12 form-group group_marca">
  <label for="tipo">Tipo</label>
  <div class="input-group">
    <select id="tipo" name="tipo" class="form-control select2 input_equipo" style="width: 78%;" required>
      <option value="" selected disabled>__ Seleccione __</option>
    </select>

    <div class="input-group-append">
      <button type="button" class="btn btn-success shadow-none group_tipo group_modelo cancel_add_tipo" id="add_tipo"><i class="fas fa-plus"></i> Agregar</button>
    </div>
  </div>
</div>
<div class="col-12 form-group group_tipo d-none" id="input_new_tipo">
  <label for="new_tipo">Agregar Nuevo Tipo</label>
  <input type="text" class="form-control" id="new_tipo">

  <div class="mt-2 d-flex justify-content-between">
    <button type="button" class="btn btn-danger shadow-none cancel_add_tipo">
      <i class="fas fa-times"></i> Cancelar</button>
    <button type="button" class="btn btn-primary shadow-none" id="save_new_tipo">
      <i class="fas fa-check"></i> Guardar</button>
  </div>
</div>

<div class="col-12 form-group group_tipo">
  <label for="marca">Marca</label>
  <div class="input-group">
    <select id="marca" name="marca" class="form-control select2 input_equipo" style="width: 78%;" required>
      <option value="" selected disabled>__ Seleccione __</option>
    </select>
    <div class="input-group-append">
      <button type="button" class="btn btn-success shadow-none group_marca group_modelo cancel_add_marca" id="add_marca"><i class="fas fa-plus"></i> Agregar</button>
    </div>
  </div>
</div>
<div class="col-12 form-group group_marca d-none" id="input_new_marca">
  <label for="new_marca">Agregar Nueva Marca</label>
  <input type="text" class="form-control" id="new_marca">

  <div class="mt-2 d-flex justify-content-between">
    <button type="button" class="btn btn-danger shadow-none cancel_add_marca">
      <i class="fas fa-times"></i> Cancelar</button>
    <button type="button" class="btn btn-primary shadow-none" id="save_new_marca">
      <i class="fas fa-check"></i> Guardar</button>
  </div>
</div>

<div class="col-12 form-group group_tipo group_marca group_modelo">
  <label for="modelo">Modelo</label>
  <div class="input-group">
    <select id="modelo" name="modelo" class="form-control select2 input_equipo" style="width: 78%;" required>
      <option value="" selected disabled>__ Seleccione __</option>
    </select>

    <div class="input-group-append">
      <button type="button" class="btn btn-success shadow-none cancel_add_modelo" id="add_modelo"><i class="fas fa-plus"></i> Agregar</button>
    </div>
  </div>
</div>
<div class="col-12 form-group group_modelo d-none" id="input_new_modelo">
  <label for="new_modelo">Agregar Nuevo Modelo</label>
  <input type="text" class="form-control" id="new_modelo">

  <div class="mt-2 d-flex justify-content-between">
    <button type="button" class="btn btn-danger shadow-none cancel_add_modelo">
      <i class="fas fa-times"></i> Cancelar</button>
    <button type="button" class="btn btn-primary shadow-none" id="save_new_modelo">
      <i class="fas fa-check"></i> Guardar</button>
  </div>
</div>

<div class="col-12 form-group group_tipo group_marca group_modelo">
  <label for="n_serie">Serie</label>
  <input type="text" id="n_serie" name="n_serie" class="form-control input_equipo" pattern="[A-Za-z0-9 ]+" required>
</div>