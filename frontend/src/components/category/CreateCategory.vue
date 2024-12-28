<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      name: "",
    };
  },
  methods: {
    async submitCategory() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/categories", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ name: this.name }),
        });

        if (!response.ok) {
          throw new Error("Error al registrar la categoria");
        }

        const data = await response.json();
        this.$emit("category-added", data);
        this.name = "";

        const modal = bootstrap.Modal.getInstance(
          document.getElementById("createCategoryModal")
        );
        modal.hide();

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Categoría registrada",
          text: "La categoría se ha registrado correctamente.",
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al registrar la categoría:", error);

        // Mostrar alerta de error
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text: error.message || "Hubo un problema al registrar la categoría.",
          timer: 1500,
          showConfirmButton: false,
        });
      }
    },
  },
};
</script>

<template>
  <div
    class="modal fade"
    id="createCategoryModal"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitleId">Crear Categoria</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitCategory">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="name"
                placeholder="Nombre"
                required
              />
              <label for="name">Nombre</label>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Cerrar
              </button>
              <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
