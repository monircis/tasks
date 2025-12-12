<template>
  <div class="container py-5">
    <h1 class="text-center mb-4">Products</h1>

    <!-- Add Product Button -->
    <div class="d-flex justify-content-center mb-4">
      <Link href="/products/create" class="btn btn-primary">Add Product</Link>
    </div>
 <!-- Flash message -->
    <div v-if="$page.props.flash.success" class="alert alert-success">
      {{ $page.props.flash.success }}
    </div>
    <!-- Filter Form -->
    <form @submit.prevent="applyFilter" class="row g-3 mb-4 justify-content-center">
      <div class="col-auto">
        <input v-model="filters.name" type="text" class="form-control" placeholder="Filter by Name">
      </div>
      <div class="col-auto">
        <input v-model="filters.sku" type="text" class="form-control" placeholder="Filter by SKU">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-secondary">Filter</button>
        <button type="button" @click="clearFilter" class="btn btn-outline-secondary">Clear</button>
      </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-striped table-bordered shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Image</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.data" :key="product.id">
            <td>{{ product.name }}</td>
            <td>{{ product.sku }}</td>
            <td>{{ product.price }}</td>
            <td>{{ product.stock_quantity }}</td>
            <td> 
              <img v-if="product.image" :src="`http://127.0.0.1:8000/storage/${product.image}`" class="img-thumbnail" width="150" />
              </td>
            <td>{{ product.description }}</td>
            <td class="text-center">
              <Link :href="`/products/${product.id}/edit`" class="btn btn-warning btn-sm me-2">Edit</Link>
              <button @click="destroy(product.id)" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
          <tr v-if="products.data.length === 0">
            <td colspan="5" class="text-center text-muted py-3">No products found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav v-if="products.last_page > 1" class="d-flex justify-content-center mt-4">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: !products.prev_page_url }">
          <a class="page-link" @click.prevent="goPage(products.current_page - 1)">Previous</a>
        </li>
        <li class="page-item" v-for="page in products.last_page" :key="page" :class="{ active: page === products.current_page }">
          <a class="page-link" @click.prevent="goPage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: !products.next_page_url }">
          <a class="page-link" @click.prevent="goPage(products.current_page + 1)">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import { reactive } from 'vue'

const props = defineProps({
  products: Object,
  filters: Object
})

const filters = reactive({
  name: props.filters.name || '',
  sku: props.filters.sku || ''
})

function applyFilter() {
  router.get('/products', { ...filters }, { preserveState: true, replace: true })
}

function clearFilter() {
  filters.name = ''
  filters.sku = ''
  applyFilter()
}

function goPage(page) {
  router.get('/products', { ...filters, page }, { preserveState: true, replace: true })
}

function destroy(id) {
  if (confirm('Are you sure you want to delete this product?')) {
    router.post(`/products/delete/${id}`, { 
      onSuccess: () => router.reload()
    })
  }
}
</script>
