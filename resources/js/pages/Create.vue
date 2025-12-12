<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Add Product</h3>
          </div>
          <div class="card-body">
            <form @submit.prevent="submit" enctype="multipart/form-data">
              <!-- Name -->
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input v-model="form.name" type="text"
                       class="form-control" :class="{ 'is-invalid': form.errors.name }" />
                <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name[0] }}</div>
              </div>

              <!-- SKU -->
              <div class="mb-3">
                <label class="form-label">SKU</label>
                <input v-model="form.sku" type="text"
                       class="form-control" :class="{ 'is-invalid': form.errors.sku }" />
                <div v-if="form.errors.sku" class="invalid-feedback">{{ form.errors.sku[0] }}</div>
              </div>

              <!-- Price -->
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input v-model="form.price" type="number"
                       class="form-control" :class="{ 'is-invalid': form.errors.price }" />
                <div v-if="form.errors.price" class="invalid-feedback">{{ form.errors.price[0] }}</div>
              </div>

              <!-- Stock Quantity -->
              <div class="mb-3">
                <label class="form-label">Stock Quantity</label>
                <input v-model="form.stock_quantity" type="number"
                       class="form-control" :class="{ 'is-invalid': form.errors.stock_quantity }" />
                <div v-if="form.errors.stock_quantity" class="invalid-feedback">{{ form.errors.stock_quantity[0] }}</div>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea v-model="form.description" class="form-control" rows="3"
                          :class="{ 'is-invalid': form.errors.description }"></textarea>
                <div v-if="form.errors.description" class="invalid-feedback">{{ form.errors.description[0] }}</div>
              </div>

              <!-- Image Upload -->
              <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" @change="handleFileChange"
                       class="form-control" :class="{ 'is-invalid': form.errors.image }" />
                <div v-if="form.errors.image" class="invalid-feedback">{{ form.errors.image[0] }}</div>
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-success" :disabled="form.processing">
                  <span v-if="form.processing" class="spinner-border spinner-border-sm"></span>
                  Save Product
                </button>
              </div>
            </form>

            <!-- Success Message -->
            <div v-if="successMessage" class="alert alert-success mt-3">
              {{ successMessage }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const successMessage = ref('')

const form = useForm({
    name: '',
    sku: '',
    price: '',
    stock_quantity: '',
    description: '',
    image: null, // Add image field
})

// Handle file selection
function handleFileChange(event) {
    const file = event.target.files[0]
    form.image = file ? file : null
}

// Submit form
function submit() {
    form.post('/products', {
        onError: (errors) => console.log(errors),
        onSuccess: () => {
            form.reset()
            successMessage.value = 'Product added successfully!'
        },
    })
}
</script>
