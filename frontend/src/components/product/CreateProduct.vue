<script>
import Swal from "sweetalert2";

export default {
  props: {
    categories: Array,
    brands: Array,
  },
  data() {
    return {
      product: {
        code: "",
        description: "",
        sale_price: "",
        purchase_price: "",
        category_id: null,
        brand_id: null,
      },
    };
  },
  methods: {
    async submitProduct() {
      try {
        const response = fetch("http://127.0.0.1:8000/api/products", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.product),
        });

        if (!response.ok) {
          throw new Error("Error al registrar el producto");
        }

        const data = await response.json();
        this.$emit("product-added", data);
        this.product.code = "";
        this.product.description = "";
        this.product.sale_price = "";
        this.product.purchase_price = "";
        this.product.category_id = null;
        this.product.brand_id = null;

        const modal = bootstrap.Modal.getInstance(
          document.getElementById("createProductModal")
        );
        modal.hide();

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Producto registrado",
          text: "El producto se ha registrado correctamente.",
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al registrar el producto:", error);

        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error al registrar el producto",
          text: "Ocurrió un error al registrar el producto.",
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
    id="createProductModal"
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
          <h5 class="modal-title" id="modalTitleId">Crear Producto</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitProduct">
            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="code"
                    v-model="product.code"
                    placeholder="Código"
                    required
                  />
                  <label for="code">Código</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="description"
                    v-model="product.description"
                    placeholder="Descripción"
                    required
                  />
                  <label for="description">Descripción</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="sale_price"
                    v-model="product.sale_price"
                    placeholder="Precio de Venta"
                    required
                  />
                  <label for="name">Precio Venta</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="purchase_price"
                    v-model="product.purchase_price"
                    placeholder="Precio de Compra"
                    required
                  />
                  <label for="name">Precio Compra</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <select
                    class="form-select"
                    v-model="product.category_id"
                    required
                  >
                    <option value="" disabled selected>
                      Seleccione una categoría
                    </option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                  <label for="name">Categoria</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <select
                    class="form-select"
                    v-model="product.brand_id"
                    required
                  >
                    <option value="" disabled selected>
                      Seleccione una marca
                    </option>
                    <option
                      v-for="brand in brands"
                      :key="brand.id"
                      :value="brand.id"
                    >
                      {{ brand.name }}
                    </option>
                  </select>
                  <label for="name">Marca</label>
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
