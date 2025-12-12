<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Edit Product</h3>
          </div>

          <div class="card-body">
            <form @submit.prevent="submit" class="card p-4 shadow-sm" enctype="multipart/form-data">

              <!-- Name -->
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }" />
                <div class="invalid-feedback">{{ errors.name }}</div>
              </div>

              <!-- SKU -->
              <div class="mb-3">
                <label class="form-label">SKU</label>
                <input v-model="form.sku" type="text" class="form-control" :class="{ 'is-invalid': errors.sku }" />
                <div class="invalid-feedback">{{ errors.sku }}</div>
              </div>

              <!-- Price -->
              <div class="mb-3">
                <label class="form-label">Price</label>
                <input v-model="form.price" type="number" class="form-control"
                  :class="{ 'is-invalid': errors.price }" />
                <div class="invalid-feedback">{{ errors.price }}</div>
              </div>

              <!-- Stock Quantity -->
              <div class="mb-3">
                <label class="form-label">Stock Quantity</label>
                <input v-model="form.stock_quantity" type="number" class="form-control"
                  :class="{ 'is-invalid': errors.stock_quantity }" />
                <div class="invalid-feedback">{{ errors.stock_quantity }}</div>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea v-model="form.description" class="form-control" rows="4"
                  :class="{ 'is-invalid': errors.description }"></textarea>
                <div class="invalid-feedback">{{ errors.description }}</div>
              </div>

              <!-- Product Image -->
              <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" @change="handleFileChange" class="form-control"
                  :class="{ 'is-invalid': errors.image }" />
                <div class="invalid-feedback">{{ errors.image }}</div>

                <!-- Existing Image Preview -->
                <div v-if="product.image" class="mt-2">
                  <img :src="`http://127.0.0.1:8000/storage/${product.image}`" class="img-thumbnail" width="150" />
                </div>
              </div>

              <!-- Submit Button -->
              <button class="btn btn-primary px-4" :disabled="processing">
                <span v-if="processing" class="spinner-border spinner-border-sm"></span>
                Update
              </button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const props = defineProps({
  product: Object
})

// Form state
const form = reactive({
  name: props.product.name,
  sku: props.product.sku,
  price: props.product.price,
  stock_quantity: props.product.stock_quantity,
  description: props.product.description,
  image: null
})

// Validation errors
const errors = reactive({})

// Loading state
const processing = ref(false)

// Handle file input
function handleFileChange(event) {
  form.image = event.target.files[0] || null
}

// Submit form
async function submit() {
  processing.value = true
  Object.keys(errors).forEach(key => errors[key] = null)

  try {
    const formData = new FormData()
    formData.append('name', form.name)
    formData.append('sku', form.sku)
    formData.append('price', form.price)
    formData.append('stock_quantity', form.stock_quantity)
    formData.append('description', form.description)
    if (form.image) {
      formData.append('image', form.image)
    }

    // Axios PUT request
    await axios.post(`/products/${props.product.id}`, formData, {

    })
    console.log('2');
    window.location.href = '/'
  } catch (err) {
    if (err.response && err.response.status === 422) {
      // Validation errors
      Object.assign(errors, err.response.data.errors)
    } else {
      console.log('3');
    }
  } finally {
    processing.value = false
  }
}
</script>
