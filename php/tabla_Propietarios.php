<?php
ob_start();  // Inicia el almacenamiento en el buffer de salida
include '../templates/header.php';


?>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="../index.html">
          <i class="bi bi-grid"></i>
          <span>Inicio</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tablas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="tabla_Automoviles.php">
              <i class="bi bi-circle"></i><span>Automoviles</span>
            </a>
          </li>
          <li>
            <a href="tabla_Propietarios.php">
              <i class="bi bi-circle"></i><span>Propietarios</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Tables Nav -->
    </ul>

  </aside>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Tabla Propietarios</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
          <li class="breadcrumb-item">Tablas</li>
          <li class="breadcrumb-item active">Propietarios</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Clientes</h5>
              <div class="d-flex justify-content-end mb-3">
              <a href="agregar_Automovil.php" class="btn btn-primary">Agregar Propietario</a>
            </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Tipo de Propietarios</th>
                    <th>Documentación</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>


          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Clientes y sus automoviles</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Documentación</th>
                    <th>Placa</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
        </div>
      </div>
    </section>

  </main>
  <!-- End #main -->

<!-- ======= Footer ======= -->
  <?php
ob_end_flush(); 
include '../templates/footer.php'; ?>
