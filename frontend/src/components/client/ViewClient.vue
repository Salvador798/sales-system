<script>
import CreateClient from "./CreateClient.vue";
import EditClient from "./EditClient.vue";
import Swal from "sweetalert2";

export default {
  components: {
    CreateClient,
    EditClient,
  },
  data() {
    return {
      clients: [],
      selectedClient: null,
    };
  },
  mounted() {
    this.fetchClients();
  },
  methods: {
    async fetchClients() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/clients");
        this.clients = await response.json();
      } catch (error) {
        console.error("Error:", error);
      }
    },
    selectClient(client) {
      this.selectedClient = client;
    },
    async toggleClientStatus(client) {
      try {
        const newStatus = client.status ? 0 : 1;
        const response = await fetch(
          `http://127.0.0.1:8000/api/clients/${client.id}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ status: newStatus }),
          }
        );

        if (!response.ok) {
          throw new Error("Error al actualizar el estado del cliente");
        }

        const data = await response.json();
        client.status = data.status;

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: `Cliente ${
            data.status ? "activado" : "desactivado"
          } correctamente.`,
          timer: 1500,
          showConfirmButton: false,
        });
      } catch (error) {
        console.error("Error al actualizar el estado del cliente:", error);

        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "Error",
          text: "Error al actualizar el estado del cliente",
        });
      }
    },
  },
};
</script>

<template>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Clientes</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
      <li class="breadcrumb-item active">Clientes</li>
    </ol>

    <div class="mb-4">
      <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createClientModal"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <table class="table table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>Cédula</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Teléfono</th>
              <th>Dirección</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="client in clients" :key="client.id">
              <td>{{ client.ci }}</td>
              <td>{{ client.name }}</td>
              <td>{{ client.last_name }}</td>
              <td>{{ client.phone }}</td>
              <td>{{ client.address }}</td>
              <td>
                <span v-if="client.status" class="badge bg-success">
                  Activo
                </span>
                <span v-else class="badge bg-danger">Inactivo</span>
              </td>
              <td>
                <button
                  v-if="client.status"
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#editClientModal"
                  @click="selectClient(client)"
                >
                  <i class="fas fa-pencil"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  :class="client.status ? 'btn-danger' : 'btn-success'"
                  @click="toggleClientStatus(client)"
                >
                  <i
                    class="fas"
                    :class="client.status ? 'fa-lock' : 'fa-key'"
                  ></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <CreateClient @client-added="fetchClients" />
    <EditClient :client="selectedClient" @client-updated="fetchClients" />
  </div>
</template>
