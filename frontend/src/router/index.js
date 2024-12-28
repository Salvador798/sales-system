import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../components/dashboard/Dashboard.vue";
import ViewCategory from "../components/category/ViewCategory.vue";
import ViewBrand from "../components/brand/ViewBrand.vue";
import ViewClient from "../components/client/ViewClient.vue";
import ViewSupplier from "../components/supplier/ViewSupplier.vue";
import ViewProduct from "../components/product/ViewProduct.vue";

const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
  },
  {
    path: "/category",
    name: "ViewCategory",
    component: ViewCategory,
  },
  {
    path: "/brand",
    name: "ViewBrands",
    component: ViewBrand,
  },
  {
    path: "/client",
    name: "ViewClient",
    component: ViewClient,
  },
  {
    path: "/supplier",
    name: "ViewSupplier",
    component: ViewSupplier,
  },
  {
    path: "/product",
    name: "ViewProduct",
    component: ViewProduct,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
