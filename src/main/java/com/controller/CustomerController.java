package com.controller;

import com.domain.*;
import com.exception.NotFoundAlertException;
import com.service.AdminService;
import com.service.CustomerService;
import org.springframework.beans.propertyeditors.StringTrimmerEditor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.InitBinder;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.security.Principal;
import java.util.List;
import java.util.Optional;

@CrossOrigin()
@RestController
@RequestMapping("/customer")
public class CustomerController {
    private CustomerService customerService;

    public CustomerController(CustomerService customerService) {
        this.customerService = customerService;
    }

    @InitBinder
    public void initBinder(WebDataBinder webDataBinder) {
        StringTrimmerEditor stringTrimmerEditor = new StringTrimmerEditor(true);
        webDataBinder.registerCustomEditor(String.class, stringTrimmerEditor);
    }

    @GetMapping("/shop")
    public ResponseEntity<List<Product>> getShop() {
        List<Product> products = customerService.getAll();
        return ResponseEntity.ok().body(products);
    }

    @GetMapping("/get-cart/{cart_id}")
    public ResponseEntity<List<Cart>> getCart(@PathVariable String cart_id) {
        Optional<List<Cart>> cart = Optional.ofNullable(customerService.getAllByCartId(cart_id));
        if (cart.isPresent()) {
            return ResponseEntity.ok().body(cart.get());
        }
        throw new NotFoundAlertException("Record not found [" + cart_id + "]");
    }

    @PostMapping("/add-to-cart")
    public ResponseEntity<List<Cart>> addToCart(@Valid @RequestBody Cart cart) {
        Cart newCart = customerService.insertCart(cart);
//        if (newCart.getId() == null) {
//            return ResponseEntity.ok().body("Failed to add");
//        }
//        return ResponseEntity.ok().body("Added");
        return ResponseEntity.ok().body(customerService.getAllByCartId(cart.getCart_id()));
    }

    @DeleteMapping("/remove/{product_id}/from-cart/{cart_id}")
    public ResponseEntity<List<Cart>> deleteUser(@PathVariable Long product_id, @PathVariable String cart_id) {
//        if (customerService.deleteCart(cart_id, product_id)) return "Deleted";
//        else return "Failed to Delete";
        customerService.deleteCart(product_id, cart_id);
        return ResponseEntity.ok().body(customerService.getAllByCartId(cart_id));
    }

    @PostMapping("/order")
    public ResponseEntity<Orders> order(@RequestBody Orders order, Principal principal) {
        return ResponseEntity.ok().body(customerService.order(order, principal));
    }

    @GetMapping("/customer-id")
    public ResponseEntity<Long> getCustomerId(Principal principal) {
        return ResponseEntity.ok().body(customerService.getUserId(principal));
    }
    @GetMapping("/order-history")
    public ResponseEntity<List<Orders>> getOrderHistory(Principal principal) {
        return ResponseEntity.ok().body(customerService.getOrders(principal));
    }
}