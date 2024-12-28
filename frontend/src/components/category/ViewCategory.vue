<script>
import CreateCategory from "./CreateCategory.vue";
import EditCategory from "./EditCategory.vue";
import Swal from "sweetalert2";

export default {
  components: {
    CreateCategory,
    EditCategory,
  },
  data() {
    return {
      categories: [],
      selectedCategory: null,
    };
  },
  mounted() {
    this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/categories");
        this.categories = await response.json();
      } catch (error) {
        console.error("Error:", error);
      }
    },
    selectCategory(category) {
      this.selectedCategory = category;
    },
    async toggleCategoryStatus(category) {
      try {
        const newStatus = category.status ? 0 : 1;
        const response = await fetch(
          `http://127.0.0.1:8000/api/categories/status/${category.id}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ status: newStatus }),
          }
        );

        if (!response.ok) {
          throw new Error("Error al actualizar el estado de la categoria");
        }

        const data = await response.json();
        category.status = data.status;

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: `Categoría ${
            data.status ? "activada" : "desactivada"
          } correctamente.`,
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al cambiar el estado:", error);

        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text: "Hubo un problema al cambiar el estado de la categoría.",
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
    <h1 class="mt-4">Categoria</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
      <li class="breadcrumb-item active">Categoria</li>
    </ol>

    <div class="mb-4">
      <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createCategoryModal"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <table id="categoriesTable" class="table table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="category in categories" :key="category.id">
              <td>{{ category.name }}</td>
              <td>
                <span v-if="category.status" class="badge bg-success"
                  >Activo</span
                >
                <span v-else class="badge bg-danger">Inactivo</span>
              </td>
              <td>
                <button
                  v-if="category.status"
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#editCategoryModal"
                  @click="selectCategory(category)"
                >
                  <i class="fas fa-pencil"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  :class="category.status ? 'btn-danger' : 'btn-success'"
                  @click="toggleCategoryStatus(category)"
                >
                  <i
                    :class="category.status ? 'fas fa-eye-slash' : 'fas fa-eye'"
                  ></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <CreateCategory @category-added="fetchCategories" />
    <EditCategory
      :category="selectedCategory"
      @category-updated="fetchCategories"
    />
  </div>
</template>
