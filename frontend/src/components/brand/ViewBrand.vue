<script>
import CreateBrand from "./CreateBrand.vue";
import EditBrand from "./EditBrand.vue";
import Swal from "sweetalert2";

export default {
  components: {
    CreateBrand,
    EditBrand,
  },
  data() {
    return {
      brands: [],
      selectedBrand: null,
    };
  },
  mounted() {
    this.fetchBrands();
  },
  methods: {
    async fetchBrands() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/brands");
        this.brands = await response.json();
      } catch (error) {
        console.error("Error:", error);
      }
    },
    selectBrand(brand) {
      this.selectedBrand = brand;
    },
    async toggleBrandStatus(brand) {
      try {
        const newStatus = brand.status ? 0 : 1;
        const response = await fetch(
          `http://127.0.0.1:8000/api/brands/${brand.id}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ status: newStatus }),
          }
        );

        if (!response.ok) {
          throw new Error("Error al actualizar el estado de la marca");
        }

        const data = await response.json();
        brand.status = data.status;

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: `Marca ${
            data.status ? "activada" : "desactivada"
          } correctamente.`,
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al actualizar el estado de la marca:", error);
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text:
            error.message ||
            "Hubo un problema al actualizar el estado de la marca.",
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
    <h1 class="mt-4">Marcas</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
      <li class="breadcrumb-item active">Marcas</li>
    </ol>

    <div class="mb-4">
      <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createBrandModal"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <table class="table table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="brand in brands" :key="brand.id">
              <td>{{ brand.name }}</td>
              <td>
                <span v-if="brand.status" class="badge bg-success">Activo</span>
                <span v-else class="badge bg-danger">Inactivo</span>
              </td>
              <td>
                <button
                  v-if="brand.status"
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#editBrandModal"
                  @click="selectBrand(brand)"
                >
                  <i class="fas fa-pencil"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  :class="brand.status ? 'btn-danger' : 'btn-success'"
                  @click="toggleBrandStatus(brand)"
                >
                  <i
                    class="fas"
                    :class="brand.status ? 'fa-lock' : 'fa-key'"
                  ></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <CreateBrand @brand-added="fetchBrands" />
    <EditBrand :brand="selectedBrand" @brand-updated="fetchBrands" />
  </div>
</template>
