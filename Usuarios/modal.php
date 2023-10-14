<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ventana Modal</title>
  <style>
    /* Estilos para la ventana modal */
    dialog {
      width: 300px;
      padding: 20px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    /* Estilos para el botón de cerrar */
    dialog::backdrop {
      background-color: rgba(0, 0, 0, 0.5);
    }

    button {
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <button onclick="mostrarModal()">Abrir Ventana Modal</button>

  <dialog id="modal" close>
    <h2>Ventana Modal</h2>
    <form class="register-form" action="" method="POST">
        <label class="edit-usuario" for="nombre">Nombre de usuario:</label>
        <input class="edit-usuario" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        <label class="edit-usuario" for="rol">Rol:</label>
        <select class="rol-select" name="rol" required>
                        <option value="Trabajador">Trabajador</option>
                        <option value="Dueño">Dueño</option>
                    </select value="<?php echo $rol; ?>" required>
                    <p></p> 
        <input type="submit" value="Guardar Cambios" class="Guardar_usuario">
    </form>
    <p>Contenido de la ventana modal.</p>
    <button onclick="cerrarModal()">Cerrar</button>
  </dialog>

  <script>
    function mostrarModal() {
      const modal = document.getElementById('modal');
      modal.showModal();
    }

    function cerrarModal() {
      const modal = document.getElementById('modal');
      modal.close();
    }
  </script>
</body>
</html>
