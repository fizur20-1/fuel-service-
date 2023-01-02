package com.controller;

import com.domain.Orders;
import com.domain.Product;
import com.domain.User;
import com.exception.BadRequestAlertException;
import com.service.AdminService;
import org.springframework.beans.propertyeditors.StringTrimmerEditor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@CrossOrigin()
@RestController
@RequestMapping("/admin")
public class AdminController {
    private AdminService adminService;

    public AdminController(AdminService adminService) {
        this.adminService = adminService;
    }

    @InitBinder
    public void initBinder(WebDataBinder webDataBinder) {
        StringTrimmerEditor stringTrimmerEditor = new StringTrimmerEditor(true);
        webDataBinder.registerCustomEditor(String.class, stringTrimmerEditor);
    }

    @GetMapping("/get-all-users")
    public ResponseEntity<List<User>> getAllUsers() {
        List<User> users = adminService.getAllUsers();
        return ResponseEntity.ok().body(users);
    }

    @PostMapping("/add-user")
    public ResponseEntity<String> addUser(@Valid @RequestBody User user) {
        User newUser = adminService.insertUser(user);
        if (newUser.getId() == null) {
            return ResponseEntity.ok().body("Failed to add");
        }
        return ResponseEntity.ok().body("Added");
    }

    @PutMapping("/update-user")
    public ResponseEntity<String> updateUser(@Valid @RequestBody User user) throws Exception {
        if (user.getId() == null) {
            throw new BadRequestAlertException("Invalid User ID");
        }
        adminService.updateUser(user);
        return ResponseEntity.ok().body("Updated");
    }

    @DeleteMapping("/delete-user/{id}")
    public String deleteUser(@PathVariable Long id) {
        if (adminService.deleteUser(id)) return "Deleted";
        else return "Failed to Delete";
    }

    @GetMapping("/get-all-products")
    public ResponseEntity<List<Product>> getAllProducts() {
        List<Product> Products = adminService.getAllProducts();
        return ResponseEntity.ok().body(Products);
    }

    @PostMapping("/add-product")
    public ResponseEntity<String> addProduct(@Valid @RequestBody Product product) {
        Product newProduct = adminService.insertProduct(product);
        if (newProduct.getId() == null) {
            return ResponseEntity.ok().body("Failed to add");
        }
        return ResponseEntity.ok().body("Added");
    }

    @PutMapping("/update-product")
    public ResponseEntity<String> updateProduct(@Valid @RequestBody Product product) throws Exception {
        if (product.getId() == null) {
            throw new BadRequestAlertException("Invalid User ID");
        }
        adminService.updateProduct(product);
        return ResponseEntity.ok().body("Updated");
    }

    @DeleteMapping("/delete-product/{id}")
    public String deleteProduct(@PathVariable Long id) {
        if (adminService.deleteProduct(id)) return "Deleted";
        else return "Failed to Delete";
    }

    @GetMapping("/get-all-orders")
    public ResponseEntity<List<Orders>> getAllOrders() {
        List<Orders> orders = adminService.getAllOrders();
        return ResponseEntity.ok().body(orders);
    }

    @PostMapping("/add-order")
    public ResponseEntity<String> addOrder(@Valid @RequestBody Orders order) {
        Orders newOrder = adminService.insertOrder(order);
        if (newOrder.getId() == null) {
            return ResponseEntity.ok().body("Failed to add");
        }
        return ResponseEntity.ok().body("Added");
    }

    @PutMapping("/update-order")
    public ResponseEntity<String> updateOrder(@Valid @RequestBody Orders order) throws Exception {
        if (order.getId() == null) {
            throw new BadRequestAlertException("Invalid User ID");
        }
        adminService.updateOrder(order);
        return ResponseEntity.ok().body("Updated");
    }

    @DeleteMapping("/delete-order/{id}")
    public ResponseEntity<String> deleteOrder(@PathVariable Long id) {
        if (adminService.deleteOrder(id)) return ResponseEntity.ok().body("Deleted");
        else return ResponseEntity.ok().body("Failed to Delete");
    }
}
