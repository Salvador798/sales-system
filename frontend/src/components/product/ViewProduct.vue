<script>
import CreateProduct from "./CreateProduct.vue";

export default {
  components: {
    CreateProduct,
  },
  data() {
    return {
      categories: [],
      brands: [],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      this.categories = await fetch(
        "http://127.0.0.1:8000/api/categories"
      ).then((res) => res.json());
      this.brands = await fetch("http://127.0.0.1:8000/api/brands").then(
        (res) => res.json()
      );
    },
  },
};
</script>

<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Productos</h1>
    <o class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
      <li class="breadcrumb-item active">Productos</li>
    </o>

    <div class="mb-4">
      <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createProductModal"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <table id="productsTable" class="table table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center"></tbody>
        </table>
      </div>
    </div>
    <CreateProduct
      :categories="categories"
      :brands="brands"
      @product-added=""
    />
  </div>
</template>
