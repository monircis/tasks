# Laravel 12 Vue 3 Project

This project is built with **Laravel 12**, **Vue 3**, and **Axios**, using Vue Router for frontend routing. It supports CRUD operations, file uploads, and validation handling.

---

## **Requirements**

- PHP >= 8.2  
- Composer  
- Node.js >= 22.00  
- NPM   
- MySQL database  

---

## **Installation Steps**

### 1. Clone the repository
 
- command list
- npm install
- composer install
- php artisan storage:link

## 1. Run project
- npm run dev
- php artisan serve

## 2. Technical Questions
- Dependency Injection : inject a class into a constructor or method
- Facade: A static-like shortcut to access Laravel services from the service container.
- making code to testable, flexible.

- To optimize search for 10,000+ products: 
- Use database indexing 
- Paginate results 
- Select only needed columns

How does Laravel's CSRF protection work with Inertia.js
- Inertia sends requests via XHR / fetch / Axios instead of standard form submissions.

why is it important for form submissions?
- It is  important for form security

What is the N+1 query problem?

-It happens when we load a list of items, and for each item, we run another query to fetch related data.

How to prevent it

- Use Eager Loading with with() in Laravel: (Product::with('category')->get();)
