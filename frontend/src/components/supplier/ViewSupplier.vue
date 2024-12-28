<script>
import CreateSupplier from "./CreateSupplier.vue";
import EditSupplier from "./EditSupplier.vue";
import Swal from "sweetalert2";

export default {
  components: {
    CreateSupplier,
    EditSupplier,
  },
  data() {
    return {
      suppliers: [],
      selectedSupplier: null,
    };
  },
  mounted() {
    this.fetchSuppliers();
  },
  methods: {
    async fetchSuppliers() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/suppliers");
        this.suppliers = await response.json();
      } catch (error) {
        console.error("Error:", error);
      }
    },
    selectSupplier(supplier) {
      this.selectedSupplier = supplier;
    },
    async toggleSupplierStatus(supplier) {
      try {
        const newStatus = supplier.status ? 0 : 1;
        const response = await fetch(
          `http://127.0.0.1:8000/api/suppliers/${supplier.id}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ status: newStatus }),
          }
        );

        if (!response.ok) {
          throw new Error("Error al actualizar el estado del proveedor");
        }

        const data = await response.json();
        supplier.status = data.status;

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: `Proveedor ${
            data.status ? "activado" : "desactivado"
          } correctamente.`,
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al actualizar el estado del proveedor:", error);

        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text: "Error al actualizar el estado del proveedor",
          timer: 1500,
          showConfirmButton: false,
        });
      }
    },
  },
};
</script>

<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Proveedores</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
      <li class="breadcrumb-item active">Proveedores</li>
    </ol>

    <div class="mb-4">
      <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createSupplierModal"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <table class="table table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>Rif</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Teléfono</th>
              <th>Dirección</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="supplier in suppliers" :key="supplier.id">
              <td>{{ supplier.rif }}</td>
              <td>{{ supplier.name }}</td>
              <td>{{ supplier.last_name }}</td>
              <td>{{ supplier.phone }}</td>
              <td>{{ supplier.address }}</td>
              <td>
                <span v-if="supplier.status" class="badge bg-success"
                  >Activo</span
                >
                <span v-else class="badge bg-danger">Inactivo</span>
              </td>
              <td>
                <button
                  v-if="supplier.status"
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#editSuppllierModal"
                  @click="selectSupplier(supplier)"
                >
                  <i class="fas fa-pencil"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  :class="supplier.status ? 'btn-danger' : 'btn-success'"
                  @click="toggleSupplierStatus(supplier)"
                >
                  <i
                    class="fas"
                    :class="supplier.status ? 'fa-lock' : 'fa-key'"
                  ></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <CreateSupplier @supplier-added="fetchSuppliers" />
    <EditSupplier
      :supplier="selectedSupplier"
      @supplier-updated="fetchSuppliers"
    />
  </div>
</template>
