<script>
import Swal from "sweetalert2";

export default {
  props: {
    brand: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      id: null,
      name: "",
    };
  },
  watch: {
    brand: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.id = newVal.id;
          this.name = newVal.name;
        }
      },
    },
  },
  methods: {
    async submitEdit() {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/brands/${this.id}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ name: this.name }),
          }
        );

        if (!response.ok) {
          throw new Error("Error al actualizar la marca");
        }

        const data = await response.json();
        this.$emit("brand-updated", data);

        const modal = bootstrap.Modal.getInstance(
          document.getElementById("editBrandModal")
        );
        modal.hide();

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Marca actualizada",
          text: "La marca se ha actualizado correctamente.",
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al editar la marca:", error);
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text: error.message || "Hubo un problema al editar la marca.",
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
    id="editBrandModal"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    role="dialog"
    aria-labelledby="editModalTitleId"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalTitleId">Editar Categoría</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitEdit">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="editName"
                v-model="name"
                placeholder="Nombre"
                required
              />
              <label for="editName">Nombre</label>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Cerrar
              </button>
              <button type="submit" class="btn btn-primary">
                Guardar Cambios
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
