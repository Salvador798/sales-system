<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      ci: "",
      name: "",
      last_name: "",
      phone: "",
      address: "",
    };
  },
  methods: {
    async submitClient() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/clients", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            ci: this.ci,
            name: this.name,
            last_name: this.last_name,
            phone: this.phone,
            address: this.address,
          }),
        });

        if (!response.ok) {
          throw new Error("Error al registrar el cliente");
        }

        const data = await response.json();
        this.$emit("client-added", data);
        this.ci = "";
        this.name = "";
        this.last_name = "";
        this.phone = "";
        this.address = "";

        const modal = bootstrap.Modal.getInstance(
          document.getElementById("createClientModal")
        );
        modal.hide();

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Cliente registrado",
          text: "El cliente se ha registrado correctamente.",
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al registrar el cliente:", error);

        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text: error.message || "Hubo un problema al registrar el cliente.",
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
    id="createClientModal"
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
          <h5 class="modal-title" id="modalTitleId">Crear Cliente</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitClient">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control"
                id="ci"
                v-model="ci"
                placeholder="Cédula"
                required
              />
              <label for="name">Cédula</label>
            </div>
            <div class="row">
              <div class="col-md-6">
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
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="last_name"
                    v-model="last_name"
                    placeholder="Apellido"
                    required
                  />
                  <label for="name">Apellido</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="phone"
                    v-model="phone"
                    placeholder="Teléfono"
                    required
                  />
                  <label for="name">Teléfono</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="address"
                    v-model="address"
                    placeholder="Dirección"
                    required
                  />
                  <label for="name">Dirección</label>
                </div>
              </div>
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
